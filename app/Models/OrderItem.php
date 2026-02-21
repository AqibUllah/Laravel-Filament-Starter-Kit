<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
        'product_snapshot',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'product_snapshot' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->total_price)) {
                $item->total_price = $item->product_price * $item->quantity;
            }
        });

        static::updated(function ($item) {
            if ($item->wasChanged(['product_price', 'quantity'])) {
                $item->total_price = $item->product_price * $item->quantity;
                $item->saveQuietly();
                
                if ($item->order) {
                    $item->order->recalculateTotals();
                }
            }
        });

        static::deleted(function ($item) {
            if ($item->order) {
                $item->order->recalculateTotals();
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedProductPrice(): string
    {
        return '$' . number_format($this->product_price, 2);
    }

    public function getFormattedTotalPrice(): string
    {
        return '$' . number_format($this->total_price, 2);
    }

    public function getProductSnapshot(): array
    {
        if ($this->product_snapshot) {
            return $this->product_snapshot;
        }

        $product = $this->product;
        if (!$product) {
            return [];
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'images' => $product->images,
            'attributes' => $product->attributes,
        ];
    }

    public function createSnapshot(): void
    {
        $this->product_snapshot = $this->getProductSnapshot();
        $this->saveQuietly();
    }
}
