<?php

/**
 * Laravel Filament SaaS Starter Kit
 *
 * Copyright (C) 2024 [Your Name/Organization]
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * Commercial use of this software is prohibited without written permission.
 * For licensing inquiries, please contact the copyright holder.
 */

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
