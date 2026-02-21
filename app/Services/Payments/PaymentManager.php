<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethod;
use App\Models\Order;
use Illuminate\Support\Manager;

class PaymentManager extends Manager
{
    public function createStripeDriver(): PaymentInterface
    {
        return new StripePaymentService();
    }

    public function createJazzcashDriver(): PaymentInterface
    {
        return new JazzCashPaymentService();
    }

    public function createPaypalDriver(): PaymentInterface
    {
        return new PayPalPaymentService();
    }

    public function getDefaultDriver(): string
    {
        return PaymentMethod::Stripe->value;
    }

    public function driver(PaymentMethod|string $method = null): PaymentInterface
    {
        if ($method instanceof PaymentMethod) {
            $method = $method->value;
        }

        return parent::driver($method);
    }
}
