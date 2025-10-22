<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanFeature>
 */
class PlanFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plan_id' => \App\Models\Plan::factory(),
            'name' => $this->faker->word(),
            'value' => $this->faker->randomElement(['true', 'false', '5', '10', 'Unlimited', '100GB']),
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
