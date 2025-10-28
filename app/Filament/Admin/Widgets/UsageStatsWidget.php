<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Usage;
use App\Services\UsageService;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsageStatsWidget extends BaseWidget
{

    protected ?string $pollingInterval = '600s';

    protected function getStats(): array
    {
        $usageService = app(UsageService::class);
        $analytics = $usageService->getUsageAnalytics();

        $totalUsage = Usage::whereBetween('created_at', [now()->subMonth(), now()])->count();
        $totalRevenue = $analytics['total_revenue'];
        $topMetric = $analytics['metrics']->sortByDesc('total_quantity')->first();

        return [
            Stat::make('Total Usage Records', number_format($totalUsage))
                ->description('Last 30 days')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),

            Stat::make('Usage Revenue', '$' . number_format($totalRevenue, 2))
                ->description('From metered billing')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Top Metric', $topMetric ? $topMetric->metric_name : 'N/A')
                ->description($topMetric ? number_format($topMetric->total_quantity) . ' ' . $topMetric->metric_name : 'No data')
                ->descriptionIcon('heroicon-m-fire')
                ->color('warning'),

            Stat::make('Active Teams', $analytics['top_teams']->count())
                ->description('Using metered billing')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
