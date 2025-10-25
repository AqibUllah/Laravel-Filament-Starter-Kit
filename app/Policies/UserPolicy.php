<?php

namespace App\Policies;

use App\Models\Team;
use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:User');
    }

    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:User');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User') &&
            app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->canCreateUser();
    }

    public function update(AuthUser $authUser): bool
    {
        return $authUser->can('Update:User');
    }

    public function delete(AuthUser $authUser): bool
    {
        return $authUser->can('Delete:User');
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:User');
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }

    public function getUsageStats(): array
    {
        $team = Filament::getTenant();
        $limiter = app(FeatureLimiterService::class)->forTenant($team);

        $currentUsers = $team->members()->count();
        $maxUsers = $limiter->getFeatureLimit('Users');
        $remaining = $limiter->getRemainingUsers();

        $percentage = $maxUsers > 0 ? ($currentUsers / $maxUsers) * 100 : 0;

        return [
            'current' => $currentUsers,
            'max' => $maxUsers,
            'remaining' => $remaining,
            'percentage' => $percentage,
            'is_limit_reached' => !$limiter->canCreateUser(),
            'is_approaching_limit' => $percentage >= 80,
        ];
    }

}
