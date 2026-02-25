<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Events\OrderCancelled;
use App\Events\OrderPaid;
use App\Events\OrderShipped;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'order_number',
        'paypal_order_id',
        'total_amount',
        'subtotal_amount',
        'tax_amount',
        'discount_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'transaction_id',
        'currency',
        'billing_address',
        'shipping_address',
        'paid_at',
        'shipped_at',
        'cancelled_at',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payment_method' => PaymentMethod::class,
        'payment_status' => PaymentStatus::class,
        'order_status' => OrderStatus::class,
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber($order->team_id);
            }
            
            // Set currency from tenant if not provided
            if (empty($order->currency) && $order->team_id) {
                $team = Team::find($order->team_id);
                $order->currency = $team?->currency ?? 'USD';
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    #[Scope]
    public function forTeam(Builder $query, int $teamId): void
    {
        $query->where('team_id', $teamId);
    }

    #[Scope]
    public function withStatus(Builder $query, OrderStatus $status): void
    {
        $query->where('order_status', $status->value);
    }

    #[Scope]
    public function withPaymentStatus(Builder $query, PaymentStatus $status): void
    {
        $query->where('payment_status', $status->value);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === PaymentStatus::Paid;
    }

    public function isPending(): bool
    {
        return $this->order_status === OrderStatus::Pending;
    }

    public function isShipped(): bool
    {
        return $this->order_status === OrderStatus::Shipped;
    }

    public function isCancelled(): bool
    {
        return $this->order_status === OrderStatus::Cancelled;
    }

    public function canBePaid(): bool
    {
        return $this->order_status === OrderStatus::Pending && 
               $this->payment_status === PaymentStatus::Pending;
    }

    public function canBeShipped(): bool
    {
        return $this->order_status === OrderStatus::Paid && 
               $this->payment_status === PaymentStatus::Paid;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, [OrderStatus::Pending]);
    }

    public function markAsPaid(string $transactionId = null): bool
    {
        if (!$this->canBePaid()) {
            return false;
        }

        $this->order_status = OrderStatus::Paid;
        $this->payment_status = PaymentStatus::Paid;
        $this->paid_at = now();
        
        if ($transactionId) {
            $this->transaction_id = $transactionId;
        }

        $saved = $this->save();

        if ($saved) {
            OrderPaid::dispatch($this, $transactionId);
        }

        return $saved;
    }

    public function markAsShipped(): bool
    {
        if (!$this->canBeShipped()) {
            return false;
        }

        $this->order_status = OrderStatus::Shipped;
        $this->shipped_at = now();

        $saved = $this->save();

        if ($saved) {
            OrderShipped::dispatch($this);
        }

        return $saved;
    }

    public function cancel(string $reason = ''): bool
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->order_status = OrderStatus::Cancelled;
        $this->cancelled_at = now();

        $saved = $this->save();

        if ($saved) {
            OrderCancelled::dispatch($this, $reason);
        }

        return $saved;
    }

    public function getFormattedTotalAmount(): string
    {
        return $this->currency . ' ' . number_format($this->total_amount, 2);
    }

    public function getFormattedSubtotalAmount(): string
    {
        return $this->currency . ' ' . number_format($this->subtotal_amount, 2);
    }

    public function getFormattedTaxAmount(): string
    {
        return $this->currency . ' ' . number_format($this->tax_amount ?? 0, 2);
    }

    public function getFormattedDiscountAmount(): string
    {
        return $this->currency . ' ' . number_format($this->discount_amount ?? 0, 2);
    }

    public function getTotalItems(): int
    {
        return $this->items()->sum('quantity');
    }

    public static function generateOrderNumber(int $teamId): string
    {
        $year = date('Y');
        $sequence = static::whereYear('created_at', $year)
            ->withTrashed()
            ->count() + 1;
        
        return "ORD-{$year}-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }

    public function recalculateTotals(): void
    {
        $this->subtotal_amount = $this->items()->sum('total_price');
        
        $this->total_amount = $this->subtotal_amount + 
                              ($this->tax_amount ?? 0) - 
                              ($this->discount_amount ?? 0);
        
        $this->saveQuietly();
    }
}
