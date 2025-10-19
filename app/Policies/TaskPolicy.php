<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Task');
    }

    public function view(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('View:Task');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Task');
    }

    public function update(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Update:Task');
    }

    public function delete(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Delete:Task');
    }

    public function restore(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Restore:Task');
    }

    public function forceDelete(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('ForceDelete:Task');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Task');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Task');
    }

    public function replicate(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Replicate:Task');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Task');
    }

}