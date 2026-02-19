<?php

use App\Models\User;
use App\Models\Team;
use App\Models\CustomDomain;
use App\Models\Plan;
use App\Models\PlanFeature;

it('allows custom domain access for users with Custom Domain feature enabled', function () {
    // Create a plan with custom domain access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'Custom Domain',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'owner_id' => $user->id,
        'current_plan_id' => $plan->id,
    ]);
    $user->teams()->attach($team->id);
    
    // Refresh user to load relationships
    $user->refresh();

    // Test page access
    $response = $this->actingAs($user)
        ->get('/filament/tenant/custom-domains');

    $response->assertStatus(200);
});

it('denies custom domain access for users without Custom Domain feature', function () {
    // Create a plan without custom domain access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'Custom Domain',
        'value' => 'false',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'owner_id' => $user->id,
        'current_plan_id' => $plan->id,
    ]);
    $user->teams()->attach($team->id);
    
    // Refresh user to load relationships
    $user->refresh();

    // Test page access should be denied
    $response = $this->actingAs($user)
        ->get('/filament/tenant/custom-domains');

    $response->assertRedirect('/filament/tenant/dashboard');
});

it('can create custom domain for users with Custom Domain feature', function () {
    // Create a plan with custom domain access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'Custom Domain',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'owner_id' => $user->id,
        'current_plan_id' => $plan->id,
    ]);
    $user->teams()->attach($team->id);
    
    // Refresh user to load relationships
    $user->refresh();

    // Create custom domain
    $customDomain = CustomDomain::factory()->create([
        'team_id' => $team->id,
        'domain' => 'example.com',
        'is_verified' => false,
        'is_primary' => true,
    ]);

    expect($team->customDomains)->toHaveCount(1);
    expect($customDomain->domain)->toBe('example.com');
    expect($customDomain->is_primary)->toBeTrue();
    expect($customDomain->is_verified)->toBeFalse();
});

it('can verify custom domain', function () {
    // Create a plan with custom domain access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'Custom Domain',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'owner_id' => $user->id,
        'current_plan_id' => $plan->id,
    ]);
    $user->teams()->attach($team->id);
    
    // Refresh user to load relationships
    $user->refresh();

    // Create unverified custom domain
    $customDomain = CustomDomain::factory()->create([
        'team_id' => $team->id,
        'domain' => 'example.com',
        'is_verified' => false,
        'is_primary' => false,
    ]);

    // Verify the domain
    $customDomain->update([
        'is_verified' => true,
        'verified_at' => now(),
    ]);

    expect($customDomain->fresh()->is_verified)->toBeTrue();
    expect($customDomain->fresh()->verified_at)->not->toBeNull();
});

it('can set primary domain', function () {
    // Create a plan with custom domain access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'Custom Domain',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'owner_id' => $user->id,
        'current_plan_id' => $plan->id,
    ]);
    $user->teams()->attach($team->id);
    
    // Refresh user to load relationships
    $user->refresh();

    // Create two custom domains
    $domain1 = CustomDomain::factory()->create([
        'team_id' => $team->id,
        'domain' => 'primary.com',
        'is_verified' => true,
        'is_primary' => true,
    ]);

    $domain2 = CustomDomain::factory()->create([
        'team_id' => $team->id,
        'domain' => 'secondary.com',
        'is_verified' => true,
        'is_primary' => false,
    ]);

    // Set second domain as primary
    $domain2->update(['is_primary' => true]);

    expect($domain1->fresh()->is_primary)->toBeFalse();
    expect($domain2->fresh()->is_primary)->toBeTrue();
});
