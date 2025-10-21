<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'due_date' => Carbon::now(),
            'priority' => $this->faker->randomElement(['high','low','medium']),
            'status' => $this->faker->randomElement(array: ['pending','completed','in_progress','cancelled']),
            'tags' => $this->faker->words(),
            'estimated_hours' => $this->faker->randomNumber(),
            'actual_hours' => $this->faker->randomNumber(),
            'completed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'team_id' => 1,
            'assigned_by' => 1,
            'assigned_to' => random_int(1,10),
        ];
    }
}
