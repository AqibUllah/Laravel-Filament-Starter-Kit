<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class TeamPerformanceWidget extends ChartWidget
{
    protected ?string $heading = 'Team Performance Overview';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Get team members
        $teamMembers = User::whereHas('teams', function ($query) use ($currentTeam) {
            $query->where('team_id', $currentTeam->id);
        })->get();

        $memberData = [];
        $labels = [];
        $completedTasksData = [];
        $activeProjectsData = [];

        foreach ($teamMembers as $member) {
            $completedTasks = Task::where('assigned_to', $member->id)
                ->where('status', 'completed')
                ->count();

            $activeProjects = Project::whereHas('tasks', function ($query) use ($member) {
                $query->where('assigned_to', $member->id);
            })->where('status', 'in_progress')
                ->count();

            $memberData[] = [
                'name' => $member->name,
                'completed_tasks' => $completedTasks,
                'active_projects' => $activeProjects,
            ];

            $labels[] = $member->name;
            $completedTasksData[] = $completedTasks;
            $activeProjectsData[] = $activeProjects;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Completed Tasks',
                    'data' => $completedTasksData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Active Projects',
                    'data' => $activeProjectsData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
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
