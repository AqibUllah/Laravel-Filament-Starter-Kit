<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type', // 'percentage' or 'fixed'
        'value', // discount amount
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'team_id', // null for global coupons, team_id for team-specific coupons
        'plan_id', // null for all plans, plan_id for specific plan
        'created_by', // admin user who created the coupon
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where(function ($q) {
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            });
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('team_id');
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where(function ($q) use ($teamId) {
            $q->whereNull('team_id')
                ->orWhere('team_id', $teamId);
        });
    }

    public function scopeForPlan($query, $planId)
    {
        return $query->where(function ($q) use ($planId) {
            $q->whereNull('plan_id')
                ->orWhere('plan_id', $planId);
        });
    }

    // Methods
    public function isValid(): bool
    {
        return $this->is_active
            && $this->valid_from <= now()
            && ($this->valid_until === null || $this->valid_until >= now())
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function canBeUsedByTeam(Team $team): bool
    {
        return $this->isValid()
            && ($this->team_id === null || $this->team_id === $team->id);
    }

    public function canBeUsedForPlan(Plan $plan): bool
    {
        return $this->isValid()
            && ($this->plan_id === null || $this->plan_id === $plan->id);
    }

    public function calculateDiscount($amount): float
    {
        if (! $this->isValid()) {
            return 0;
        }

        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return 0;
        }

        $discount = 0;
        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // Apply maximum discount limit
        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        return min($discount, $amount); // Can't discount more than the amount
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    public function getRemainingUses(): ?int
    {
        if ($this->usage_limit === null) {
            return null;
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    public function getFormattedDiscount(): string
    {
        if ($this->type === 'percentage') {
            return $this->value.'%';
        }

        return '$'.number_format($this->value, 2);
    }
}
