<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketplaceCheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Team;
use App\Services\MarketplaceService;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function __construct(
        private MarketplaceService $marketplaceService,
        private PaymentManager $paymentManager
    ) {}

    /**
     * Display marketplace landing page with products from all tenants
     */
    public function index(): View
    {
        $products = $this->marketplaceService->getPublicProducts(12,request()->all());
        $categories = $this->marketplaceService->getPublicCategories();
        $featuredProducts = $this->marketplaceService->getFeaturedProducts();
        $teams = $this->marketplaceService->getPublicTeams();

        return view('marketplace.index', compact('products', 'categories', 'featuredProducts', 'teams'));
    }

    /**
     * Show product detail page
     */
    public function show(Product $product): View
    {
        // Verify product is public and belongs to a valid tenant
        if (!$product->is_public || !$product->team || !$product->team->status) {
            abort(404);
        }

        $relatedProducts = $this->marketplaceService->getRelatedProducts($product);
        $tenant = $product->team;

        return view('marketplace.show', compact('product', 'relatedProducts', 'tenant'));
    }

    /**
     * Add product to cart (with validation)
     */
    public function addToCart(Request $request, Product $product): JsonResponse
    {
        try {
            // Validate product is public and available
            if (!$product->is_public || !$product->isInStock()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is not available for purchase.',
                ], 400);
            }

            // Check for multi-tenant cart conflict
            $cart = session('marketplace_cart', []);
            $existingItem = collect($cart)->firstWhere('team_id', '!=', $product->team_id);

            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add products from different tenants to the same cart. Please complete your current order before adding products from another seller.',
                ], 422);
            }

            // check if there is already added an item to cart update only quantity + 1 for that item

            $found = false;
            foreach ($cart as &$item) {
                if ($item['product_id'] == $product->id) {
                    // Product already exists → increase quantity
                    $item['quantity'] += 1;
                    $found = true;
                    break;
                }
            }
            if(!$found){
                // Add to cart
                $cart[] = [
                    'product_id' => $product->id,
                    'team_id' => $product->team_id,
                    'quantity' => $request->input('quantity', 1),
                    'price' => $product->getCurrentPrice(),
                    'product_name' => $product->name,
                    'added_at' => now()->toISOString(),
                ];
            }

            session(['marketplace_cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart_count' => count($cart),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding product to cart.',
            ], 500);
        }
    }

    /**
     * Get cart contents
     */
    public function getCart(): JsonResponse
    {
        $cart = session('marketplace_cart', []);
        $cartItems = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product && $product->is_public && $product->team?->status) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                    'team' => $product->team,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'cart_count' => count($cartItems),
            'total_amount' => array_sum(array_column($cartItems, 'total')),
        ]);
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart(Product $product): JsonResponse
    {
        try {
            $cart = session('marketplace_cart', []);

            // Remove item from cart
            $cart = array_filter($cart, function($item) use ($product) {
                return $item['product_id'] != $product->id;
            });

            // Re-index array
            $cart = array_values($cart);

            session(['marketplace_cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully.',
                'cart_count' => count($cart),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing product from cart.',
            ], 500);
        }
    }

    /**
     * Show cart empty page
     */
    public function cartEmpty(): View
    {
        return view('marketplace.cart-empty');
    }

    /**
     * Clear cart
     */
    public function clearCart(): JsonResponse
    {
        session()->forget('marketplace_cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
        ]);
    }

    /**
     * Show checkout page
     */
    public function checkout(): View
    {
        $cart = session('marketplace_cart', []);

        if (empty($cart)) {
            return view('marketplace.cart-empty');
        }

        // Validate cart items are still available
        $validItems = [];
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product && $product->is_public && $product->isInStock()) {
                $validItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'team_id' => $item['team_id'],
                    'total' => $item['price'] * $item['quantity'],
                ];
            }
        }

        if (count($validItems) !== count($cart)) {
            return view('marketplace.cart-invalid', [
                'invalid_items' => array_diff(array_keys($cart), array_column($validItems, 'product.id'))
            ]);
        }

        return view('marketplace.checkout', [
            'cart_items' => $validItems,
            'total_amount' => array_sum(array_column($validItems, 'total')),
        ]);
    }

    /**
     * Process marketplace checkout
     */
    public function processCheckout(MarketplaceCheckoutRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $cart = session('marketplace_cart', []);

                if (empty($cart)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your cart is empty.',
                    ], 400);
                }


                // Group cart items by tenant
                $tenantGroups = collect($cart)->groupBy('team_id');
                $orders = [];

                foreach ($tenantGroups as $teamId => $items) {
                    $tenant = Team::findOrFail($teamId);

                    if (!$tenant->status) {
                        throw new \Exception("Tenant {$tenant->name} is not active.");
                    }
                    $total = 0;
                    foreach ($cart as $cart_item){
                        $total += $cart_item['price'] * $cart_item['quantity'];
                    }

                    // Create order for each tenant
                    $order = \App\Models\Order::create([
                        'team_id' => $teamId,
                        'user_id' => Auth::id(),
                        'order_status' => \App\Enums\OrderStatus::Pending,
                        'payment_status' => \App\Enums\PaymentStatus::Pending,
                        'currency' => $tenant->currency ?? 'USD',
                        'subtotal_amount' => $total,
                        'total_amount' => $total,
                        'billing_address' => $request->validated()['billing_address'],
                        'shipping_address' => $request->validated()['shipping_address'],
                        'notes' => $request->validated()['notes'] ?? null,
                    ]);

                    // Create order items
                    foreach ($items as $item) {
                        $product = Product::findOrFail($item['product_id']);

                        // Verify product still belongs to tenant and is available
                        if ($product->team_id !== $teamId || !$product->isInStock()) {
                            throw new \Exception("Product {$product->name} is no longer available.");
                        }

                        $order->items()->create([
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'product_price' => $item['price'],
                            'quantity' => $item['quantity'],
                            'total_price' => $item['price'] * $item['quantity'],
                        ]);

                        // Update product stock
                        $product->decrement('quantity', $item['quantity']);
                    }

                    $orders[] = $order;
                }

                // Clear cart
                session()->forget('marketplace_cart');

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
//                    'orders' => collect($orders)->each->load('items.product'),
                    'redirect_url' => route('marketplace.payment.selection', ['orders' => collect($orders)->pluck('id')->toArray()]),
                ]);

            });

        } catch (\Exception $e) {
            \Log::error('Marketplace checkout error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show payment selection page for multiple orders
     */
    public function paymentSelection(Request $request): View
    {
        $orders = \App\Models\Order::with(['items.product', 'team'])
            ->whereIn('id', $request->input('orders'))
            ->where('user_id', Auth::id())
            ->where('payment_status', \App\Enums\PaymentStatus::Pending)
            ->get();

        if ($orders->isEmpty()) {
            abort(404);
        }

        return view('marketplace.payment-selection', compact('orders'));
    }

    /**
     * Initiate payment for specific order
     */
    public function initiatePayment(Request $request, \App\Models\Order $order): JsonResponse
    {
        try {
            // Get all order IDs from the request
            $orderIds = explode(',', $request->input('order_ids', $order->id));
            $orders = \App\Models\Order::whereIn('id', $orderIds)
                ->where('user_id', Auth::id())
                ->where('payment_status', \App\Enums\PaymentStatus::Pending)
                ->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid orders found for payment.',
                ], 400);
            }

            // Get payment method
            $paymentMethod = $request->input('payment_method');
            // Use tenant's payment service
            $paymentService = $this->paymentManager->driver($paymentMethod);

            // Calculate total amount for all orders
            $totalAmount = $orders->sum('total_amount');
            $currency = $orders->first()->currency;

            // Create payment intent for all orders
            $paymentResult = $paymentService->createPayment([
                'amount' => $totalAmount,
                'currency' => $currency,
                'order_ids' => $orders->pluck('id')->toArray(),
                'customer_email' => $orders->first()->user?->email,
                'success_url' => route('marketplace.payment.success', ['order' => $orders->first()->id]),
                'cancel_url' => route('marketplace.payment.cancel', ['order' => $orders->first()->id]),
                'metadata' => [
                    'order_numbers' => $orders->pluck('order_number')->implode(','),
                    'tenant_ids' => $orders->pluck('team_id')->unique()->implode(','),
                    'customer_name' => $orders->first()->user?->name,
                ],
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $paymentResult['payment_url'] ?? null,
                'payment_intent_id' => $paymentResult['payment_intent_id'] ?? null,
                'message' => 'Payment initiated successfully.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Payment initiation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Payment success callback
     */
    public function paymentSuccess(Request $request, \App\Models\Order $order): View
    {
        try {
            // Verify payment was successful (via webhook or callback)
            if ($order->payment_status === \App\Enums\PaymentStatus::Paid) {
                return view('marketplace.payment-success', compact('order'));
            }

            return view('marketplace.payment-pending', compact('order'));

        } catch (\Exception $e) {
            \Log::error('Payment success page error: ' . $e->getMessage());
            abort(500);
        }
    }

    /**
     * Payment cancel callback
     */
    public function paymentCancel(Request $request, \App\Models\Order $order): View
    {
        return view('marketplace.payment-cancelled', compact('order'));
    }

    /**
     * Get cart item count
     */
    public function getCartCount(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $cart = session()->get('marketplace_cart', []);
            $count = count($cart);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);

        } catch (\Exception $e) {
            \Log::error('Cart count error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'count' => 0
            ], 500);
        }
    }
}
