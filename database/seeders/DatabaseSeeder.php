<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Delete the super_admin role with null team_id created by shield:generate
        Role::withoutGlobalScopes()
        // ->whereNull('team_id')
        ->where('name', 'super_admin')
        ->delete();

        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            TeamUserSeeder::class,
            RolePermissionSeeder::class,
            TaskSeeder::class,
            PlanSeeder::class,
            PlanFeatureSeeder::class,
            CouponSeeder::class
//            SubscriptionSeeder::class
        ]);

    }
}
