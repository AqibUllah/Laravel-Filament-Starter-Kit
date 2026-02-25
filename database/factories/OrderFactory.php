<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . date('Y') . '-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'paypal_order_id' => null,
            'total_amount' => $this->faker->randomFloat(2, 10, 1000),
            'subtotal_amount' => $this->faker->randomFloat(2, 10, 1000),
            'tax_amount' => $this->faker->randomFloat(2, 0, 100),
            'discount_amount' => $this->faker->randomFloat(2, 0, 50),
            'payment_method' => $this->faker->randomElement(['stripe', 'paypal']),
            'payment_status' => PaymentStatus::Pending,
            'order_status' => OrderStatus::Pending,
            'transaction_id' => null,
            'currency' => 'USD',
            'billing_address' => [
                'address_line_1' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'shipping_address' => [
                'address_line_1' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'paid_at' => null,
            'shipped_at' => null,
            'cancelled_at' => null,
            'notes' => $this->faker->optional()->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Paid,
            'paid_at' => Carbon::now(),
            'transaction_id' => $this->faker->uuid(),
        ]);
    }

    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_status' => OrderStatus::Shipped,
            'shipped_at' => Carbon::now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_status' => OrderStatus::Cancelled,
            'cancelled_at' => Carbon::now(),
        ]);
    }
}
