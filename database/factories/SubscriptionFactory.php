<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['active', 'canceled', 'past_due', 'trialing', 'incomplete']);

        return [
            'team_id' => \App\Models\Team::factory(),
            'plan_id' => \App\Models\Plan::factory(),
            'stripe_subscription_id' => 'sub_'.$this->faker->uuid(),
            'stripe_customer_id' => 'cus_'.$this->faker->uuid(),
            'status' => $status,
            'trial_ends_at' => $status === 'trialing' ? now()->addDays(7) : null,
            'ends_at' => $status === 'canceled' ? now()->subDays(5) : null,
            'canceled_at' => $status === 'canceled' ? now()->subDays(10) : null,
        ];
    }
}
