<?php

use App\Models\Plan;
use App\Models\User;
use App\Models\Team;
use Stripe\Customer;
use Stripe\Stripe;

it('has a plan', function () {
    $plan = Plan::factory()->create();
    expect($plan)->toBeInstanceOf(Plan::class);
});

it('can subscribe to a plan', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $plan = Plan::factory()->create();

    $this->mock(Stripe::class, function ($mock) {
        $mock->shouldReceive('setApiKey')->with(config('services.stripe.secret'));
    });

    $this->mock(Customer::class, function ($mock) {
        $mock->shouldReceive('create')->andReturn((object) [
            'id' => 'cus_12345',
        ]);
    });

    $user->subscribeToPlan($plan, $team->id, 'active');

    $this->assertDatabaseHas('subscriptions', [
        'user_id' => $user->id,
        'team_id' => $team->id,
        'plan_id' => $plan->id,
        'stripe_price_id' => $plan->stripe_price_id,
        'status' => 'active',
    ]);
});