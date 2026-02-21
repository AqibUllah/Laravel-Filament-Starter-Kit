<?php

namespace App\Services\Payments;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PayPalPaymentService implements PaymentInterface
{
    public function createCheckoutSession(Order $order): array
    {
        try {
            $payload = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => $order->order_number,
                        'description' => 'Order #' . $order->order_number,
                        'amount' => [
                            'currency_code' => $order->currency,
                            'value' => (string) $order->total_amount,
                        ],
                        'custom_id' => (string) $order->id,
                    ],
                ],
                'application_context' => [
                    'return_url' => route('payment.paypal.return'),
                    'cancel_url' => route('payment.paypal.cancel') . '?order_id=' . $order->id,
                    'brand_name' => config('app.name'),
                    'locale' => 'en-US',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'PAY_NOW',
                ],
            ];

            $response = $this->makeRequest('/v2/checkout/orders', 'POST', $payload);

            if (isset($response['id'])) {
                $approvalUrl = collect($response['links'])
                    ->firstWhere('rel', 'approve')['href'] ?? null;

                return [
                    'success' => true,
                    'order_id' => $response['id'],
                    'approval_url' => $approvalUrl,
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to create PayPal order',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal checkout session creation failed', [
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
            $paypalOrderId = $data['token'] ?? null;
            $payerId = $data['PayerID'] ?? null;

            if (!$paypalOrderId || !$payerId) {
                return [
                    'success' => false,
                    'error' => 'Missing required PayPal parameters',
                ];
            }

            $order = $this->capturePayment($paypalOrderId, $payerId);

            if ($order) {
                return [
                    'success' => true,
                    'order' => $order,
                    'message' => 'Payment processed successfully',
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to capture PayPal payment',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal payment processing failed', [
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
        $webhookId = config('services.paypal.webhook_id');
        $certId = config('services.paypal.cert_id');
        
        $headers = getallheaders();
        $authAlgo = $headers['PAYPAL-AUTH-ALGO'] ?? '';
        $transmissionId = $headers['PAYPAL-TRANSMISSION-ID'] ?? '';
        $certUrl = $headers['PAYPAL-CERT-ID'] ?? '';
        $transmissionSig = $headers['PAYPAL-TRANSMISSION-SIG'] ?? '';
        $transmissionTime = $headers['PAYPAL-TRANSMISSION-TIME'] ?? '';
        
        $verificationData = [
            'cert_id' => $certId,
            'auth_algo' => $authAlgo,
            'transmission_id' => $transmissionId,
            'transmission_sig' => $transmissionSig,
            'transmission_time' => $transmissionTime,
            'webhook_id' => $webhookId,
            'event_body' => json_encode($payload),
        ];

        $response = $this->makeRequest('/v1/notifications/verify-webhook-signature', 'POST', $verificationData);

        return ($response['verification_status'] ?? '') === 'SUCCESS';
    }

    public function handleWebhook(array $payload): void
    {
        $eventType = $payload['event_type'] ?? null;
        $resource = $payload['resource'] ?? [];

        try {
            switch ($eventType) {
                case 'PAYMENT.CAPTURE.COMPLETED':
                    $this->handlePaymentCaptureCompleted($resource);
                    break;

                case 'PAYMENT.CAPTURE.DENIED':
                    $this->handlePaymentCaptureDenied($resource);
                    break;

                default:
                    Log::info('Unhandled PayPal webhook event', ['event_type' => $eventType]);
            }
        } catch (\Exception $e) {
            Log::error('Error processing PayPal webhook', [
                'event_type' => $eventType,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function handlePaymentCaptureCompleted(array $resource): void
    {
        $customId = $resource['custom_id'] ?? null;
        $orderId = (int) $customId;
        
        $order = Order::find($orderId);
        
        if ($order && $order->canBePaid()) {
            $transactionId = $resource['id'] ?? null;
            $order->markAsPaid($transactionId);
            
            Log::info('Order marked as paid via PayPal webhook', [
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
            ]);
        }
    }

    protected function handlePaymentCaptureDenied(array $resource): void
    {
        $customId = $resource['custom_id'] ?? null;
        $orderId = (int) $customId;
        
        $order = Order::find($orderId);
        
        if ($order && $order->payment_status === PaymentStatus::Pending) {
            $order->payment_status = PaymentStatus::Failed;
            $order->save();
            
            Log::info('Order marked as failed via PayPal webhook', [
                'order_id' => $order->id,
            ]);
        }
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        try {
            $payload = [
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => (string) $amount,
                ],
            ];

            $response = $this->makeRequest("/v2/payments/captures/{$transactionId}/refund", 'POST', $payload);

            if (isset($response['id'])) {
                return [
                    'success' => true,
                    'refund_id' => $response['id'],
                    'status' => $response['status'] ?? 'completed',
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to process PayPal refund',
            ];
        } catch (\Exception $e) {
            Log::error('PayPal refund failed', [
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
            $response = $this->makeRequest("/v2/payments/captures/{$transactionId}", 'GET');

            return [
                'success' => true,
                'status' => $response['status'] ?? 'unknown',
                'amount' => (float) ($response['amount']['value'] ?? 0),
                'currency' => $response['amount']['currency_code'] ?? 'USD',
                'created' => strtotime($response['create_time'] ?? 'now'),
                'transaction_id' => $transactionId,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to retrieve PayPal payment details', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function capturePayment(string $paypalOrderId, string $payerId): ?Order
    {
        $response = $this->makeRequest("/v2/checkout/orders/{$paypalOrderId}/capture", 'POST');

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $purchaseUnit = $response['purchase_units'][0] ?? [];
            $customId = $purchaseUnit['custom_id'] ?? null;
            $orderId = (int) $customId;
            
            $order = Order::find($orderId);
            
            if ($order && $order->canBePaid()) {
                $captureId = $purchaseUnit['payments']['captures'][0]['id'] ?? null;
                $order->markAsPaid($captureId);
                
                return $order;
            }
        }

        return null;
    }

    protected function makeRequest(string $endpoint, string $method = 'GET', array $data = []): array
    {
        $baseUrl = config('services.paypal.sandbox') 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';

        $accessToken = $this->getAccessToken();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        }

        throw new \Exception("PayPal API request failed: HTTP {$httpCode}");
    }

    protected function getAccessToken(): string
    {
        $baseUrl = config('services.paypal.sandbox') 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . '/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, 
            config('services.paypal.client_id') . ':' . config('services.paypal.client_secret')
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        return $data['access_token'] ?? '';
    }
}
