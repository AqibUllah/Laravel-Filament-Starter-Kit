<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function getLabel(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Failed => 'Failed',
            self::Refunded => 'Refunded',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Failed => 'danger',
            self::Refunded => 'info',
        };
    }

    public function canTransitionTo(self $status): bool
    {
        return match($this) {
            self::Pending => in_array($status, [self::Paid, self::Failed]),
            self::Paid => in_array($status, [self::Refunded]),
            self::Failed => in_array($status, [self::Pending]),
            self::Refunded => false,
        };
    }
}
