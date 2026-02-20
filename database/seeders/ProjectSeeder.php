<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first();
        $projectManager = $team->members()->first();

        if ($team && $projectManager) {
            // Create 47 additional projects to reach the limit of 50
            Project::factory(47)->create([
                'team_id' => $team->id,
                'project_manager_id' => $projectManager->id,
            ]);
        }
    }
}
