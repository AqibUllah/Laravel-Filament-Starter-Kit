<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class ProjectProgressChartWidget extends ChartWidget
{
    protected ?string $heading = 'Project Progress Overview';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentTeam = Filament::getTenant();

        $projects = Project::where('status', '!=', ProjectStatusEnum::Cancelled)
            ->orderBy('progress', 'desc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Progress %',
                    'data' => $projects->pluck('progress')->toArray(),
                    'backgroundColor' => $projects->map(function ($project) {
                        return match (true) {
                            $project->progress >= 100 => '#10b981', // green
                            $project->progress >= 75 => '#3b82f6',  // blue
                            $project->progress >= 50 => '#f59e0b',  // yellow
                            default => '#ef4444',                   // red
                        };
                    })->toArray(),
                    'borderColor' => $projects->map(function ($project) {
                        return match (true) {
                            $project->progress >= 100 => '#059669',
                            $project->progress >= 75 => '#2563eb',
                            $project->progress >= 50 => '#d97706',
                            default => '#dc2626',
                        };
                    })->toArray(),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $projects->pluck('name')->toArray(),
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
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.parsed.y + "%";
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'callback' => 'function(value) {
                            return value + "%";
                        }',
                    ],
                ],
            ],
        ];
    }
}
