<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Plan;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlansStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (!$currentTeam) {
            return [];
        }

        // Get current subscription
        $currentSubscription = Subscription::where('team_id', $currentTeam->id)
            ->where('status', 'active')
            ->first();

        $currentPlan = $currentSubscription?->plan;

        // Get plan statistics
        $totalPlans = Plan::query()->active()->count();
        $freePlans = Plan::query()->active()->isFree()->count();
        $paidPlans = Plan::query()->active()->where('price', '>', 0)->count();

        // Get subscription statistics
        $totalSubscriptions = Subscription::where('team_id', $currentTeam->id)->count();
        $activeSubscriptions = Subscription::where('team_id', $currentTeam->id)
            ->where('status', 'active')
            ->count();
        $trialSubscriptions = Subscription::where('team_id', $currentTeam->id)
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now())
            ->count();

        return [
            Stat::make('Current Plan', $currentPlan?->name ?? 'No Plan')
                ->description($currentPlan ? '$' . $currentPlan->price . '/' . $currentPlan->interval : 'No active subscription')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($currentPlan ? 'success' : 'danger')
                ->url(fn (): string => route('filament.tenant.tenant.billing', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),

            Stat::make('Available Plans', $totalPlans)
                ->description($freePlans . ' free, ' . $paidPlans . ' paid')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('primary')
                ->url(fn (): string => route('filament.tenant.pages.plans', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-blue-500/25 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600',
                ]),

            Stat::make('Active Subscriptions', $activeSubscriptions)
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),

            Stat::make('Trial Subscriptions', $trialSubscriptions)
                ->description('On trial period')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-amber-500/25 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-xl p-4 hover:border-amber-300 dark:hover:border-amber-600',
                ]),

            Stat::make('Total Subscriptions', $totalSubscriptions)
                ->description('All time subscriptions')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('secondary')
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-gray-500/25 bg-gradient-to-br from-gray-50 to-slate-100 dark:from-gray-900/20 dark:to-slate-800/20 rounded-xl p-4 hover:border-gray-300 dark:hover:border-gray-600',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
