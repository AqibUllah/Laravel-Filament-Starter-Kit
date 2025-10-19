<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TaskStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (!$currentTeam) {
            return [];
        }

        $totalTasks = Task::where('team_id', $currentTeam->id)->count();
        $completedTasks = Task::where('team_id', $currentTeam->id)->completed()->count();
        $overdueTasks = Task::where('team_id', $currentTeam->id)->overdue()->count();
        $myPendingTasks = Task::where('team_id', $currentTeam->id)
            ->where('assigned_to', auth()->id())
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
