<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TaskStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [];
        }

        $totalTasks = Task::forMe()->count();
        $completedTasks = Task::forMe()->completed()->count();
        $overdueTasks = Task::forMe()->overdue()->count();

        $myPendingTasks = Task::forMe()
            ->pending()
            ->count();

        return [
            Stat::make('Total Tasks', $totalTasks)
                ->description('All team tasks')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary'),

            Stat::make('Completed Tasks', $completedTasks)
                ->description('Successfully completed')
                ->icon('heroicon-o-check-badge')
                ->color('success'),

            Stat::make('Overdue Tasks', $overdueTasks)
                ->description('Need attention')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),

            Stat::make('My Pending Tasks', $myPendingTasks)
                ->description('Assigned to me')
                ->icon('heroicon-o-user')
                ->color('warning'),
        ];
    }
}
