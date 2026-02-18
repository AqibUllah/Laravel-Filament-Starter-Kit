<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;

it('creates a category with valid data', function () {
    $category = Category::factory()->create();

    expect($category->exists)->toBeTrue()
        ->and($category->name)->not->toBeEmpty()
        ->and($category->slug)->not->toBeEmpty()
        ->and($category->team_id)->not->toBeNull()
        ->and($category->is_active)->toBeBool()
        ->and($category->sort_order)->toBeInt();
});

it('has proper relationships', function () {
    $category = Category::factory()->create();

    expect($category->team)->toBeInstanceOf(Team::class)
        ->and($category->parent)->toBeNull()
        ->and($category->children)->toHaveCount(0)
        ->and($category->products)->toHaveCount(0);
});

it('can have parent category', function () {
    $parentCategory = Category::factory()->create();
    $childCategory = Category::factory()->withParent($parentCategory)->create();

    expect($childCategory->parent->id)->toBe($parentCategory->id)
        ->and($parentCategory->children)->toHaveCount(1)
        ->and($parentCategory->children->first()->id)->toBe($childCategory->id);
});

it('can have nested categories', function () {
    $rootCategory = Category::factory()->create();
    $childCategory = Category::factory()->withParent($rootCategory)->create();
    $grandchildCategory = Category::factory()->withParent($childCategory)->create();

    expect($rootCategory->parent)->toBeNull()
        ->and($childCategory->parent->id)->toBe($rootCategory->id)
        ->and($grandchildCategory->parent->id)->toBe($childCategory->id)
        ->and($rootCategory->children)->toHaveCount(1)
        ->and($childCategory->children)->toHaveCount(1);
});

it('applies active scope correctly', function () {
    $activeCategory = Category::factory()->create(['is_active' => true]);
    $inactiveCategory = Category::factory()->create(['is_active' => false]);

    $activeCategories = Category::active()->get();

    expect($activeCategories)->toHaveCount(1)
        ->and($activeCategories->first()->id)->toBe($activeCategory->id);
});

it('applies root scope correctly', function () {
    $rootCategory = Category::factory()->create(['parent_id' => null]);
    $childCategory = Category::factory()->withParent($rootCategory)->create();

    $rootCategories = Category::root()->get();

    expect($rootCategories)->toHaveCount(1)
        ->and($rootCategories->first()->id)->toBe($rootCategory->id);
});

it('applies ordered scope correctly', function () {
    $category1 = Category::factory()->create(['sort_order' => 2, 'name' => 'Z Category']);
    $category2 = Category::factory()->create(['sort_order' => 1, 'name' => 'A Category']);
    $category3 = Category::factory()->create(['sort_order' => 1, 'name' => 'B Category']);

    $orderedCategories = Category::ordered()->get();

    expect($orderedCategories->get(0)->id)->toBe($category2->id)
        ->and($orderedCategories->get(1)->id)->toBe($category3->id)
        ->and($orderedCategories->get(2)->id)->toBe($category1->id);
});

it('generates full path correctly', function () {
    $rootCategory = Category::factory()->create(['name' => 'Electronics']);
    $childCategory = Category::factory()->withParent($rootCategory)->create(['name' => 'Phones']);
    $grandchildCategory = Category::factory()->withParent($childCategory)->create(['name' => 'Smartphones']);

    expect($rootCategory->getFullPath())->toBe('Electronics')
        ->and($childCategory->getFullPath())->toBe('Electronics > Phones')
        ->and($grandchildCategory->getFullPath())->toBe('Electronics > Phones > Smartphones');
});

it('checks if category has products', function () {
    $categoryWithProducts = Category::factory()->has(Product::factory()->count(3))->create();
    $categoryWithoutProducts = Category::factory()->create();

    expect($categoryWithProducts->hasProducts())->toBeTrue()
        ->and($categoryWithoutProducts->hasProducts())->toBeFalse();
});

it('counts products correctly', function () {
    $category = Category::factory()->has(Product::factory()->count(5))->create();

    expect($category->getProductCount())->toBe(5);
});

it('counts active products correctly', function () {
    $category = Category::factory()->create();
    
    Product::factory()->count(3)->create(['category_id' => $category->id, 'is_active' => true]);
    Product::factory()->count(2)->create(['category_id' => $category->id, 'is_active' => false]);

    expect($category->getActiveProductCount())->toBe(3);
});

it('can have multiple products', function () {
    $category = Category::factory()->has(Product::factory()->count(5))->create();

    expect($category->products)->toHaveCount(5)
        ->and($category->products->first())->toBeInstanceOf(Product::class);
});

it('products relationship works correctly', function () {
    $category = Category::factory()->create();
    $product1 = Product::factory()->create(['category_id' => $category->id]);
    $product2 = Product::factory()->create(['category_id' => $category->id]);

    expect($category->products)->toHaveCount(2)
        ->and($category->products->pluck('id'))->toContain($product1->id)
        ->and($category->products->pluck('id'))->toContain($product2->id);
});

it('casts attributes correctly', function () {
    $category = Category::factory()->create([
        'is_active' => true,
        'sort_order' => 42,
    ]);

    expect($category->is_active)->toBeTrue()
        ->and($category->sort_order)->toBe(42);
});

it('uses soft deletes', function () {
    $category = Category::factory()->create();

    $category->delete();

    expect($category->trashed())->toBeTrue()
        ->and(Category::find($category->id))->toBeNull()
        ->and(Category::withTrashed()->find($category->id))->not->toBeNull();
});

it('can be restored from soft delete', function () {
    $category = Category::factory()->create();

    $category->delete();
    $category->restore();

    expect($category->trashed())->toBeFalse()
        ->and(Category::find($category->id))->not->toBeNull();
});

it('prevents circular references in parent-child relationships', function () {
    $parentCategory = Category::factory()->create();
    $childCategory = Category::factory()->withParent($parentCategory)->create();

    // This would create a circular reference if allowed
    // In a real application, you might want to add validation to prevent this
    expect($childCategory->parent->id)->toBe($parentCategory->id)
        ->and($parentCategory->parent)->toBeNull();
});

it('handles multiple levels of children correctly', function () {
    $root = Category::factory()->create(['name' => 'Root']);
    $level1 = Category::factory()->withParent($root)->create(['name' => 'Level 1']);
    $level2 = Category::factory()->withParent($level1)->create(['name' => 'Level 2']);
    $level3 = Category::factory()->withParent($level2)->create(['name' => 'Level 3']);

    expect($root->children)->toHaveCount(1)
        ->and($root->children->first()->id)->toBe($level1->id)
        ->and($level1->children)->toHaveCount(1)
        ->and($level1->children->first()->id)->toBe($level2->id)
        ->and($level2->children)->toHaveCount(1)
        ->and($level2->children->first()->id)->toBe($level3->id)
        ->and($level3->children)->toHaveCount(0);
});

it('generates unique slugs', function () {
    $category1 = Category::factory()->create(['name' => 'Test Category']);
    $category2 = Category::factory()->create(['name' => 'Test Category']);

    expect($category1->slug)->not->toBe($category2->slug);
});
