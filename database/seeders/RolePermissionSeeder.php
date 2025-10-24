<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Facades\Filament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $team = Team::first();

        if (! $team) {
            $this->command->error('No team found. Please seed or create a team first.');
            return;
        }
        $admin = User::first();

        // Set tenant and permissions team context to match the target team
        app()[PermissionRegistrar::class]->setPermissionsTeamId($team->id);

        $roles = [
            'starter_member','pro_member','business_member',
            'enterprise_member','pro_yearly_member','business_yearly_member',
        ];

        foreach ($roles as $key => $role) {
            Role::create([
                'name'  => $role,
                // 'team_id'  => $team->id,
                'guard_name'  => 'web',
            ]);
        }

        $super_admin_role = Role::firstOrCreate([
            'name' => 'super_admin',
            // 'team_id' => $team->id,
            'guard_name' => 'web'
        ]);


        // After creating $super_admin_role and assigning it to $admin
        $super_admin_role->givePermissionTo(Permission::all());



        if (! $admin) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $admin->assignRole($super_admin_role->name);

        // ✅ Attach user to the team if not already attached
        if (! $team->members()->where('user_id', $admin->id)->exists()) {
            $team->members()->attach($admin->id);
        }

        $this->command->info('✅Super Admin created successfully!');
        $this->command->info('Email: superadmin@example.com');
        $this->command->info('Password: password');

        setPermissionsTeamId($team->id);
        $super_admin_role->syncPermissions(Utils::getPermissionModel()::pluck('id'));

        // Optional: Reset context (not strictly needed in a seeder)
        app()[PermissionRegistrar::class]->setPermissionsTeamId(null);

        $starter_role = Role::firstOrCreate(['name' => 'starter_member','guard_name' => 'web']);

        $resources = ['User', 'Task']; // your Filament resource names

        foreach ($resources as $resource) {
            $permissions = [
                "ViewAny:{$resource}",
                "View:{$resource}",
                "Create:{$resource}",
                "Update:{$resource}",
                "Delete:{$resource}",
                "ForceDelete:{$resource}",
                "ForceDeleteAny:{$resource}",
                "Restore:{$resource}",
                "RestoreAny:{$resource}",
                "Replicate:{$resource}",
                "Reorder:{$resource}",
                "DeleteAny:{$resource}",
            ];

            $starter_role->givePermissionTo($permissions);
        }

        // ✅ Custom pages
        $pages = ['SubscriptionSuccess', 'SubscriptionStatus', 'Dashboard'];
        foreach ($pages as $page) {
            $permission = "View:{$page}";
            Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($permission);
        }
    }
}
