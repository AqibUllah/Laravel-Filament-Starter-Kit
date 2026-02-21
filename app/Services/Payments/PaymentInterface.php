<?php

namespace App\Services\Payments;

use App\Models\Order;

interface PaymentInterface
{
    public function createCheckoutSession(Order $order): array;
    
    public function processPayment(array $data): array;
    
    public function verifyWebhookSignature(array $payload, string $signature): bool;
    
    public function handleWebhook(array $payload): void;
    
    public function refundPayment(string $transactionId, float $amount): array;
    
    public function getPaymentDetails(string $transactionId): array;
}
