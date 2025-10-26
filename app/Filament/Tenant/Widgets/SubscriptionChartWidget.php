<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Plan;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SubscriptionChartWidget extends ChartWidget
{
    protected ?string $heading = 'Subscription Analytics';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentTeam = Filament::getTenant();

        if (!$currentTeam) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Get subscription data for the last 12 months
        $subscriptions = Subscription::where('created_at', '>=', Carbon::now()->subMonths(12))
            ->get()
            ->groupBy(function ($subscription) {
                return $subscription->created_at->format('Y-m');
            });

        // Get plan data for comparison
        $plans = Plan::query()->active()->get();

        $labels = [];
        $subscriptionData = [];
        $planData = [];

        // Generate last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $monthLabel = Carbon::now()->subMonths($i)->format('M Y');

            $labels[] = $monthLabel;
            $subscriptionData[] = $subscriptions->get($month, collect())->count();
        }

        // Plan distribution data
        $planDistribution = $plans->map(function ($plan) {
            return [
                'name' => $plan->name,
                'count' => Subscription::where('plan_id', $plan->id)->count(),
                'price' => $plan->price,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'New Subscriptions',
                    'data' => $subscriptionData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
