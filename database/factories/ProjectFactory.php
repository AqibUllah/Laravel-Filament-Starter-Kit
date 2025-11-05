<?php

namespace Database\Factories;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'start_date' => now(),
            'due_date' => now()->addMonths(2),
            'status' => $this->faker->randomElement(ProjectStatusEnum::cases()),
            'team_id' => Team::factory(),
            'project_manager_id' => User::factory(),
            'priority' => $this->faker->randomElement(PriorityEnum::cases()),
        ];
    }
}