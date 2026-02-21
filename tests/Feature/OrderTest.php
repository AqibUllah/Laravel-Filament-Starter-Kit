<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Team $team;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->team = Team::factory()->create(['owner_id' => $this->user->id]);
        $this->product = Product::factory()->create([
            'team_id' => $this->team->id,
            'price' => 100.00,
            'quantity' => 10,
            'is_active' => true,
        ]);

        $this->actingAs($this->user);
    }

    public function test_can_create_order(): void
    {
        $orderData = [
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 2,
                ],
            ],
            'payment_method' => 'stripe',
            'billing_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'US',
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('orders', [
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_method' => PaymentMethod::Stripe->value,
            'payment_status' => PaymentStatus::Pending->value,
            'order_status' => OrderStatus::Pending->value,
            'total_amount' => 216.00, // 2 * 100 + 8% tax
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $this->product->id,
            'quantity' => 2,
            'product_price' => 100.00,
            'total_price' => 200.00,
        ]);

        $this->assertEquals(8, $this->product->fresh()->quantity);
    }

    public function test_cannot_create_order_with_insufficient_stock(): void
    {
        $this->product->update(['quantity' => 1]);

        $orderData = [
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 2,
                ],
            ],
            'payment_method' => 'stripe',
            'billing_address' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'US',
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
            ]);

        $this->assertDatabaseCount('orders', 0);
        $this->assertEquals(1, $this->product->fresh()->quantity);
    }

    public function test_can_mark_order_as_paid(): void
    {
        Event::fake();

        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_status' => PaymentStatus::Pending,
            'order_status' => OrderStatus::Pending,
        ]);

        $result = $order->markAsPaid('pi_test123');

        $this->assertTrue($result);
        $this->assertEquals(PaymentStatus::Paid, $order->payment_status);
        $this->assertEquals(OrderStatus::Paid, $order->order_status);
        $this->assertEquals('pi_test123', $order->transaction_id);
        $this->assertNotNull($order->paid_at);

        Event::assertDispatched(\App\Events\OrderPaid::class, function ($event) use ($order) {
            return $event->order->id === $order->id && $event->transactionId === 'pi_test123';
        });
    }

    public function test_can_mark_order_as_shipped(): void
    {
        Event::fake();

        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Paid,
        ]);

        $result = $order->markAsShipped();

        $this->assertTrue($result);
        $this->assertEquals(OrderStatus::Shipped, $order->order_status);
        $this->assertNotNull($order->shipped_at);

        Event::assertDispatched(\App\Events\OrderShipped::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }

    public function test_can_cancel_order(): void
    {
        Event::fake();

        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_status' => PaymentStatus::Pending,
            'order_status' => OrderStatus::Pending,
        ]);

        $result = $order->cancel('Customer request');

        $this->assertTrue($result);
        $this->assertEquals(OrderStatus::Cancelled, $order->order_status);
        $this->assertNotNull($order->cancelled_at);

        Event::assertDispatched(\App\Events\OrderCancelled::class, function ($event) use ($order) {
            return $event->order->id === $order->id && $event->reason === 'Customer request';
        });
    }

    public function test_cannot_mark_unpaid_order_as_shipped(): void
    {
        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_status' => PaymentStatus::Pending,
            'order_status' => OrderStatus::Pending,
        ]);

        $result = $order->markAsShipped();

        $this->assertFalse($result);
        $this->assertEquals(OrderStatus::Pending, $order->order_status);
        $this->assertNull($order->shipped_at);
    }

    public function test_cannot_cancel_shipipped_order(): void
    {
        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'payment_status' => PaymentStatus::Paid,
            'order_status' => OrderStatus::Shipped,
        ]);

        $result = $order->cancel();

        $this->assertFalse($result);
        $this->assertEquals(OrderStatus::Shipped, $order->order_status);
        $this->assertNull($order->cancelled_at);
    }

    public function test_order_number_generation(): void
    {
        $order1 = Order::factory()->create(['team_id' => $this->team->id]);
        $order2 = Order::factory()->create(['team_id' => $this->team->id]);

        $this->assertNotNull($order1->order_number);
        $this->assertNotNull($order2->order_number);
        $this->assertNotEquals($order1->order_number, $order2->order_number);
        $this->assertStringStartsWith('ORD-' . date('Y') . '-', $order1->order_number);
        $this->assertStringStartsWith('ORD-' . date('Y') . '-', $order2->order_number);
    }

    public function test_order_totals_calculation(): void
    {
        $order = Order::factory()->create([
            'team_id' => $this->team->id,
            'subtotal_amount' => 100.00,
            'tax_amount' => 8.00,
            'discount_amount' => 10.00,
        ]);

        $this->assertEquals(98.00, $order->total_amount);
        $this->assertEquals('$98.00', $order->getFormattedTotalAmount());
        $this->assertEquals('$100.00', $order->getFormattedSubtotalAmount());
        $this->assertEquals('$8.00', $order->getFormattedTaxAmount());
        $this->assertEquals('$10.00', $order->getFormattedDiscountAmount());
    }
}
