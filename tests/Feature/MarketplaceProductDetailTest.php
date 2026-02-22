<?php

use App\Models\Product;
use App\Models\Team;
use App\Models\Category;
use App\Services\MarketplaceService;

it('displays product detail page correctly', function () {
    // Create test data
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Test Product',
        'description' => 'This is a test product description.',
        'price' => 99.99,
        'sku' => 'TEST-001',
        'quantity' => 10
    ]);

    // Test the page loads correctly
    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertViewIs('marketplace.show')
        ->assertViewHas('product', function ($viewProduct) use ($product) {
            return $viewProduct->id === $product->id;
        })
        ->assertViewHas('relatedProducts')
        ->assertViewHas('tenant')
        ->assertSee($product->name)
        ->assertSee($product->description)
        ->assertSee($product->sku)
        ->assertSee($product->getFormattedCurrentPrice()) // Use the actual formatted price
        ->assertSee($team->name)
        ->assertSee($category->name);
});

it('returns 404 for private products', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => false, // Private product
        'is_active' => true
    ]);

    $response = $this->get(route('marketplace.show', $product));
    $response->assertStatus(404);
});

it('returns 404 for products from inactive teams', function () {
    $team = Team::factory()->create(['status' => false]); // Inactive team
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true
    ]);

    $response = $this->get(route('marketplace.show', $product));
    $response->assertStatus(404);
});

it('displays product with sale price correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'price' => 100.00,
        'sale_price' => 75.00
    ]);

    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertSee($product->getFormattedCurrentPrice()) // Sale price should be displayed
        ->assertSee($product->getFormattedPrice()); // Original price should also be shown
});

it('displays product images correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'images' => [
            'https://example.com/image1.jpg',
            'https://example.com/image2.jpg'
        ]
    ]);

    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertSee('https://example.com/image1.jpg')
        ->assertSee('https://example.com/image2.jpg');
});

it('displays product attributes correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'attributes' => [
            'color' => 'Red',
            'size' => 'Large',
            'material' => 'Cotton'
        ]
    ]);

    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertSee('Color')
        ->assertSee('Red')
        ->assertSee('Size')
        ->assertSee('Large')
        ->assertSee('Material')
        ->assertSee('Cotton');
});

it('displays related products correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    // Create main product
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Main Product'
    ]);
    
    // Create related products
    $relatedProduct1 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id, // Same category
        'is_public' => true,
        'is_active' => true,
        'name' => 'Related Product 1'
    ]);
    
    $relatedProduct2 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Related Product 2'
    ]);

    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertSee('Related Products')
        ->assertSee('Related Product 1')
        ->assertSee('Related Product 2');
});

it('displays product tags correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    $product = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'tags' => ['electronics', 'gadget', 'smart']
    ]);

    $response = $this->get(route('marketplace.show', $product));
    
    $response->assertStatus(200)
        ->assertSee('electronics')
        ->assertSee('gadget')
        ->assertSee('smart');
});

it('displays stock status correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);
    
    // Test in stock
    $inStockProduct = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'quantity' => 10
    ]);

    $response = $this->get(route('marketplace.show', $inStockProduct));
    $response->assertStatus(200)
        ->assertSee('In stock and ready to ship');

    // Test low stock
    $lowStockProduct = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'quantity' => 2,
        'min_stock_level' => 5
    ]);

    $response = $this->get(route('marketplace.show', $lowStockProduct));
    $response->assertStatus(200)
        ->assertSee('Only 2 left in stock!');

    // Test out of stock
    $outOfStockProduct = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'quantity' => 0
    ]);

    $response = $this->get(route('marketplace.show', $outOfStockProduct));
    $response->assertStatus(200)
        ->assertSee('Out of stock');
});
