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

    public function driver($driver = null)
    {
        if ($driver && enum_exists(PaymentMethod::class)) {
            // Try to convert string to PaymentMethod enum if it matches
            try {
                $paymentMethod = PaymentMethod::from($driver);
                $driver = $paymentMethod->value;
            } catch (\ValueError $e) {
                // If it's not a valid enum value, use as-is
            }
        }

        return parent::driver($driver);
    }
}
