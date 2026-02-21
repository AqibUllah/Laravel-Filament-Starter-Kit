<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use App\Services\MarketplaceService;

beforeEach(function () {
    // Clear cache before each test
    \Illuminate\Support\Facades\Cache::flush();
});

it('returns public products with default parameters', function () {
    // Create teams
    $team1 = Team::factory()->create(['status' => true]);
    $team2 = Team::factory()->create(['status' => true]);

    // Create categories
    $category1 = Category::factory()->create(['is_active' => true]);
    $category2 = Category::factory()->create(['is_active' => true]);

    // Create products with different visibility
    $publicProduct1 = Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category1->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Public Product 1'
    ]);

    $publicProduct2 = Product::factory()->create([
        'team_id' => $team2->id,
        'category_id' => $category2->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Public Product 2'
    ]);

    // Create private products (should not appear)
    Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category1->id,
        'is_public' => false,
        'is_active' => true,
        'name' => 'Private Product 1'
    ]);

    Product::factory()->create([
        'team_id' => $team2->id,
        'category_id' => $category2->id,
        'is_public' => true,
        'is_active' => false,
        'name' => 'Inactive Product 1'
    ]);

    $service = new MarketplaceService();
    $result = $service->getPublicProducts();

    expect($result)->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class)
        ->and($result->total())->toBe(2)
        ->and($result->pluck('name'))->toContain('Public Product 1', 'Public Product 2')
        ->and($result->pluck('name'))->not->toContain('Private Product 1', 'Inactive Product 1');
});

it('filters products by category correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category1 = Category::factory()->create(['is_active' => true, 'name' => 'Electronics']);
    $category2 = Category::factory()->create(['is_active' => true, 'name' => 'Books']);

    // Create products in different categories
    $product1 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category1->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Laptop'
    ]);

    $product2 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category2->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Novel'
    ]);

    $service = new MarketplaceService();

    // Filter by category 1
    $result1 = $service->getPublicProducts(12, ['category' => $category1->id]);
    expect($result1->total())->toBe(1)
        ->and($result1->first()->name)->toBe('Laptop');

    // Filter by category 2
    $result2 = $service->getPublicProducts(12, ['category' => $category2->id]);
    expect($result2->total())->toBe(1)
        ->and($result2->first()->name)->toBe('Novel');
});

it('filters products by search term correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    $product1 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Wireless Headphones',
        'description' => 'High-quality audio experience'
    ]);

    $product2 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Bluetooth Speaker',
        'description' => 'Portable sound system'
    ]);

    $product3 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'USB Cable',
        'description' => 'Charging accessory'
    ]);

    $service = new MarketplaceService();

    // Search by name
    $result1 = $service->getPublicProducts(12, ['search' => 'Wireless']);
    expect($result1->total())->toBe(1)
        ->and($result1->first()->name)->toBe('Wireless Headphones');

    // Search by description
    $result2 = $service->getPublicProducts(12, ['search' => 'audio']);
    expect($result2->total())->toBe(1)
        ->and($result2->first()->name)->toBe('Wireless Headphones');

    // Search for multiple matches
    $result3 = $service->getPublicProducts(12, ['search' => 'Bluetooth']);
    expect($result3->total())->toBe(1)
        ->and($result3->first()->name)->toBe('Bluetooth Speaker');
});

it('filters products by team correctly', function () {
    $team1 = Team::factory()->create(['status' => true, 'name' => 'Tech Store']);
    $team2 = Team::factory()->create(['status' => true, 'name' => 'Book Store']);
    $category = Category::factory()->create(['is_active' => true]);

    $product1 = Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Smartphone'
    ]);

    $product2 = Product::factory()->create([
        'team_id' => $team2->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Textbook'
    ]);

    $service = new MarketplaceService();

    // Filter by team 1
    $result1 = $service->getPublicProducts(12, ['team' => $team1->id]);
    expect($result1->total())->toBe(1)
        ->and($result1->first()->name)->toBe('Smartphone')
        ->and($result1->first()->team->name)->toBe('Tech Store');

    // Filter by team 2
    $result2 = $service->getPublicProducts(12, ['team' => $team2->id]);
    expect($result2->total())->toBe(1)
        ->and($result2->first()->name)->toBe('Textbook')
        ->and($result2->first()->team->name)->toBe('Book Store');
});

it('filters products by price range correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    $product1 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Budget Item',
        'price' => 10.00
    ]);

    $product2 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Mid-range Item',
        'price' => 50.00
    ]);

    $product3 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Premium Item',
        'price' => 200.00
    ]);

    $service = new MarketplaceService();

    // Filter by min price
    $result1 = $service->getPublicProducts(12, ['min_price' => 30]);
    expect($result1->total())->toBe(2)
        ->and($result1->pluck('name'))->toContain('Mid-range Item', 'Premium Item')
        ->and($result1->pluck('name'))->not->toContain('Budget Item');

    // Filter by max price
    $result2 = $service->getPublicProducts(12, ['max_price' => 75]);
    expect($result2->total())->toBe(2)
        ->and($result2->pluck('name'))->toContain('Budget Item', 'Mid-range Item')
        ->and($result2->pluck('name'))->not->toContain('Premium Item');

    // Filter by price range
    $result3 = $service->getPublicProducts(12, ['min_price' => 25, 'max_price' => 100]);
    expect($result3->total())->toBe(1)
        ->and($result3->first()->name)->toBe('Mid-range Item');
});

it('sorts products correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    $product1 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'A Product',
        'price' => 100.00,
        'created_at' => now()->subDays(3)
    ]);

    $product2 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'B Product',
        'price' => 50.00,
        'created_at' => now()->subDays(1)
    ]);

    $product3 = Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'C Product',
        'price' => 200.00,
        'created_at' => now()->subDays(2)
    ]);

    $service = new MarketplaceService();

    // Sort by price low to high
    $result1 = $service->getPublicProducts(12, ['sort' => 'price_low']);
    expect($result1->pluck('price')->toArray())->toBe(['50.00', '100.00', '200.00']);

    // Sort by price high to low
    $result2 = $service->getPublicProducts(12, ['sort' => 'price_high']);
    expect($result2->pluck('price')->toArray())->toBe(['200.00', '100.00', '50.00']);

    // Sort by name (default)
    $result3 = $service->getPublicProducts(12, ['sort' => 'name']);
    expect($result3->pluck('name')->toArray())->toBe(['A Product', 'B Product', 'C Product']);
});

it('applies multiple filters simultaneously', function () {
    $team1 = Team::factory()->create(['status' => true]);
    $team2 = Team::factory()->create(['status' => true]);
    $category1 = Category::factory()->create(['is_active' => true]);
    $category2 = Category::factory()->create(['is_active' => true]);

    // Create matching product
    $matchingProduct = Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category1->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Premium Wireless Headphones',
        'price' => 150.00
    ]);

    // Create non-matching products
    Product::factory()->create([
        'team_id' => $team2->id,  // Wrong team
        'category_id' => $category1->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Premium Wireless Headphones',
        'price' => 150.00
    ]);

    Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category2->id,  // Wrong category
        'is_public' => true,
        'is_active' => true,
        'name' => 'Premium Wireless Headphones',
        'price' => 150.00
    ]);

    Product::factory()->create([
        'team_id' => $team1->id,
        'category_id' => $category1->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Premium Wireless Headphones',
        'price' => 50.00  // Wrong price
    ]);

    $service = new MarketplaceService();

    // Apply multiple filters
    $result = $service->getPublicProducts(12, [
        'team' => $team1->id,
        'category' => $category1->id,
        'search' => 'Wireless',
        'min_price' => 100,
        'max_price' => 200
    ]);

    expect($result->total())->toBe(1)
        ->and($result->first()->id)->toBe($matchingProduct->id);
});

it('respects pagination parameters', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    // Create 25 products
    $products = Product::factory()->count(25)->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true
    ]);

    $service = new MarketplaceService();

    // Test first page
    $page1 = $service->getPublicProducts(10);
    expect($page1->currentPage())->toBe(1)
        ->and($page1->perPage())->toBe(10)
        ->and($page1->total())->toBe(25)
        ->and($page1->hasMorePages())->toBeTrue();

    // Test second page
    $page2 = $service->getPublicProducts(10, [], 2);
    expect($page2->currentPage())->toBe(2)
        ->and($page2->perPage())->toBe(10)
        ->and($page2->total())->toBe(25)
        ->and($page2->hasMorePages())->toBeTrue();

    // Test last page
    $page3 = $service->getPublicProducts(10, [], 3);
    expect($page3->currentPage())->toBe(3)
        ->and($page3->perPage())->toBe(10)
        ->and($page3->total())->toBe(25)
        ->and($page3->hasMorePages())->toBeFalse();
});

it('caches results correctly', function () {
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true
    ]);

    $service = new MarketplaceService();

    // First call should hit database and cache
    $result1 = $service->getPublicProducts(12, ['category' => $category->id]);

    // Second call should use cache
    $result2 = $service->getPublicProducts(12, ['category' => $category->id]);

    expect($result1->total())->toBe($result2->total())
        ->and($result1->pluck('id'))->toEqual($result2->pluck('id'));
});

it('excludes products from inactive teams', function () {
    $activeTeam = Team::factory()->create(['status' => true]);
    $inactiveTeam = Team::factory()->create(['status' => false]);
    $category = Category::factory()->create(['is_active' => true]);

    // Product from active team
    $activeProduct = Product::factory()->create([
        'team_id' => $activeTeam->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Active Team Product'
    ]);

    // Product from inactive team
    $inactiveProduct = Product::factory()->create([
        'team_id' => $inactiveTeam->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Inactive Team Product'
    ]);

    $service = new MarketplaceService();
    $result = $service->getPublicProducts();

    expect($result->total())->toBe(1)
        ->and($result->pluck('name'))->toContain('Active Team Product')
        ->and($result->pluck('name'))->not->toContain('Inactive Team Product');
});

it('handles empty results gracefully', function () {
    $service = new MarketplaceService();

    // Test with no products
    $result = $service->getPublicProducts();
    expect($result->total())->toBe(0)
        ->and($result->items())->toHaveCount(0);

    // Test with filters that match nothing
    $team = Team::factory()->create(['status' => true]);
    $category = Category::factory()->create(['is_active' => true]);

    Product::factory()->create([
        'team_id' => $team->id,
        'category_id' => $category->id,
        'is_public' => true,
        'is_active' => true,
        'name' => 'Some Product',
        'price' => 50.00
    ]);

    // Search for non-existent term
    $result2 = $service->getPublicProducts(12, ['search' => 'NonExistentProduct']);
    expect($result2->total())->toBe(0)
        ->and($result2->items())->toHaveCount(0);

    // Filter by impossible price range
    $result3 = $service->getPublicProducts(12, ['min_price' => 1000, 'max_price' => 2000]);
    expect($result3->total())->toBe(0)
        ->and($result3->items())->toHaveCount(0);
});

it('returns public teams correctly', function () {
    $service = new MarketplaceService();

    // Create teams with different statuses
    $activeTeam1 = Team::factory()->create(['status' => true, 'name' => 'Active Store 1']);
    $activeTeam2 = Team::factory()->create(['status' => true, 'name' => 'Active Store 2']);
    $inactiveTeam = Team::factory()->create(['status' => false, 'name' => 'Inactive Store']);

    // Create products for active teams
    Product::factory()->create([
        'team_id' => $activeTeam1->id,
        'is_public' => true,
        'is_active' => true
    ]);

    Product::factory()->create([
        'team_id' => $activeTeam2->id,
        'is_public' => true,
        'is_active' => true
    ]);

    // Create product for inactive team (should not affect team visibility)
    Product::factory()->create([
        'team_id' => $inactiveTeam->id,
        'is_public' => true,
        'is_active' => true
    ]);

    $teams = $service->getPublicTeams();
    
    expect($teams)->toHaveCount(2)
        ->and($teams->pluck('name')->toArray())->toBe(['Active Store 1', 'Active Store 2'])
        ->and($teams->first()->products_count)->toBe(1);
});
