<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Plan;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MainOverviewStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [];
        }

        // Project Statistics
        $totalProjects = Project::count();
        $activeProjects = Project::query()->active()->count();
        $completedProjects = Project::query()->completed()->count();
        $overdueProjects = Project::query()->overdue()->count();

        // Task Statistics
        $totalTasks = Task::forMe()->count();
        $completedTasks = Task::forMe()->completed()->count();
        $overdueTasks = Task::forMe()->overdue()->count();
        $myPendingTasks = Task::forMe()->pending()->count();

        // Plan & Subscription Statistics
        $currentSubscription = Subscription::where('team_id', $currentTeam->id)
            ->where('status', 'active')
            ->first();
        $currentPlan = $currentSubscription?->plan;
        $activeSubscriptions = Subscription::where('team_id', $currentTeam->id)
            ->where('status', 'active')
            ->count();

        // Time Tracking Statistics
        $totalEstimated = Task::forMe()->sum('estimated_hours');
        $totalActual = Task::forMe()->sum('actual_hours');
        $efficiency = $totalEstimated > 0 ? ($totalActual / $totalEstimated) * 100 : 0;

        return [
            Stat::make('Active Projects', $activeProjects)
                ->description('Currently in progress')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('warning')
                ->url(fn (): string => route('filament.tenant.pages.project-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-amber-500/25 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-xl p-4 hover:border-amber-300 dark:hover:border-amber-600',
                ]),

            Stat::make('My Pending Tasks', $myPendingTasks)
                ->description('Assigned to me')
                ->descriptionIcon('heroicon-m-user')
                ->color('primary')
                ->url(fn (): string => route('filament.tenant.pages.task-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-blue-500/25 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600',
                ]),

            Stat::make('Current Plan', $currentPlan?->name ?? 'No Plan')
                ->description($currentPlan ? '$'.$currentPlan->price.'/'.$currentPlan->interval : 'No active subscription')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($currentPlan ? 'success' : 'danger')
                ->url(fn (): string => route('filament.tenant.pages.plans-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),

            Stat::make('Overdue Items', $overdueProjects + $overdueTasks)
                ->description($overdueProjects.' projects, '.$overdueTasks.' tasks')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color(($overdueProjects + $overdueTasks) > 0 ? 'danger' : 'success')
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-red-500/25 bg-gradient-to-br from-red-50 to-rose-100 dark:from-red-900/20 dark:to-rose-800/20 rounded-xl p-4 hover:border-red-300 dark:hover:border-red-600',
                ]),

            Stat::make('Task Efficiency', number_format($efficiency, 1).'%')
                ->description('Actual vs Estimated time')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($efficiency >= 90 ? 'success' : ($efficiency >= 70 ? 'warning' : 'danger'))
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-purple-500/25 bg-gradient-to-br from-purple-50 to-violet-100 dark:from-purple-900/20 dark:to-violet-800/20 rounded-xl p-4 hover:border-purple-300 dark:hover:border-purple-600',
                ]),

            Stat::make('Completion Rate', $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1).'%' : '0%')
                ->description('Tasks completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($totalTasks > 0 && ($completedTasks / $totalTasks) >= 0.8 ? 'success' : ($totalTasks > 0 && ($completedTasks / $totalTasks) >= 0.6 ? 'warning' : 'danger'))
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
