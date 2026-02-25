<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'sale_price',
        'cost_price',
        'quantity',
        'min_stock_level',
        'max_stock_level',
        'weight',
        'dimensions',
        'category_id',
        'team_id',
        'is_active',
        'is_featured',
        'is_public',
        'meta_title',
        'meta_description',
        'tags',
        'images',
        'variants',
        'attributes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'tags' => 'array',
        'images' => 'array',
        'variants' => 'array',
        'attributes' => 'array',
    ];

    // Relationships
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes

    #[Scope]
    public function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    public function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    public function inStock(Builder $query): void
    {
        $query->where('quantity', '>', 0);
    }

    #[Scope]
    public function lowStock(Builder $query): void
    {
        $query->whereRaw('quantity <= min_stock_level');
    }

    #[Scope]
    public function public(Builder $query): void
    {
        $query->where('is_public', true);
    }

    #[Scope]
    public function publicAndActive(Builder $query): void
    {
        $query->where('is_public', true)->where('is_active', true);
    }

    // Helper Methods
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock_level;
    }

    public function getCurrentPrice(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentage(): ?float
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return null;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
    }

    public function getProfitMargin(): ?float
    {
        if (!$this->cost_price) {
            return null;
        }

        $currentPrice = $this->getCurrentPrice();
        return round((($currentPrice - $this->cost_price) / $currentPrice) * 100, 2);
    }

    public function getTotalValue(): float
    {
        return $this->getCurrentPrice() * $this->quantity;
    }

    public function getFormattedPrice(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedSalePrice(): ?string
    {
        return $this->sale_price ? '$' . number_format($this->sale_price, 2) : null;
    }

    public function getFormattedCurrentPrice(): string
    {
        return '$' . number_format($this->getCurrentPrice(), 2);
    }

    public function getStockStatus(): string
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    public function getStockStatusColor(): string
    {
        if ($this->quantity <= 0) {
            return 'danger';
        } elseif ($this->isLowStock()) {
            return 'warning';
        } else {
            return 'success';
        }
    }
}
