<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $team = Team::first();

        if (! $team) {
            $this->command->error('No team found. Please seed or create a team first.');
            return;
        }

        $super_admin_role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'team_id' => Team::first()->id,
            'guard_name' => 'web'
        ]);

        $this->command->info('✅Super Admin created successfully!');
        $this->command->info('Email: superadmin@example.com');
        $this->command->info('Password: password');

        $admin = User::first();
        if (! $admin) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $admin->assignRole($super_admin_role->name);

        // ✅ Attach user to the team if not already attached
        if (! $team->members()->where('user_id', $admin->id)->exists()) {
            $team->members()->attach($admin->id);
        }
    }
}
