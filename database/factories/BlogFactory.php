<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'featured_image' => $this->faker->word(),
            'excerpt' => $this->faker->word(),
            'content' => $this->faker->word(),
            'is_published' => $this->faker->boolean(),
            'published_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'team_id' => Team::factory(),
            'user_id' => User::factory(),
        ];
    }
}
