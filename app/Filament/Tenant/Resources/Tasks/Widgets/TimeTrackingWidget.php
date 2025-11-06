<?php

namespace App\Filament\Tenant\Resources\Tasks\Widgets;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TimeTrackingWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [];
        }

        $totalEstimated = Task::forMe()->sum('estimated_hours');
        $totalActual = Task::forMe()->sum('actual_hours');
        $completedTasksWithTime = Task::where('status', TaskStatusEnum::Completed)
            ->whereNotNull('actual_hours')
            ->count();

        $efficiency = $totalEstimated > 0 ? ($totalActual / $totalEstimated) * 100 : 0;

        return [
            Stat::make('Estimated Hours', number_format($totalEstimated, 1))
                ->description('Total estimated time')
                ->icon('heroicon-o-clock')
                ->color('primary'),

            Stat::make('Actual Hours', number_format($totalActual, 1))
                ->description('Total time spent')
                ->icon('heroicon-o-check-badge')
                ->color($totalActual <= $totalEstimated ? 'success' : 'danger'),

            Stat::make('Efficiency', number_format($efficiency, 1).'%')
                ->description('Actual vs Estimated')
                ->icon('heroicon-o-chart-bar')
                ->color($efficiency >= 90 ? 'success' : ($efficiency >= 70 ? 'warning' : 'danger')),
        ];
    }
}
