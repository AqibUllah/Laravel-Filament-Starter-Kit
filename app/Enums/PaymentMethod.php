<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Stripe = 'stripe';
    case JazzCash = 'jazzcash';
    case PayPal = 'paypal';

    public function getLabel(): string
    {
        return match($this) {
            self::Stripe => 'Stripe',
            self::JazzCash => 'JazzCash',
            self::PayPal => 'PayPal',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::Stripe => 'heroicon-o-credit-card',
            self::JazzCash => 'heroicon-o-banknotes',
            self::PayPal => 'heroicon-o-wallet',
        };
    }
}
