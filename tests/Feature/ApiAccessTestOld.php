<?php

use App\Models\User;
use App\Models\Team;
use App\Models\Plan;
use App\Models\PlanFeature;
use Laravel\Sanctum\Sanctum;
use Filament\Facades\Filament;

it('allows API access for users with API Access feature enabled', function () {
    // Create a plan with API access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'API Access',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    $user->teams()->attach($team->id);
    
    // Mock the current plan relationship
    $team->currentPlan = $plan;

    // Create API token
    $token = $user->createToken('test-token');

    // Test API access
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token->plainTextToken,
    ])->getJson('/api/user');

    $response->assertStatus(200);
    $response->assertJson(['id' => $user->id]);
});

it('denies API access for users without API Access feature', function () {
    // Create a plan without API access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'API Access',
        'value' => 'false',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    $user->teams()->attach($team->id);
    
    // Mock the current plan relationship
    $team->currentPlan = $plan;

    // Create API token
    $token = $user->createToken('test-token');

    // Test API access should be denied
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token->plainTextToken,
    ])->getJson('/api/user');

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'API access is not available on your current plan. Please upgrade to access the API.',
        'feature' => 'API Access',
    ]);
});

it('allows creating API tokens for users with API Access feature', function () {
    // Create a plan with API access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'API Access',
        'value' => 'true',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    $user->teams()->attach($team->id);
    
    // Mock the current plan relationship
    $team->currentPlan = $plan;

    // Login the user
    Sanctum::actingAs($user);

    // Test token creation
    $response = $this->postJson('/api/tokens', [
        'name' => 'Test API Token',
        'abilities' => ['*'],
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'message',
        'token',
        'token_info' => [
            'id',
            'name',
            'abilities',
            'expires_at',
        ],
    ]);
});

it('denies creating API tokens for users without API Access feature', function () {
    // Create a plan without API access
    $plan = Plan::factory()->create();
    PlanFeature::factory()->create([
        'plan_id' => $plan->id,
        'name' => 'API Access',
        'value' => 'false',
    ]);

    // Create user and team with the plan
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    $user->teams()->attach($team->id);
    
    // Mock the current plan relationship
    $team->currentPlan = $plan;

    // Login the user
    Sanctum::actingAs($user);

    // Test token creation should be denied
    $response = $this->postJson('/api/tokens', [
        'name' => 'Test API Token',
        'abilities' => ['*'],
    ]);

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'API access is not available on your current plan. Please upgrade to create API tokens.',
        'feature' => 'API Access',
    ]);
});
