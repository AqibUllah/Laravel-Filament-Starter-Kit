<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Shipped => 'Shipped',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Shipped => 'info',
            self::Cancelled => 'danger',
        };
    }

    public function canTransitionTo(self $status): bool
    {
        return match($this) {
            self::Pending => in_array($status, [self::Paid, self::Cancelled]),
            self::Paid => in_array($status, [self::Shipped]),
            self::Shipped => false,
            self::Cancelled => false,
        };
    }
}
