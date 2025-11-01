<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EmailTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EmailTemplate');
    }

    public function view(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('View:EmailTemplate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EmailTemplate');
    }

    public function update(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('Update:EmailTemplate');
    }

    public function delete(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('Delete:EmailTemplate');
    }

    public function restore(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('Restore:EmailTemplate');
    }

    public function forceDelete(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('ForceDelete:EmailTemplate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EmailTemplate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EmailTemplate');
    }

    public function replicate(AuthUser $authUser, EmailTemplate $emailTemplate): bool
    {
        return $authUser->can('Replicate:EmailTemplate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EmailTemplate');
    }

}