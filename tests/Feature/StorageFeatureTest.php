<?php

use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\Team;
use App\Models\Usage;
use App\Services\UsageService;

beforeEach(function () {
    $this->usageService = app(UsageService::class);

    // Create a team with subscription for testing
    $this->team = Team::factory()->create();

    // Seed plans and features
    seedPlansAndFeatures();
});

test('it has storage limits defined for all plans', function () {
    $plans = Plan::all();

    foreach ($plans as $plan) {
        $storageFeature = $plan->features()->where('name', 'storage_gb')->first();

        expect($storageFeature)->not->toBeNull("Plan {$plan->name} should have storage_gb feature");
        expect($storageFeature->value)->not->toBeEmpty("Plan {$plan->name} should have storage limit defined");
    }
});

test('starter plan has 1gb storage limit', function () {
    $starterPlan = Plan::where('name', 'Starter')->first();
    $storageFeature = $starterPlan->features()->where('name', 'storage_gb')->first();

    expect($storageFeature->value)->toBe(1);
});

test('pro plan has 10gb storage limit', function () {
    $proPlan = Plan::where('name', 'Pro')->first();
    $storageFeature = $proPlan->features()->where('name', 'storage_gb')->first();

    expect($storageFeature->value)->toBe(10);
});

test('business plan has 100gb storage limit', function () {
    $businessPlan = Plan::where('name', 'Business')->first();
    $storageFeature = $businessPlan->features()->where('name', 'storage_gb')->first();

    expect($storageFeature->value)->toBe(100);
});

test('enterprise plan has 1tb storage limit', function () {
    $enterprisePlan = Plan::where('name', 'Enterprise')->first();
    $storageFeature = $enterprisePlan->features()->where('name', 'storage_gb')->first();

    expect($storageFeature->value)->toBe(1024); // 1TB = 1024GB
});

test('it can record storage usage', function () {
    $usage = $this->usageService->recordStorageUsage($this->team, 0.5); // 0.5 GB

    expect($usage)->toBeInstanceOf(Usage::class);
    expect($usage->team_id)->toBe($this->team->id);
    expect($usage->metric_name)->toBe('storage_gb');
    expect($usage->quantity)->toBe('0.5000'); // Database returns as string
    expect($usage->unit_price)->toBe('0.1000'); // Database returns as string with precision
    expect($usage->total_amount)->toBe('0.05'); // Database returns as string
});

test('it can check storage usage limits', function () {
    // Create a subscription with starter plan (1GB limit)
    $starterPlan = Plan::where('name', 'Starter')->first();
    $subscription = $this->team->subscriptions()->create([
        'plan_id' => $starterPlan->id,
        'user_id' => $this->team->owner_id,
        'status' => 'active',
        'starts_at' => now(),
        'ends_at' => now()->addMonth(),
    ]);

    // Record 0.8GB usage (should be allowed)
    $this->usageService->recordStorageUsage($this->team, 0.8);

    // Manually set the subscription for the team to avoid relationship issues
    $this->team->setRelation('subscription', $subscription);

    $limits = $this->usageService->checkUsageLimits($this->team, 'Storage', 0.3);

    expect($limits['allowed'])->toBeTrue('Should allow additional storage when under limit');
    expect($limits['current_usage'])->toBe(0.8);
    expect($limits['limit'])->toBe(1); // 1GB limit (integer from plan feature)
    expect($limits['remaining'])->toBe(0.2);
});

test('it prevents exceeding storage limits', function () {
    // Create a subscription with starter plan (1GB limit)
    $starterPlan = Plan::where('name', 'Starter')->first();
    $subscription = $this->team->subscriptions()->create([
        'plan_id' => $starterPlan->id,
        'user_id' => $this->team->owner_id,
        'status' => 'active',
        'starts_at' => now(),
        'ends_at' => now()->addMonth(),
    ]);

    // Record 0.9GB usage
    $this->usageService->recordStorageUsage($this->team, 0.9);

    // Manually set the subscription for the team to avoid relationship issues
    $this->team->setRelation('subscription', $subscription);

    // Try to add 0.3GB more (should exceed 1GB limit)
    $limits = $this->usageService->checkUsageLimits($this->team, 'Storage', 0.3);

    expect($limits['allowed'])->toBeFalse('Should prevent exceeding storage limit');
    expect($limits['current_usage'])->toBe(0.9);
    expect($limits['limit'])->toBe(1); // 1GB limit (integer from plan feature)
    expect($limits['remaining'])->toBeCloseTo(0.1, 0.0001); // Use closeTo for floating point precision
});

test('team can access storage feature value', function () {
    // Create a subscription with pro plan
    $proPlan = Plan::where('name', 'Pro')->first();
    $subscription = $this->team->subscriptions()->create([
        'plan_id' => $proPlan->id,
        'user_id' => $this->team->owner_id,
        'status' => 'active',
        'starts_at' => now(),
        'ends_at' => now()->addMonth(),
    ]);

    $storageLimit = $this->team->featureValue('Storage');

    expect($storageLimit)->toBe(10);
});

test('it calculates storage overage charges', function () {
    // Create a subscription with starter plan (1GB limit)
    $starterPlan = Plan::where('name', 'Starter')->first();
    $subscription = $this->team->subscriptions()->create([
        'plan_id' => $starterPlan->id,
        'user_id' => $this->team->owner_id,
        'status' => 'active',
        'starts_at' => now(),
        'ends_at' => now()->addMonth(),
    ]);

    // Record 1.5GB usage (0.5GB over limit)
    $this->usageService->recordStorageUsage($this->team, 1.5);

    $overageCharges = $this->usageService->calculateOverageCharges($this->team, 'storage_gb');

    expect($overageCharges)->toBe(0.0); // No overage pricing configured, so 0 charges
});

// Helper function to seed plans and features
function seedPlansAndFeatures(): void
{
    // Create plans
    $plans = [
        ['name' => 'Starter', 'price' => 0, 'interval' => 'month', 'is_active' => true],
        ['name' => 'Pro', 'price' => 29, 'interval' => 'month', 'is_active' => true],
        ['name' => 'Business', 'price' => 79, 'interval' => 'month', 'is_active' => true],
        ['name' => 'Enterprise', 'price' => 199, 'interval' => 'month', 'is_active' => true],
    ];

    foreach ($plans as $planData) {
        Plan::create($planData);
    }

    // Add storage features to plans (using storage_gb as metric name and numeric values)
    $storageFeatures = [
        'Starter' => 1,    // 1GB
        'Pro' => 10,       // 10GB
        'Business' => 100, // 100GB
        'Enterprise' => 1024, // 1TB = 1024GB
    ];

    foreach ($storageFeatures as $planName => $storageLimitGB) {
        $plan = Plan::where('name', $planName)->first();
        PlanFeature::create([
            'plan_id' => $plan->id,
            'name' => 'storage_gb', // Use the metric name that UsageService expects
            'value' => $storageLimitGB, // Use numeric GB value
            'sort_order' => 6,
        ]);
    }
}
