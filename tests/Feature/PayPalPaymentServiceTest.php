<?php

use App\Models\Order;
use App\Models\User;
use App\Models\Team;
use App\Services\Payments\PayPalPaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('paypal payment service is properly configured', function () {
    // Test that the service can be instantiated with proper config
    config(['paypal.sandbox.client_id' => 'test-client-id']);
    config(['paypal.sandbox.client_secret' => 'test-client-secret']);
    config(['paypal.mode' => 'sandbox']);

    $service = new PayPalPaymentService();
    
    expect($service)->toBeInstanceOf(PayPalPaymentService::class);
});

test('paypal payment service handles missing configuration', function () {
    // Test with empty configuration
    config(['paypal.sandbox.client_id' => '']);
    config(['paypal.sandbox.client_secret' => '']);
    config(['paypal.mode' => 'sandbox']);

    expect(fn() => new PayPalPaymentService())->toThrow('client_id missing from the provided configuration');
});

test('paypal order id is stored in database', function () {
    // Create test data
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'team_id' => $team->id,
        'total_amount' => 100.00,
        'currency' => 'USD',
    ]);

    // Test that we can store and retrieve PayPal order ID
    $order->paypal_order_id = 'TEST-PAYPAL-ID';
    $order->save();

    $retrievedOrder = Order::find($order->id);
    expect($retrievedOrder->paypal_order_id)->toBe('TEST-PAYPAL-ID');
});

test('paypal return route exists', function () {
    // Test that the PayPal return route is properly defined
    $route = route('payment.paypal.return');
    expect($route)->toBeString();
    expect($route)->toContain('/payment/paypal/return');
});

test('paypal cancel route exists', function () {
    // Test that the PayPal cancel route is properly defined
    $route = route('payment.paypal.cancel');
    expect($route)->toBeString();
    expect($route)->toContain('/payment/paypal/cancel');
});
