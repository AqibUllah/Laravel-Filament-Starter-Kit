<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'plan_id',
        'coupon_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'status',
        'trial_ends_at',
        'ends_at',
        'canceled_at',
        'discount_amount',
        'final_amount',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function team():BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function plan():BelongsTo
    {
        return $this->belongsTo(Plan::class)->withoutGlobalScopes();
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && !$this->isCanceled();
    }

    public function isCanceled(): bool
    {
        return !is_null($this->canceled_at);
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasEnded(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function isRecurring(): bool
    {
        return $this->isActive() && !$this->isOnTrial() && !$this->isCanceled();
    }
}
