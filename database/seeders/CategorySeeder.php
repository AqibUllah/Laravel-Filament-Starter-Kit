<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Team;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::first();

        if (!$team) {
            return;
        }

        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories',
                'sort_order' => 1,
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel',
                'sort_order' => 2,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies',
                'sort_order' => 3,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'sort_order' => 4,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, music, and entertainment',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, [
                'team_id' => $team->id,
                'is_active' => true,
            ]));
        }

        // Create some subcategories
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();

        if ($electronics) {
            $subcategories = [
                ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Mobile phones and accessories'],
                ['name' => 'Laptops', 'slug' => 'laptops', 'description' => 'Computers and laptops'],
                ['name' => 'Audio', 'slug' => 'audio', 'description' => 'Headphones and audio equipment'],
                ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'Gaming consoles and accessories'],
            ];

            foreach ($subcategories as $subcategory) {
                Category::create(array_merge($subcategory, [
                    'parent_id' => $electronics->id,
                    'team_id' => $team->id,
                    'is_active' => true,
                    'sort_order' => rand(1, 10),
                ]));
            }
        }

        if ($clothing) {
            $subcategories = [
                ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing', 'description' => 'Clothing for men'],
                ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing', 'description' => 'Clothing for women'],
                ['name' => 'Kids\' Clothing', 'slug' => 'kids-clothing', 'description' => 'Clothing for children'],
                ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Footwear for all ages'],
            ];

            foreach ($subcategories as $subcategory) {
                Category::create(array_merge($subcategory, [
                    'parent_id' => $clothing->id,
                    'team_id' => $team->id,
                    'is_active' => true,
                    'sort_order' => rand(1, 10),
                ]));
            }
        }

        // Create additional categories to reach the limit of 20
        $currentCategoryCount = Category::where('team_id', $team->id)->count();
        $categoriesToCreate = max(0, 20 - $currentCategoryCount);

        for ($i = 0; $i < $categoriesToCreate; $i++) {
            Category::create([
                'name' => 'Category ' . ($i + 1),
                'slug' => 'category-' . ($i + 1),
                'description' => 'Additional category ' . ($i + 1),
                'team_id' => $team->id,
                'is_active' => true,
                'sort_order' => rand(1, 20),
            ]);
        }
    }
}
