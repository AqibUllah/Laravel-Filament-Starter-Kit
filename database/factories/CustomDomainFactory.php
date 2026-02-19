<?php

namespace Database\Factories;

use App\Models\CustomDomain;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomDomain>
 */
class CustomDomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'domain' => fake()->domainName(),
            'is_verified' => false,
            'is_primary' => false,
            'dns_verification_token' => str()->random(32),
            'verified_at' => null,
        ];
    }
}
