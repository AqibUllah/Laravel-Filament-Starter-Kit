<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::first();

        if (!$team) {
            return;
        }

        $categories = Category::where('team_id', $team->id)->get();

        if ($categories->isEmpty()) {
            return;
        }

        // Create sample products for each category
        $products = [
            'smartphones' => [
                ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'description' => 'Latest iPhone with advanced features'],
                ['name' => 'Samsung Galaxy S24', 'price' => 899.99, 'description' => 'Premium Android smartphone'],
                ['name' => 'Google Pixel 8', 'price' => 699.99, 'description' => 'Pure Android experience with great camera'],
            ],
            'laptops' => [
                ['name' => 'MacBook Pro 14"', 'price' => 1999.99, 'description' => 'Powerful laptop for professionals'],
                ['name' => 'Dell XPS 13', 'price' => 1299.99, 'description' => 'Compact and powerful ultrabook'],
                ['name' => 'HP Spectre x360', 'price' => 1149.99, 'description' => 'Versatile 2-in-1 laptop'],
            ],
            'mens-clothing' => [
                ['name' => 'Classic White Shirt', 'price' => 49.99, 'description' => 'Premium cotton dress shirt'],
                ['name' => 'Denim Jeans', 'price' => 79.99, 'description' => 'Comfortable and stylish jeans'],
                ['name' => 'Leather Jacket', 'price' => 299.99, 'description' => 'Genuine leather motorcycle jacket'],
            ],
            'womens-clothing' => [
                ['name' => 'Summer Dress', 'price' => 59.99, 'description' => 'Light and elegant summer dress'],
                ['name' => 'Yoga Pants', 'price' => 39.99, 'description' => 'Comfortable athletic wear'],
                ['name' => 'Silk Scarf', 'price' => 89.99, 'description' => 'Luxurious silk accessory'],
            ],
            'audio' => [
                ['name' => 'Wireless Headphones', 'price' => 199.99, 'description' => 'Premium noise-cancelling headphones'],
                ['name' => 'Bluetooth Speaker', 'price' => 79.99, 'description' => 'Portable wireless speaker'],
                ['name' => 'Earbuds Pro', 'price' => 149.99, 'description' => 'True wireless earbuds with ANC'],
            ],
        ];

        foreach ($products as $categorySlug => $categoryProducts) {
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                continue;
            }

            foreach ($categoryProducts as $productData) {
                $hasSale = rand(0, 100) < 30; // 30% chance of being on sale
                $salePrice = $hasSale ? $productData['price'] * (rand(50, 90) / 100) : null;

                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'sku' => 'SKU-' . strtoupper(uniqid()),
                    'price' => $productData['price'],
                    'sale_price' => $salePrice,
                    'cost_price' => $productData['price'] * (rand(30, 70) / 100),
                    'quantity' => rand(0, 100),
                    'min_stock_level' => rand(5, 15),
                    'max_stock_level' => rand(50, 200),
                    'weight' => rand(1, 50) / 10,
                    'dimensions' => [
                        'length' => rand(10, 50),
                        'width' => rand(10, 50),
                        'height' => rand(1, 20),
                        'unit' => 'cm',
                    ],
                    'category_id' => $category->id,
                    'team_id' => $team->id,
                    'is_active' => rand(0, 100) < 90, // 90% chance of being active
                    'is_featured' => rand(0, 100) < 20, // 20% chance of being featured
                    'meta_title' => $productData['name'],
                    'meta_description' => $productData['description'],
                    'tags' => explode(' ', strtolower(str_replace([' ', '-'], '', $productData['name']))),
                    'images' => [
                        "https://picsum.photos/seed/" . str_replace(' ', '', $productData['name']) . "/400/400.jpg",
                        "https://picsum.photos/seed/" . str_replace(' ', '', $productData['name']) . "2/400/400.jpg",
                    ],
                    'variants' => [
                        [
                            'name' => 'Color',
                            'options' => ['Black', 'White', 'Blue', 'Red'],
                        ],
                        [
                            'name' => 'Size',
                            'options' => ['S', 'M', 'L', 'XL'],
                        ],
                    ],
                    'attributes' => [
                        'brand' => 'Premium Brand',
                        'material' => 'High Quality',
                        'warranty' => '1 Year',
                    ],
                ]);
            }
        }

        // Create some additional random products
        for ($i = 0; $i < 20; $i++) {
            $category = $categories->random();
            
            Product::create([
                'name' => 'Product ' . ($i + 1),
                'description' => 'Sample product description for product ' . ($i + 1),
                'sku' => 'SKU-' . strtoupper(uniqid()),
                'price' => rand(10, 500) + (rand(0, 99) / 100),
                'sale_price' => rand(0, 100) < 30 ? rand(10, 500) * (rand(50, 90) / 100) : null,
                'cost_price' => rand(10, 500) * (rand(30, 70) / 100),
                'quantity' => rand(0, 100),
                'min_stock_level' => rand(5, 15),
                'max_stock_level' => rand(50, 200),
                'weight' => rand(1, 50) / 10,
                'dimensions' => [
                    'length' => rand(10, 50),
                    'width' => rand(10, 50),
                    'height' => rand(1, 20),
                    'unit' => 'cm',
                ],
                'category_id' => $category->id,
                'team_id' => $team->id,
                'is_active' => rand(0, 100) < 90,
                'is_featured' => rand(0, 100) < 20,
                'meta_title' => 'Product ' . ($i + 1),
                'meta_description' => 'Sample product description',
                'tags' => ['sample', 'product', 'demo'],
                'images' => [
                    "https://picsum.photos/seed/product" . ($i + 1) . "/400/400.jpg",
                ],
                'variants' => [],
                'attributes' => [
                    'brand' => 'Sample Brand',
                    'type' => 'Sample Type',
                ],
            ]);
        }
    }
}
