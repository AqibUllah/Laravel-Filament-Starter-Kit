<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\PriorityEnum;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class TaskPriorityChartWidget extends ChartWidget
{
    protected ?string $heading = 'Task Priority Distribution';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $currentTeam = Filament::getTenant();

        if (!$currentTeam) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $tasks = Task::where('team_id', $currentTeam->id)
            ->where('status', '!=', 'completed')
            ->get()
            ->groupBy('priority');

        $priorityData = [];
        $labels = [];
        $colors = [];

        foreach (PriorityEnum::cases() as $priority) {
            $count = $tasks->get($priority->value, collect())->count();
            $priorityData[] = $count;
            $labels[] = ucfirst($priority->value);

            // Set colors based on priority
            $colors[] = match ($priority) {
                PriorityEnum::High => 'rgba(239, 68, 68, 0.8)',      // red
                PriorityEnum::Medium => 'rgba(245, 158, 11, 0.8)',   // yellow
                PriorityEnum::LOW => 'rgba(34, 197, 94, 0.8)',       // green
            };
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks by Priority',
                    'data' => $priorityData,
                    'backgroundColor' => $colors,
                    'borderColor' => array_map(function($color) {
                        return str_replace('0.8', '1', $color);
                    }, $colors),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
