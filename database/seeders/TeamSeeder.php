<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::factory(1)->create([
            'name' => 'Super Admin Team',
            'slug' => 'super-admin-team',
        ]);
    }
}
