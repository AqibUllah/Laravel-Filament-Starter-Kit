<?php

use App\Models\Order;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('payment selection page loads correctly', function () {
    // Create test data
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'team_id' => $team->id,
        'total_amount' => 100.00,
        'currency' => 'USD',
    ]);

    // Test that the payment selection page loads
    $response = $this->actingAs($user)
        ->get(route('marketplace.payment.selection', ['orders' => [$order->id]]));

    $response->assertStatus(200);
    $response->assertSee('Select Payment Method');
    $response->assertSee('Credit/Debit Card');
    $response->assertSee('PayPal');
    $response->assertSee('Bank Transfer');
});

test('payment initiation returns proper error response', function () {
    // Create test data
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'team_id' => $team->id,
        'total_amount' => 100.00,
        'currency' => 'USD',
    ]);

    // Test payment initiation with invalid payment method
    $response = $this->actingAs($user)
        ->post(route('marketplace.payment.initiate', ['order' => $order->id]), [
            'payment_method' => 'invalid_method',
            'order_ids' => $order->id,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ]);

    $response->assertStatus(500);
    $response->assertJson([
        'success' => false,
    ]);
});

test('payment error flash messages are displayed', function () {
    // Create test data
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'team_id' => $team->id,
        'total_amount' => 100.00,
        'currency' => 'USD',
    ]);

    // Test payment selection page with error flash message
    $response = $this->actingAs($user)
        ->withSession(['error' => 'Payment failed: Invalid payment method'])
        ->get(route('marketplace.payment.selection', ['orders' => [$order->id]]));

    $response->assertStatus(200);
    $response->assertSee('Payment failed: Invalid payment method');
});
