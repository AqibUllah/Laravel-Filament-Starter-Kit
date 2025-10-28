<?php

namespace App\Services;

use App\Models\Usage;
use App\Models\Team;
use App\Models\Subscription;
use App\Models\PlanFeature;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UsageService
{
    /**
     * Record usage for a team
     */
    public function recordUsage(
        Team $team,
        string $metricName,
        float $quantity,
        float $unitPrice = 0,
        $usageable = null,
        array $metadata = []
    ): Usage {
        $subscription = $team->subscription;
        $billingPeriod = $this->getCurrentBillingPeriod($subscription);

        $totalAmount = $quantity * $unitPrice;

        $usage = Usage::create([
            'team_id' => $team->id,
            'subscription_id' => $subscription?->id,
            'plan_feature_id' => $this->getPlanFeatureForMetric($subscription, $metricName)?->id,
            'usageable_type' => $usageable ? get_class($usageable) : null,
            'usageable_id' => $usageable?->id,
            'metric_name' => $metricName,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount,
            'billing_period_start' => $billingPeriod['start'],
            'billing_period_end' => $billingPeriod['end'],
            'recorded_at' => now(),
            'metadata' => $metadata,
        ]);

        Log::info('Usage recorded', [
            'team_id' => $team->id,
            'metric' => $metricName,
            'quantity' => $quantity,
            'amount' => $totalAmount,
        ]);

        return $usage;
    }

    /**
     * Get current billing period for a subscription
     */
    public function getCurrentBillingPeriod(?Subscription $subscription): array
    {
        if (!$subscription) {
            // Default to monthly period if no subscription
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } else {
            // Calculate based on subscription billing cycle
            $start = $subscription->created_at->startOfMonth();
            $end = $subscription->created_at->endOfMonth();

            // If we're past the end date, move to next period
            while ($end->isPast()) {
                $start = $start->addMonth();
                $end = $end->addMonth();
            }
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * Get plan feature for a specific metric
     */
    public function getPlanFeatureForMetric(?Subscription $subscription, string $metricName): ?PlanFeature
    {
        if (!$subscription || !$subscription->plan) {
            return null;
        }

        return $subscription->plan->features()
            ->where('name', $metricName)
            ->first();
    }

    /**
     * Get usage summary for a team
     */
    public function getUsageSummary(Team $team, Carbon $start = null, Carbon $end = null): array
    {
        if (!$start || !$end) {
            $billingPeriod = $this->getCurrentBillingPeriod($team->subscription);
            $start = $billingPeriod['start'];
            $end = $billingPeriod['end'];
        }

        $usage = Usage::forTeam($team->id)
            ->forBillingPeriod($start, $end)
            ->selectRaw('metric_name, SUM(quantity) as total_quantity, SUM(total_amount) as total_amount')
            ->groupBy('metric_name')
            ->get();

        return [
            'period' => [
                'start' => $start,
                'end' => $end,
            ],
            'metrics' => $usage,
            'total_amount' => $usage->sum('total_amount'),
        ];
    }

    /**
     * Check if team has exceeded usage limits
     */
    public function checkUsageLimits(Team $team, string $metricName, float $additionalQuantity = 0): array
    {
        $subscription = $team->subscription;
        if (!$subscription || !$subscription->plan) {
            return [
                'allowed' => true,
                'current_usage' => 0,
                'limit' => null,
                'remaining' => null,
            ];
        }

        $planFeature = $this->getPlanFeatureForMetric($subscription, $metricName);
        if (!$planFeature) {
            return [
                'allowed' => true,
                'current_usage' => 0,
                'limit' => null,
                'remaining' => null,
            ];
        }

        $billingPeriod = $this->getCurrentBillingPeriod($subscription);
        $currentUsage = Usage::forTeam($team->id)
            ->forMetric($metricName)
            ->forBillingPeriod($billingPeriod['start'], $billingPeriod['end'])
            ->sum('quantity');

        $totalUsage = $currentUsage + $additionalQuantity;
        $limit = $planFeature->value;

        // If limit is 0 or null, it means unlimited
        if ($limit === 0 || $limit === null) {
            return [
                'allowed' => true,
                'current_usage' => $currentUsage,
                'limit' => 'unlimited',
                'remaining' => 'unlimited',
            ];
        }

        $allowed = $totalUsage <= $limit;
        $remaining = max(0, $limit - $currentUsage);

        return [
            'allowed' => $allowed,
            'current_usage' => $currentUsage,
            'limit' => $limit,
            'remaining' => $remaining,
        ];
    }

    /**
     * Calculate overage charges
     */
    public function calculateOverageCharges(Team $team, string $metricName): float
    {
        $subscription = $team->subscription;
        if (!$subscription || !$subscription->plan) {
            return 0;
        }

        $planFeature = $this->getPlanFeatureForMetric($subscription, $metricName);
        if (!$planFeature) {
            return 0;
        }

        $billingPeriod = $this->getCurrentBillingPeriod($subscription);
        $currentUsage = Usage::forTeam($team->id)
            ->forMetric($metricName)
            ->forBillingPeriod($billingPeriod['start'], $billingPeriod['end'])
            ->sum('quantity');

        $limit = $planFeature->value;
        if ($limit === 0 || $limit === null || $currentUsage <= $limit) {
            return 0;
        }

        $overage = $currentUsage - $limit;
        $overagePrice = $planFeature->metadata['overage_price'] ?? 0;

        return $overage * $overagePrice;
    }

    /**
     * Get usage analytics for admin dashboard
     */
    public function getUsageAnalytics(Carbon $start = null, Carbon $end = null): array
    {
        if (!$start || !$end) {
            $start = now()->subMonth();
            $end = now();
        }

        $totalUsage = Usage::query()->forBillingPeriod($start, $end)
            ->selectRaw('metric_name, SUM(quantity) as total_quantity, SUM(total_amount) as total_amount, COUNT(DISTINCT team_id) as team_count')
            ->groupBy('metric_name')
            ->get();

        $topTeams = Usage::query()->forBillingPeriod($start, $end)
            ->selectRaw('team_id, SUM(total_amount) as total_amount')
            ->groupBy('team_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->with('team')
            ->get();

        return [
            'period' => [
                'start' => $start,
                'end' => $end,
            ],
            'metrics' => $totalUsage,
            'top_teams' => $topTeams,
            'total_revenue' => $totalUsage->sum('total_amount'),
        ];
    }

    /**
     * Record API call usage
     */
    public function recordApiCall(Team $team, string $endpoint, int $responseTime = 0): Usage
    {
        return $this->recordUsage(
            $team,
            'api_calls',
            1,
            0.001, // $0.001 per API call
            null,
            [
                'endpoint' => $endpoint,
                'response_time' => $responseTime,
            ]
        );
    }

    /**
     * Record storage usage
     */
    public function recordStorageUsage(Team $team, float $gbUsed, $file = null): Usage
    {
        return $this->recordUsage(
            $team,
            'storage_gb',
            $gbUsed,
            0.10, // $0.10 per GB
            $file,
            [
                'file_size_gb' => $gbUsed,
            ]
        );
    }

    /**
     * Record user usage
     */
    public function recordUserUsage(Team $team, $user = null): Usage
    {
        return $this->recordUsage(
            $team,
            'active_users',
            1,
            2.00, // $2.00 per active user
            $user,
            [
                'user_type' => 'active',
            ]
        );
    }

    /**
     * Record project usage
     */
    public function recordProjectUsage(Team $team, $project = null, float $quantity = 1, float $unitPrice = 1.00): Usage
    {
        return $this->recordUsage(
            $team,
            'projects',
            $quantity,
            $unitPrice,
            $project,
            []
        );
    }
}
