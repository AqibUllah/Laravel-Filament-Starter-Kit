<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PlanFeature;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanFeaturePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PlanFeature');
    }

    public function view(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('View:PlanFeature');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PlanFeature');
    }

    public function update(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('Update:PlanFeature');
    }

    public function delete(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('Delete:PlanFeature');
    }

    public function restore(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('Restore:PlanFeature');
    }

    public function forceDelete(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('ForceDelete:PlanFeature');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PlanFeature');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PlanFeature');
    }

    public function replicate(AuthUser $authUser, PlanFeature $planFeature): bool
    {
        return $authUser->can('Replicate:PlanFeature');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PlanFeature');
    }

}