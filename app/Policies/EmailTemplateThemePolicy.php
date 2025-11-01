<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EmailTemplateTheme;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplateThemePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EmailTemplateTheme');
    }

    public function view(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('View:EmailTemplateTheme');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EmailTemplateTheme');
    }

    public function update(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('Update:EmailTemplateTheme');
    }

    public function delete(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('Delete:EmailTemplateTheme');
    }

    public function restore(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('Restore:EmailTemplateTheme');
    }

    public function forceDelete(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('ForceDelete:EmailTemplateTheme');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EmailTemplateTheme');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EmailTemplateTheme');
    }

    public function replicate(AuthUser $authUser, EmailTemplateTheme $emailTemplateTheme): bool
    {
        return $authUser->can('Replicate:EmailTemplateTheme');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EmailTemplateTheme');
    }

}