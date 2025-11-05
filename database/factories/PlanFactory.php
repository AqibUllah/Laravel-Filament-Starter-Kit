<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' Plan',
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomElement([0, 9, 29, 79, 199]),
            'interval' => $this->faker->randomElement(['month', 'year']),
            'trial_days' => $this->faker->numberBetween(0, 30),
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
            'is_featured' => $this->faker->boolean(20),
            'stripe_price_id' => 'price_' . Str::random(10),
        ];
    }
}
