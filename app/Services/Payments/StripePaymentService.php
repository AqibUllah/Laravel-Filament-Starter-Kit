<?php

namespace App\Services\Payments;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Refund;

class StripePaymentService implements PaymentInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    public function createCheckoutSession(Order $order): array
    {
        try {
            $lineItems = $order->items->map(function ($item) {
                return [
                    'price_data' => [
                        'currency' => strtolower($order->currency),
                        'product_data' => [
                            'name' => $item->product_name,
                            'description' => "SKU: {$item->product->sku ?? 'N/A'}",
                            'images' => $item->product_snapshot['images'] ?? [],
                        ],
                        'unit_amount' => (int) ($item->product_price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            })->toArray();

            $session = Session::create([
                'customer_email' => $order->user?->email,
                'payment_intent_data' => [
                    'metadata' => [
                        'order_id' => $order->id,
                        'team_id' => $order->team_id,
                    ],
                ],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel') . '?order_id=' . $order->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'team_id' => $order->team_id,
                ],
                'billing_address_collection' => 'required',
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'AU', 'DE', 'FR', 'ES', 'IT', 'NL', 'BE', 'AT', 'CH'],
                ],
            ]);

            return [
                'success' => true,
                'session_id' => $session->id,
                'checkout_url' => $session->url,
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe checkout session creation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function processPayment(array $data): array
    {
        try {
            $sessionId = $data['session_id'];
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $orderId = $session->metadata['order_id'] ?? null;
                $order = Order::find($orderId);

                if ($order && $order->canBePaid()) {
                    $order->markAsPaid($session->payment_intent);
                    
                    return [
                        'success' => true,
                        'order' => $order,
                        'message' => 'Payment processed successfully',
                    ];
                }
            }

            return [
                'success' => false,
                'error' => 'Payment not completed or order cannot be paid',
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment processing failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyWebhookSignature(array $payload, string $signature): bool
    {
        try {
            $webhookSecret = config('services.stripe.webhook_secret');
            
            return Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            ) !== null;
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function handleWebhook(array $payload): void
    {
        $event = $payload['type'] ?? null;
        $data = $payload['data']['object'] ?? null;

        if (!$event || !$data) {
            return;
        }

        try {
            switch ($event) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($data);
                    break;

                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($data);
                    break;

                case 'payment_intent.payment_failed':
                    $this->handlePaymentIntentFailed($data);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event', ['event' => $event]);
            }
        } catch (\Exception $e) {
            Log::error('Error processing Stripe webhook', [
                'event' => $event,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function handleCheckoutSessionCompleted(array $session): void
    {
        $orderId = $session['metadata']['order_id'] ?? null;
        $order = Order::find($orderId);

        if ($order && $order->canBePaid()) {
            $order->markAsPaid($session['payment_intent']);
            
            Log::info('Order marked as paid via webhook', [
                'order_id' => $order->id,
                'payment_intent' => $session['payment_intent'],
            ]);
        }
    }

    protected function handlePaymentIntentSucceeded(array $paymentIntent): void
    {
        $orderId = $paymentIntent['metadata']['order_id'] ?? null;
        $order = Order::find($orderId);

        if ($order && $order->canBePaid()) {
            $order->markAsPaid($paymentIntent['id']);
            
            Log::info('Order marked as paid via payment intent webhook', [
                'order_id' => $order->id,
                'payment_intent' => $paymentIntent['id'],
            ]);
        }
    }

    protected function handlePaymentIntentFailed(array $paymentIntent): void
    {
        $orderId = $paymentIntent['metadata']['order_id'] ?? null;
        $order = Order::find($orderId);

        if ($order && $order->payment_status === PaymentStatus::Pending) {
            $order->payment_status = PaymentStatus::Failed;
            $order->save();
            
            Log::info('Order marked as failed via webhook', [
                'order_id' => $order->id,
                'payment_intent' => $paymentIntent['id'],
            ]);
        }
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        try {
            $refund = Refund::create([
                'payment_intent' => $transactionId,
                'amount' => (int) ($amount * 100),
                'reason' => 'requested_by_customer',
            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'status' => $refund->status,
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe refund failed', [
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getPaymentDetails(string $transactionId): array
    {
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($transactionId);

            return [
                'success' => true,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'created' => $paymentIntent->created,
                'metadata' => $paymentIntent->metadata,
            ];
        } catch (ApiErrorException $e) {
            Log::error('Failed to retrieve Stripe payment details', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
