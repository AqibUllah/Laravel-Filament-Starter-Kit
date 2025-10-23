<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'stripe_price_id',
        'stripe_product_id',
        'price',
        'interval',
        'trial_days',
        'sort_order',
        'is_active',
        'is_featured',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function team():BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeIsFree($query)
    {
        return $query->where('price', '==', 0)
        ->where('is_active','=',true);
    }

    // public function isFree($query): bool
    // {
    //     return $this->price == 0 && $this->is_active;
    // }

    public function getPriceInCents(): int
    {
        return (int) ($this->price * 100);
    }
}
