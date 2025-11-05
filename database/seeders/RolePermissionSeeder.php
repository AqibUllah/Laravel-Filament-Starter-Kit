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

        $super_admin_role = Role::firstOrCreate([
             'name' => 'team_admin',
             'team_id' => $team->id,
             'guard_name' => 'web'
        ]);

        if (! $admin) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $admin->assignRole($super_admin_role->name);

        if (! $team->members()->where('user_id', $admin->id)->exists()) {
            $team->members()->attach($admin->id);
        }

        $this->command->info('✅Team Admin created successfully For Team!');
        $this->command->info('Email: teamadmin@example.com');
        $this->command->info('Password: password');

        setPermissionsTeamId($team->id);
        $super_admin_role->syncPermissions(Utils::getPermissionModel()::pluck('id'));

        app()[PermissionRegistrar::class]->setPermissionsTeamId(null);
    }
}
