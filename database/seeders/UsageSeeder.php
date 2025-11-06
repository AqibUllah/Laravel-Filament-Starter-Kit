<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Usage;
use Illuminate\Database\Seeder;

class UsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::with(['subscription.plan.features'])->get();

        foreach ($teams as $team) {
            if (! $team->subscription) {
                continue;
            }

            // Seed last 30 days of sample metrics
            for ($i = 30; $i >= 0; $i--) {
                $day = now()->subDays($i);
                $periodStart = $day->copy()->startOfDay();
                $periodEnd = $day->copy()->endOfDay();

                // API calls metric
                $apiQuantity = rand(500, 5000);
                $apiUnit = 0.001;
                Usage::create([
                    'team_id' => $team->id,
                    'subscription_id' => $team->subscription->id,
                    'plan_feature_id' => optional($team->subscription->plan->features->firstWhere('name', 'api_calls'))->id,
                    'usageable_type' => Team::class,
                    'usageable_id' => $team->id,
                    'metric_name' => 'api_calls',
                    'quantity' => $apiQuantity,
                    'unit_price' => $apiUnit,
                    'total_amount' => $apiQuantity * $apiUnit,
                    'billing_period_start' => $periodStart,
                    'billing_period_end' => $periodEnd,
                    'recorded_at' => $day,
                    'metadata' => [
                        'seeded' => true,
                    ],
                ]);

                // Storage GB metric
                $storageQuantity = rand(1, 50) / 10; // 0.1 - 5.0 GB
                $storageUnit = 0.10;
                Usage::create([
                    'team_id' => $team->id,
                    'subscription_id' => $team->subscription->id,
                    'plan_feature_id' => optional($team->subscription->plan->features->firstWhere('name', 'storage_gb'))->id,
                    'usageable_type' => Team::class,
                    'usageable_id' => $team->id,
                    'metric_name' => 'storage_gb',
                    'quantity' => $storageQuantity,
                    'unit_price' => $storageUnit,
                    'total_amount' => $storageQuantity * $storageUnit,
                    'billing_period_start' => $periodStart,
                    'billing_period_end' => $periodEnd,
                    'recorded_at' => $day,
                    'metadata' => [
                        'seeded' => true,
                    ],
                ]);
            }
        }
    }
}
