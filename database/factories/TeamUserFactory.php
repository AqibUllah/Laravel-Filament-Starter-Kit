<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\TeamUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TeamUserFactory extends Factory
{
    protected $model = TeamUser::class;

    public function definition(): array
    {

        $team = Team::firstOrFail();

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => random_int(1,10),
            'team_id' => $team->id,
        ];
    }
}
