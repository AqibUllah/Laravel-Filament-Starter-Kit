<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;

it('creates a product with valid data', function () {
    $product = Product::factory()->create();

    expect($product->exists)->toBeTrue()
        ->and($product->name)->not->toBeEmpty()
        ->and($product->sku)->not->toBeEmpty()
        ->and($product->price)->toBeString()
        ->and($product->quantity)->toBeInt()
        ->and($product->team_id)->not->toBeNull()
        ->and($product->category_id)->not->toBeNull();
});

it('has proper relationships', function () {
    $product = Product::factory()->create();

    expect($product->team)->toBeInstanceOf(Team::class)
        ->and($product->category)->toBeInstanceOf(Category::class);
});

it('applies active scope correctly', function () {
    $activeProduct = Product::factory()->create(['is_active' => true]);
    $inactiveProduct = Product::factory()->create(['is_active' => false]);

    $activeProducts = Product::active()->get();

    expect($activeProducts)->toHaveCount(1)
        ->and($activeProducts->first()->id)->toBe($activeProduct->id);
});

it('applies featured scope correctly', function () {
    $featuredProduct = Product::factory()->create(['is_featured' => true]);
    $regularProduct = Product::factory()->create(['is_featured' => false]);

    $featuredProducts = Product::featured()->get();

    expect($featuredProducts)->toHaveCount(1)
        ->and($featuredProducts->first()->id)->toBe($featuredProduct->id);
});

it('applies inStock scope correctly', function () {
    $inStockProduct = Product::factory()->create(['quantity' => 10]);
    $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

    $inStockProducts = Product::inStock()->get();

    expect($inStockProducts)->toHaveCount(1)
        ->and($inStockProducts->first()->id)->toBe($inStockProduct->id);
});

it('applies lowStock scope correctly', function () {
    $lowStockProduct = Product::factory()->lowStock()->create();
    $normalStockProduct = Product::factory()->create(['quantity' => 50, 'min_stock_level' => 10]);

    $lowStockProducts = Product::lowStock()->get();

    expect($lowStockProducts)->toHaveCount(1)
        ->and($lowStockProducts->first()->id)->toBe($lowStockProduct->id);
});

it('correctly identifies stock status', function () {
    $inStockProduct = Product::factory()->create(['quantity' => 20, 'min_stock_level' => 5]);
    $lowStockProduct = Product::factory()->lowStock()->create();
    $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

    expect($inStockProduct->isInStock())->toBeTrue()
        ->and($inStockProduct->isLowStock())->toBeFalse()
        ->and($lowStockProduct->isInStock())->toBeTrue()
        ->and($lowStockProduct->isLowStock())->toBeTrue()
        ->and($outOfStockProduct->isInStock())->toBeFalse()
        ->and($outOfStockProduct->isLowStock())->toBeTrue();
});

it('calculates current price correctly', function () {
    $regularProduct = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => null,
    ]);

    $saleProduct = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => 80.00,
    ]);

    expect($regularProduct->getCurrentPrice())->toBe(100.00)
        ->and($saleProduct->getCurrentPrice())->toBe(80.00);
});

it('calculates discount percentage correctly', function () {
    $regularProduct = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => null,
    ]);

    $saleProduct = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => 80.00,
    ]);

    $higherSaleProduct = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => 120.00,
    ]);

    expect($regularProduct->getDiscountPercentage())->toBeNull()
        ->and($saleProduct->getDiscountPercentage())->toBe(20.0)
        ->and($higherSaleProduct->getDiscountPercentage())->toBeNull();
});

it('calculates profit margin correctly', function () {
    $productWithoutCost = Product::factory()->create([
        'price' => 100.00,
        'cost_price' => null,
    ]);

    $productWithCost = Product::factory()->create([
        'price' => 100.00,
        'cost_price' => 60.00,
        'sale_price' => null,
    ]);

    $saleProductWithCost = Product::factory()->create([
        'price' => 100.00,
        'sale_price' => 80.00,
        'cost_price' => 60.00,
    ]);

    expect($productWithoutCost->getProfitMargin())->toBeNull()
        ->and($productWithCost->getProfitMargin())->toBe(40.0)
        ->and($saleProductWithCost->getProfitMargin())->toBe(25.0);
});

it('calculates total value correctly', function () {
    $product = Product::factory()->create([
        'price' => 50.00,
        'quantity' => 10,
        'sale_price' => null,
    ]);

    $saleProduct = Product::factory()->create([
        'price' => 50.00,
        'sale_price' => 40.00,
        'quantity' => 5,
    ]);

    expect($product->getTotalValue())->toBe(500.00)
        ->and($saleProduct->getTotalValue())->toBe(200.00);
});

it('formats prices correctly', function () {
    $product = Product::factory()->create([
        'price' => 1234.56,
        'sale_price' => 987.65,
    ]);

    expect($product->getFormattedPrice())->toBe('$1,234.56')
        ->and($product->getFormattedSalePrice())->toBe('$987.65')
        ->and($product->getFormattedCurrentPrice())->toBe('$987.65');
});

it('returns correct stock status and colors', function () {
    $inStockProduct = Product::factory()->create(['quantity' => 20, 'min_stock_level' => 5]);
    $lowStockProduct = Product::factory()->lowStock()->create();
    $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

    expect($inStockProduct->getStockStatus())->toBe('In Stock')
        ->and($inStockProduct->getStockStatusColor())->toBe('success')
        ->and($lowStockProduct->getStockStatus())->toBe('Low Stock')
        ->and($lowStockProduct->getStockStatusColor())->toBe('warning')
        ->and($outOfStockProduct->getStockStatus())->toBe('Out of Stock')
        ->and($outOfStockProduct->getStockStatusColor())->toBe('danger');
});

it('casts attributes correctly', function () {
    $product = Product::factory()->create([
        'price' => 123.456,
        'sale_price' => 98.765,
        'cost_price' => 65.432,
        'weight' => 12.345,
        'dimensions' => ['length' => 10, 'width' => 5, 'height' => 3, 'unit' => 'cm'],
        'is_active' => true,
        'is_featured' => false,
        'tags' => ['tag1', 'tag2', 'tag3'],
        'images' => ['image1.jpg', 'image2.jpg'],
        'variants' => [['name' => 'Size', 'options' => ['S', 'M', 'L']]],
        'attributes' => ['material' => 'Cotton', 'brand' => 'Test Brand'],
    ]);

    expect($product->price)->toBe('123.46')
        ->and($product->sale_price)->toBe('98.77')
        ->and($product->cost_price)->toBe('65.43')
        ->and($product->weight)->toBe('12.35')
        ->and($product->dimensions)->toBeArray()
        ->and($product->is_active)->toBeTrue()
        ->and($product->is_featured)->toBeFalse()
        ->and($product->tags)->toBeArray()
        ->and($product->images)->toBeArray()
        ->and($product->variants)->toBeArray()
        ->and($product->attributes)->toBeArray();
});

it('uses soft deletes', function () {
    $product = Product::factory()->create();

    $product->delete();

    expect($product->trashed())->toBeTrue()
        ->and(Product::find($product->id))->toBeNull()
        ->and(Product::withTrashed()->find($product->id))->not->toBeNull();
});

it('can be restored from soft delete', function () {
    $product = Product::factory()->create();

    $product->delete();
    $product->restore();

    expect($product->trashed())->toBeFalse()
        ->and(Product::find($product->id))->not->toBeNull();
});
