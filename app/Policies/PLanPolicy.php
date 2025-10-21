<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PLan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PLanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PLan');
    }

    public function view(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('View:PLan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PLan');
    }

    public function update(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('Update:PLan');
    }

    public function delete(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('Delete:PLan');
    }

    public function restore(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('Restore:PLan');
    }

    public function forceDelete(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('ForceDelete:PLan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PLan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PLan');
    }

    public function replicate(AuthUser $authUser, PLan $pLan): bool
    {
        return $authUser->can('Replicate:PLan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PLan');
    }

}