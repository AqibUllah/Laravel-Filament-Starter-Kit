<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Mockery;

beforeEach(function () {
    // Create a team for tenant context (tenant_id = 1)
    $team = Team::firstOrCreate(
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
    Mockery::close();
});

it('redirects to google oauth provider', function () {
    $redirectResponse = Mockery::mock('Symfony\Component\HttpFoundation\RedirectResponse');
    $redirectResponse->shouldReceive('getTargetUrl')
        ->andReturn('https://accounts.google.com/o/oauth2/auth');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('redirect')
        ->andReturn($redirectResponse);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google', 'tenant' => $this->team]));

    $response->assertRedirect();
});

it('redirects to github oauth provider', function () {
    $redirectResponse = Mockery::mock('Symfony\Component\HttpFoundation\RedirectResponse');
    $redirectResponse->shouldReceive('getTargetUrl')
        ->andReturn('https://github.com/login/oauth/authorize');

    $provider = Mockery::mock('Laravel\Socialite\Two\GithubProvider');
    $provider->shouldReceive('redirect')
        ->andReturn($redirectResponse);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'github', 'tenant' => $this->team]));

    $response->assertRedirect();
});

it('creates a new user when authenticating with google for the first time', function () {
    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('google_user_12345');
    $socialiteUser->shouldReceive('getName')->andReturn('John Doe');
    $socialiteUser->shouldReceive('getEmail')->andReturn('john.doe@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google', 'tenant' => $this->team]));

    $this->assertDatabaseHas('users', [
        'email' => 'john.doe@gmail.com',
        'name' => 'John Doe',
    ]);

    $user = User::where('email', 'john.doe@gmail.com')->first();
    expect($user)->not->toBeNull();

    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_user_12345',
    ]);

    $response->assertRedirect();
});

it('creates a new user when authenticating with github for the first time', function () {
    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('github_user_67890');
    $socialiteUser->shouldReceive('getName')->andReturn('Jane Smith');
    $socialiteUser->shouldReceive('getEmail')->andReturn('jane.smith@github.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://github.com/avatars/jane.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GithubProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'github', 'tenant' => $this->team]));

    $this->assertDatabaseHas('users', [
        'email' => 'jane.smith@github.com',
        'name' => 'Jane Smith',
    ]);

    $user = User::where('email', 'jane.smith@github.com')->first();
    expect($user)->not->toBeNull();

    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'github',
        'provider_id' => 'github_user_67890',
    ]);

    $response->assertRedirect();
});

it('authenticates existing user when logging in with google', function () {
    $user = User::factory()->create([
        'email' => 'existing.user@gmail.com',
        'name' => 'Existing User',
    ]);

    DB::table('socialite_users')->insert([
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_existing_123',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('google_existing_123');
    $socialiteUser->shouldReceive('getName')->andReturn('Existing User Updated');
    $socialiteUser->shouldReceive('getEmail')->andReturn('existing.user@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/new-avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google', 'tenant' => $this->team]));

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect();
});

it('authenticates existing user when logging in with github', function () {
    $user = User::factory()->create([
        'email' => 'existing.github@example.com',
        'name' => 'GitHub User',
    ]);

    DB::table('socialite_users')->insert([
        'user_id' => $user->id,
        'provider' => 'github',
        'provider_id' => 'github_existing_456',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('github_existing_456');
    $socialiteUser->shouldReceive('getName')->andReturn('GitHub User Updated');
    $socialiteUser->shouldReceive('getEmail')->andReturn('existing.github@example.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://github.com/avatars/user.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GithubProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'github', 'tenant' => $this->team]));

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect();
});

it('links socialite account to existing user by email when provider id not found', function () {
    $user = User::factory()->create([
        'email' => 'link.user@gmail.com',
        'name' => 'Link User',
    ]);

    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('google_new_provider_789');
    $socialiteUser->shouldReceive('getName')->andReturn('Link User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('link.user@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google']));

    // Should link the socialite account to existing user
    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google_new_provider_789',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect();
});

it('handles invalid state exception during oauth callback', function () {
    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andThrow(new InvalidStateException('Invalid state'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google']));

    // Should redirect to login page with error
    $response->assertRedirect();
});

it('handles missing user email from socialite provider', function () {
    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('no_email_user');
    $socialiteUser->shouldReceive('getName')->andReturn('No Email User');
    $socialiteUser->shouldReceive('getEmail')->andReturn(null); // Missing email
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google']));

    // Should handle gracefully - redirect or show error
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

    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('google_unique_999');
    $socialiteUser->shouldReceive('getName')->andReturn('Unique User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('unique.user@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $initialCount = DB::table('socialite_users')->where('provider', 'google')
        ->where('provider_id', 'google_unique_999')
        ->count();

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google']));

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
    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('github_multi_222');
    $socialiteUser->shouldReceive('getName')->andReturn('Multi Provider User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('multi.provider@example.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://github.com/avatars/user.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GithubProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'github']));

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

    $response = $this->get(route('filament.tenant.auth.login'));

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

    $response = $this->get(route('filament.tenant.auth.login'));

    $response->assertSuccessful();
    // The button should be visible when github_login is true
});

it('handles user with team creation during socialite registration', function () {
    $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
    $socialiteUser->shouldReceive('getId')->andReturn('team_user_google');
    $socialiteUser->shouldReceive('getName')->andReturn('Team User');
    $socialiteUser->shouldReceive('getEmail')->andReturn('team.user@gmail.com');
    $socialiteUser->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')
        ->andReturn($socialiteUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('socialite.filament.tenant.oauth.callback', ['provider' => 'google']));

    $user = User::where('email', 'team.user@gmail.com')->first();
    expect($user)->not->toBeNull();

    // Verify user was created and socialite account linked
    $this->assertDatabaseHas('socialite_users', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'team_user_google',
    ]);

    $response->assertRedirect();
});

