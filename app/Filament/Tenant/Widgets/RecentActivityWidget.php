<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RecentActivityWidget extends ChartWidget
{
    protected ?string $heading = 'Recent Activity Overview';

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

        // Get activity data for the last 30 days
        $projects = Project::where('team_id', $currentTeam->id)
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy(function ($project) {
                return $project->updated_at->format('Y-m-d');
            });

        $tasks = Task::where('team_id', $currentTeam->id)
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy(function ($task) {
                return $task->updated_at->format('Y-m-d');
            });

        $subscriptions = Subscription::where('team_id', $currentTeam->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy(function ($subscription) {
                return $subscription->created_at->format('Y-m-d');
            });

        $labels = [];
        $projectData = [];
        $taskData = [];
        $subscriptionData = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateLabel = Carbon::now()->subDays($i)->format('M d');

            $labels[] = $dateLabel;
            $projectData[] = $projects->get($date, collect())->count();
            $taskData[] = $tasks->get($date, collect())->count();
            $subscriptionData[] = $subscriptions->get($date, collect())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Project Updates',
                    'data' => $projectData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Task Updates',
                    'data' => $taskData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'New Subscriptions',
                    'data' => $subscriptionData,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderColor' => 'rgb(245, 158, 11)',
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.4,
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
