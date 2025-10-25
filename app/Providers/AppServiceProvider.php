<?php

namespace App\Providers;

use App\Models\User;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (auth()->user()?->hasAnyRole()){
            Gate::before(function (User $user, $ability) {
                return $user->hasRole('super_admin') ? true : null;
            });
        }

        app(\Spatie\Permission\PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);
        FilamentShield::prohibitDestructiveCommands($this->app->isProduction());
        //
    }
}
