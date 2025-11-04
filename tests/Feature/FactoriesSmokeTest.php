<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create users via factory', function () {
    $users = User::factory()->count(3)->create();
    expect($users)->toHaveCount(3)
        ->and(User::count())->toBe(3);
});

it('can create teams via factory', function () {
    $teams = Team::factory()->count(2)->create([
        'owner_id' => User::factory()
    ]);
    expect($teams)->toHaveCount(2)
        ->and(Team::count())->toBe(2);
});


