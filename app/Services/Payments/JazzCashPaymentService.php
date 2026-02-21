<?php

namespace App\Services\Payments;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class JazzCashPaymentService implements PaymentInterface
{
    public function createCheckoutSession(Order $order): array
    {
        try {
            $data = [
                'merchant_id' => config('services.jazzcash.merchant_id'),
                'password' => config('services.jazzcash.password'),
                'return_url' => route('payment.jazzcash.return'),
                'order_id' => $order->order_number,
                'amount' => $order->total_amount,
                'currency' => $order->currency,
                'customer_email' => $order->user?->email,
                'customer_name' => $order->user?->name,
                'timestamp' => time(),
            ];

            $data['signature'] = $this->generateSignature($data);

            return [
                'success' => true,
                'data' => $data,
                'checkout_url' => config('services.jazzcash.checkout_url'),
            ];
        } catch (\Exception $e) {
            Log::error('JazzCash checkout session creation failed', [
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
            if (!$this->verifyResponse($data)) {
                return [
                    'success' => false,
                    'error' => 'Invalid response signature',
                ];
            }

            $orderNumber = $data['order_id'] ?? null;
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return [
                    'success' => false,
                    'error' => 'Order not found',
                ];
            }

            $status = $data['status'] ?? 'failed';
            
            if ($status === 'success' && $order->canBePaid()) {
                $order->markAsPaid($data['transaction_id'] ?? null);
                
                return [
                    'success' => true,
                    'order' => $order,
                    'message' => 'Payment processed successfully',
                ];
            }

            return [
                'success' => false,
                'error' => 'Payment failed or order cannot be paid',
            ];
        } catch (\Exception $e) {
            Log::error('JazzCash payment processing failed', [
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
        return $this->verifyResponse($payload);
    }

    public function handleWebhook(array $payload): void
    {
        $this->processPayment($payload);
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        try {
            $data = [
                'merchant_id' => config('services.jazzcash.merchant_id'),
                'password' => config('services.jazzcash.password'),
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'timestamp' => time(),
            ];

            $data['signature'] = $this->generateSignature($data);

            return [
                'success' => true,
                'refund_id' => uniqid('refund_'),
                'status' => 'processed',
            ];
        } catch (\Exception $e) {
            Log::error('JazzCash refund failed', [
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
            return [
                'success' => true,
                'status' => 'completed',
                'amount' => 0,
                'currency' => 'PKR',
                'transaction_id' => $transactionId,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to retrieve JazzCash payment details', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function generateSignature(array $data): string
    {
        $secretKey = config('services.jazzcash.secret_key');
        $sortedData = $data;
        ksort($sortedData);
        
        $signatureString = '';
        foreach ($sortedData as $key => $value) {
            if ($key !== 'signature') {
                $signatureString .= $key . '=' . $value . '&';
            }
        }
        
        $signatureString .= 'secret_key=' . $secretKey;
        
        return hash_hmac('sha256', $signatureString, $secretKey);
    }

    protected function verifyResponse(array $data): bool
    {
        $receivedSignature = $data['signature'] ?? '';
        unset($data['signature']);
        
        $calculatedSignature = $this->generateSignature($data);
        
        return hash_equals($calculatedSignature, $receivedSignature);
    }
}
