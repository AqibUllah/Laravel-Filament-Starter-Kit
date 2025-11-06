<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProjects = Project::count();
        $activeProjects = Project::query()->active()->count();
        $completedProjects = Project::query()->completed()->count();
        $overdueProjects = Project::query()->overdue()->count();

        $avgProgress = Project::where('status', '!=', ProjectStatusEnum::Cancelled)
            ->avg('progress') ?? 0;

        return [
            Stat::make('Total Projects', $totalProjects)
                ->description('All projects in my team')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('secondary')
                ->url(fn (): string => route('filament.tenant.resources.projects.index', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-blue-500/25 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600',
                ]),

            Stat::make('Active Projects', $activeProjects)
                ->description('Currently in progress')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('warning')
                ->url(fn (): string => route('filament.tenant.resources.projects.index', ['filters' => ['status' => ['values' => [ProjectStatusEnum::Planning, ProjectStatusEnum::InProgress]]], 'tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-amber-500/25 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-xl p-4 hover:border-amber-300 dark:hover:border-amber-600',
                ]),

            Stat::make('Completed Projects', $completedProjects)
                ->description('Successfully finished')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->url(fn (): string => route('filament.tenant.resources.projects.index', ['filters' => ['status' => ['values' => [ProjectStatusEnum::Completed]]], 'tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),

            Stat::make('Overdue Projects', $overdueProjects)
                ->description('Past due date')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdueProjects > 0 ? 'danger' : 'success')
                ->url(fn (): string => route('filament.tenant.resources.projects.index', ['filters' => ['overdue' => ['isActive' => true]], 'tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-red-500/25 bg-gradient-to-br from-red-50 to-rose-100 dark:from-red-900/20 dark:to-rose-800/20 rounded-xl p-4 hover:border-red-300 dark:hover:border-red-600',
                ]),

            Stat::make('Average Progress', round($avgProgress, 1).'%')
                ->description('Overall completion rate')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color(match (true) {
                    $avgProgress >= 80 => 'success',
                    $avgProgress >= 60 => 'warning',
                    default => 'danger',
                })
                ->url(fn (): string => route('filament.tenant.resources.projects.index', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-purple-500/25 bg-gradient-to-br from-purple-50 to-violet-100 dark:from-purple-900/20 dark:to-violet-800/20 rounded-xl p-4 hover:border-purple-300 dark:hover:border-purple-600',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
