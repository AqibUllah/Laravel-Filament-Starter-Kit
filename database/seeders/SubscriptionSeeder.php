<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some teams and plans to create subscriptions
        $teams = Team::take(5)->get();
        $plans = Plan::where('is_active', true)->get();

        if ($teams->isEmpty() || $plans->isEmpty()) {
            $this->command->warn('No teams or plans found. Please run TeamSeeder and PlanSeeder first.');

            return;
        }

        $subscriptions = [];

        // Create active subscriptions
        foreach ($teams as $index => $team) {
            $plan = $plans->random();

            $status = $index % 3 == 0 ? 'active' : ($index % 3 == 1 ? 'trialing' : 'past_due');

            $subscriptions[] = [
                'team_id' => $team->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => 'sub_'.Str::random(14),
                'stripe_customer_id' => 'cus_THILz9Qx4zKqlN',
                'status' => $status,
                'trial_ends_at' => $status === 'trialing' ? Carbon::now()->addDays(7) : null,
                'ends_at' => $status === 'past_due' ? Carbon::now()->addDays(15) : null,
                'canceled_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Create some canceled subscriptions
        $additionalTeams = Team::skip(5)->take(3)->get();
        foreach ($additionalTeams as $team) {
            $plan = $plans->random();

            $subscriptions[] = [
                'team_id' => $team->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => 'sub_'.Str::random(14),
                'stripe_customer_id' => 'cus_'.Str::random(14),
                'status' => 'canceled',
                'trial_ends_at' => null,
                'ends_at' => Carbon::now()->subDays(5),
                'canceled_at' => Carbon::now()->subDays(10),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(5),
            ];
        }

        // Create some incomplete subscriptions (failed payments)
        $incompleteTeams = Team::skip(8)->take(2)->get();
        foreach ($incompleteTeams as $team) {
            $plan = $plans->random();

            $subscriptions[] = [
                'team_id' => $team->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => 'sub_'.Str::random(14),
                'stripe_customer_id' => 'cus_'.Str::random(14),
                'status' => 'incomplete',
                'trial_ends_at' => null,
                'ends_at' => null,
                'canceled_at' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ];
        }

        foreach ($subscriptions as $subscriptionData) {
            Subscription::create($subscriptionData);
        }

        $this->command->info('Subscriptions seeded successfully!');
        $this->command->info('Active: '.Subscription::where('status', 'active')->count());
        $this->command->info('Trialing: '.Subscription::where('status', 'trialing')->count());
        $this->command->info('Past Due: '.Subscription::where('status', 'past_due')->count());
        $this->command->info('Canceled: '.Subscription::where('status', 'canceled')->count());
        $this->command->info('Incomplete: '.Subscription::where('status', 'incomplete')->count());
    }
}
