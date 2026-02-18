<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $price = $this->faker->randomFloat(2, 10, 1000);
        $hasSale = $this->faker->boolean(30);
        
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3),
            'sku' => 'SKU-' . $this->faker->unique()->numerify('######'),
            'price' => $price,
            'sale_price' => $hasSale ? $price * $this->faker->randomFloat(2, 0.5, 0.9) : null,
            'cost_price' => $price * $this->faker->randomFloat(2, 0.3, 0.7),
            'quantity' => $this->faker->numberBetween(0, 100),
            'min_stock_level' => $this->faker->numberBetween(1, 10),
            'max_stock_level' => $this->faker->numberBetween(50, 200),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'dimensions' => [
                'length' => $this->faker->numberBetween(1, 100),
                'width' => $this->faker->numberBetween(1, 100),
                'height' => $this->faker->numberBetween(1, 100),
                'unit' => 'cm',
            ],
            'category_id' => Category::factory(),
            'team_id' => Team::factory(),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->sentence,
            'tags' => $this->faker->words(5),
            'images' => [
                $this->faker->imageUrl(400, 400, 'products'),
                $this->faker->imageUrl(400, 400, 'products'),
            ],
            'variants' => [
                [
                    'name' => 'Size',
                    'options' => ['Small', 'Medium', 'Large'],
                ],
                [
                    'name' => 'Color',
                    'options' => ['Red', 'Blue', 'Green'],
                ],
            ],
            'attributes' => [
                'material' => $this->faker->randomElement(['Cotton', 'Polyester', 'Wool', 'Silk']),
                'brand' => $this->faker->company,
                'origin' => $this->faker->country,
            ],
        ];
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function featured()
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function outOfStock()
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }

    public function lowStock()
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(1, 5),
            'min_stock_level' => 10,
        ]);
    }

    public function onSale()
    {
        return $this->state(fn (array $attributes) => [
            'sale_price' => $attributes['price'] * $this->faker->randomFloat(2, 0.5, 0.9),
        ]);
    }
}
