<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(
        private PaymentManager $paymentManager
    ) {}

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $team = $user->currentTeam ?? $user->teams()->first();

            if (!$team) {
                return response()->json([
                    'success' => false,
                    'message' => 'No team found for this order.',
                ], 422);
            }

            return DB::transaction(function () use ($request, $user, $team) {
                $order = Order::create([
                    'team_id' => $team->id,
                    'user_id' => $user?->id,
                    'payment_method' => PaymentMethod::from($request->payment_method),
                    'currency' => 'USD',
                    'billing_address' => $request->billing_address,
                    'shipping_address' => $request->getShippingAddress(),
                    'notes' => $request->notes,
                ]);

                $subtotalAmount = 0;
                $orderItems = [];

                foreach ($request->items as $item) {
                    $product = Product::where('team_id', $team->id)
                        ->where('id', $item['product_id'])
                        ->where('is_active', true)
                        ->firstOrFail();

                    if (!$product->isInStock() || $product->quantity < $item['quantity']) {
                        throw new \Exception("Product '{$product->name}' is out of stock or insufficient quantity.");
                    }

                    $productPrice = $product->getCurrentPrice();
                    $totalPrice = $productPrice * $item['quantity'];

                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $productPrice,
                        'quantity' => $item['quantity'],
                        'total_price' => $totalPrice,
                    ]);

                    $orderItem->createSnapshot();

                    $subtotalAmount += $totalPrice;

                    $product->decrement('quantity', $item['quantity']);
                }

                $taxAmount = $subtotalAmount * 0.08;
                $totalAmount = $subtotalAmount + $taxAmount;

                $order->update([
                    'subtotal_amount' => $subtotalAmount,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                ]);

                $paymentService = $this->paymentManager->driver($order->payment_method);
                $checkoutResult = $paymentService->createCheckoutSession($order);

                if (!$checkoutResult['success']) {
                    throw new \Exception('Failed to create payment session: ' . ($checkoutResult['error'] ?? 'Unknown error'));
                }

                return response()->json([
                    'success' => true,
                    'order' => $order->load('items.product'),
                    'payment' => $checkoutResult,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Order creation failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Order $order): JsonResponse
    {
        $user = Auth::user();
        
        if ($order->team_id !== ($user->currentTeam?->id ?? $user->teams()->first()?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $order->load(['items.product', 'user']),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $team = $user->currentTeam ?? $user->teams()->first();

        if (!$team) {
            return response()->json([
                'success' => false,
                'message' => 'No team found.',
            ], 422);
        }

        $orders = Order::where('team_id', $team->id)
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $user = Auth::user();
        
        if ($order->team_id !== ($user->currentTeam?->id ?? $user->teams()->first()?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:shipped,cancelled',
        ]);

        try {
            if ($request->status === 'shipped' && $order->canBeShipped()) {
                $order->markAsShipped();
            } elseif ($request->status === 'cancelled' && $order->canBeCancelled()) {
                $order->cancel();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update order status.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'order' => $order->fresh(),
                'message' => "Order status updated to {$order->order_status->getLabel()}.",
            ]);
        } catch (\Exception $e) {
            Log::error('Order status update failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status.',
            ], 500);
        }
    }

    public function paymentSuccess(Request $request): JsonResponse
    {
        try {
            $sessionId = $request->get('session_id');
            
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment session ID is required.',
                ], 422);
            }

            $paymentService = $this->paymentManager->driver(PaymentMethod::Stripe);
            $result = $paymentService->processPayment(['session_id' => $sessionId]);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'order' => $result['order'],
                    'message' => 'Payment completed successfully!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['error'] ?? 'Payment processing failed.',
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment success callback failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 500);
        }
    }

    public function paymentCancel(Request $request): JsonResponse
    {
        $orderId = $request->get('order_id');
        
        if ($orderId) {
            $order = Order::find($orderId);
            
            if ($order) {
                return response()->json([
                    'success' => false,
                    'order' => $order,
                    'message' => 'Payment was cancelled. You can try again.',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment was cancelled.',
        ]);
    }
}
