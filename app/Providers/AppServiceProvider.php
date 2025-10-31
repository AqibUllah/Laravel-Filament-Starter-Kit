<?php

namespace App\Providers;

use App\Filament\Tenant\Resources\Tasks\Pages\ListTaskActivities;
use App\Models\User;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

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
//        if (auth()->user()?->hasAnyRole()){
//            Gate::before(function (User $user, $ability) {
//                return $user->hasRole('super_admin') ? true : null;
//            });
//        }

        app(\Spatie\Permission\PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);
        FilamentShield::prohibitDestructiveCommands($this->app->isProduction());

        Livewire::component(
            'app.filament.tenant.resources.tasks.pages.list-task-activities',
            ListTaskActivities::class
        );
        //
    }
}
