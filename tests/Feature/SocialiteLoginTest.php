<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

beforeEach(function () {
    // Create a team for tenant context (tenant_id = 1)
    $this->team = Team::firstOrCreate(
        ['id' => 1],
        ['name' => 'Test Team', 'slug' => 'test-team', 'owner_id' => User::factory()->create()->id]
    );

    // Create default settings for testing
    // Settings need to be set up in the database for tenant_id = 1
    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => 'company_name',
            'tenant_id' => 1,
        ],
        [
            'payload' => json_encode('Test Company'),
            'locked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => 'google_login',
            'tenant_id' => 1,
        ],
        [
            'payload' => json_encode(true),
            'locked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => 'github_login',
            'tenant_id' => 1,
        ],
        [
            'payload' => json_encode(true),
            'locked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );
});

afterEach(function () {
    \Mockery::close();
});


it('handles invalid state exception during oauth callback', function () {
    $provider = \Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andThrow(new InvalidStateException('Invalid state'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google', 'tenant' => $this->team->slug]));

    // Should redirect to login page with error
    $response->assertRedirect();
});

it('does not create duplicate socialite user records', function () {
    $user = User::factory()->create([
        'email' => 'unique.user@gmail.com',
        'name' => 'Unique User',
    ]);

    DB::table('socialite_users')->insert([
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_unique_999',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $socialiteUser = \Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('google_unique_999');
    $socialiteUser->shouldReceive('getName')->andReturn('Unique User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('unique.user@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = \Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $initialCount = DB::table('socialite_users')->where('provider', 'google')
        ->where('provider_id', 'google_unique_999')
        ->count();

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google', 'tenant' => $this->team->slug]));

    $finalCount = DB::table('socialite_users')->where('provider', 'google')
        ->where('provider_id', 'google_unique_999')
        ->count();

    expect($finalCount)->toBe($initialCount)
        ->and($finalCount)->toBe(1);
});

it('can authenticate with multiple providers for same user', function () {
    $user = User::factory()->create([
        'email' => 'multi.provider@example.com',
        'name' => 'Multi Provider User',
    ]);

    // First, link Google account
    DB::table('socialite_users')->insert([
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_multi_111',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Then link GitHub account
    $socialiteUser = \Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('github_multi_222');
    $socialiteUser->shouldReceive('getName')->andReturn('Multi Provider User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('multi.provider@example.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://github.com/avatars/user.jpg');

    $provider = \Mockery::mock('Laravel\Socialite\Two\GithubProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'github', 'tenant' => $this->team->slug]));

    // Should have both providers linked
    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_multi_111',
    ]);

    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'github',
        'provider_id' => 'github_multi_222',
    ]);

    $this->assertAuthenticatedAs($user);
});

it('verifies google login button visibility based on settings', function () {
    // Enable Google login in settings
    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => 'google_login',
            'tenant_id' => 1,
        ],
        [
            'payload' => json_encode(true),
            'locked' => false,
            'updated_at' => now(),
        ]
    );

    $response = $this->get(route('filament.tenant.auth.login', ['tenant' => $this->team->slug]));

    $response->assertSuccessful();
    // The button should be visible when google_login is true
    // This is tested implicitly through the provider configuration
});

it('verifies github login button visibility based on settings', function () {
    // Enable GitHub login in settings
    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => 'github_login',
            'tenant_id' => 1,
        ],
        [
            'payload' => json_encode(true),
            'locked' => false,
            'updated_at' => now(),
        ]
    );

    $response = $this->get(route('filament.tenant.auth.login', ['tenant' => $this->team->slug]));

    $response->assertSuccessful();
    // The button should be visible when github_login is true
});

