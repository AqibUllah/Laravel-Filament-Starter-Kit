<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TaskProgressChartWidget extends ChartWidget
{
    protected ?string $heading = 'Task Completion Over Time';

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

        // Get task completion data for the last 30 days
        $completedTasks = Task::where('team_id', $currentTeam->id)
            ->where('status', TaskStatusEnum::Completed)
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy(function ($task) {
                return $task->updated_at->format('Y-m-d');
            });

        $labels = [];
        $completedData = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateLabel = Carbon::now()->subDays($i)->format('M d');

            $labels[] = $dateLabel;
            $completedData[] = $completedTasks->get($date, collect())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks Completed',
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'fill' => true,
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
