<?php

namespace Tests\Feature\Policies;

use App\Models\Project;
use App\Models\Team;
use App\Policies\ProjectPolicy;
use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\User as AuthUser;

// Helper class for testing
class StubUser extends AuthUser
{
    public bool $canValue = false;

    public function __construct(bool $canValue = false)
    {
        parent::__construct();
        $this->canValue = $canValue;
    }

    public function can($ability, $arguments = [])
    {
        return $this->canValue;
    }
}

it('authorizes when user can returns true', function () {
    $policy = new ProjectPolicy;
    $user = new StubUser(true);
    $project = new Project;

    expect($policy->viewAny($user))->toBeTrue()
        ->and($policy->view($user, $project))->toBeTrue()
        ->and($policy->create($user))->toBeTrue()
        ->and($policy->update($user, $project))->toBeTrue()
        ->and($policy->delete($user, $project))->toBeTrue()
        ->and($policy->restore($user, $project))->toBeTrue()
        ->and($policy->forceDelete($user, $project))->toBeTrue()
        ->and($policy->forceDeleteAny($user))->toBeTrue()
        ->and($policy->restoreAny($user))->toBeTrue()
        ->and($policy->replicate($user, $project))->toBeTrue()
        ->and($policy->reorder($user))->toBeTrue();
});

it('denies when user can returns false', function () {
    $policy = new ProjectPolicy;
    $user = new StubUser(false);
    $project = new Project;

    expect($policy->viewAny($user))->toBeFalse()
        ->and($policy->view($user, $project))->toBeFalse()
        ->and($policy->create($user))->toBeFalse()
        ->and($policy->update($user, $project))->toBeFalse()
        ->and($policy->delete($user, $project))->toBeFalse()
        ->and($policy->restore($user, $project))->toBeFalse()
        ->and($policy->forceDelete($user, $project))->toBeFalse()
        ->and($policy->forceDeleteAny($user))->toBeFalse()
        ->and($policy->restoreAny($user))->toBeFalse()
        ->and($policy->replicate($user, $project))->toBeFalse()
        ->and($policy->reorder($user))->toBeFalse();
});
