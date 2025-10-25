<?php

namespace App\Models;

use App\Models\Scopes\PlanWithoutTenantScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[ScopedBy([PlanWithoutTenantScope::class])]
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
        return $this->hasMany(PlanFeature::class)->withoutGlobalScopes();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

//    public function team():BelongsTo
//    {
//        return $this->belongsTo(Team::class);
//    }

    #[Scope]
    public function isFree(Builder $query): void
    {
        $query->where('price', 0);
    }

    #[Scope]
    public function active(Builder $query): void
    {
        $query->where('is_active',true);
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
