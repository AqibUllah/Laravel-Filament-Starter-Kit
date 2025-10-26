<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProjects = Project::count();
        $activeProjects = Project::count();
        $completedProjects = Project::completed()->count();
        $overdueProjects = Project::overdue()->count();

        $avgProgress = Project::where('status', '!=', ProjectStatusEnum::Cancelled)
            ->avg('progress') ?? 0;

        return [
            Stat::make('Total Projects', $totalProjects)
                ->description('All projects in my team')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('primary'),

            Stat::make('Active Projects', $activeProjects)
                ->description('Currently in progress')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('warning'),

            Stat::make('Completed Projects', $completedProjects)
                ->description('Successfully finished')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Overdue Projects', $overdueProjects)
                ->description('Past due date')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdueProjects > 0 ? 'danger' : 'success'),

            Stat::make('Average Progress', round($avgProgress, 1) . '%')
                ->description('Overall completion rate')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color(match (true) {
                    $avgProgress >= 80 => 'success',
                    $avgProgress >= 60 => 'warning',
                    default => 'danger',
                }),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
