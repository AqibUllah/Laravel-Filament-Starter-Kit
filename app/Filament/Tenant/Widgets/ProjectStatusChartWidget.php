<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class ProjectStatusChartWidget extends ChartWidget
{
    protected ?string $heading = 'Project Status Distribution';

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

        $projects = Project::where('team_id', $currentTeam->id)
            ->get()
            ->groupBy('status');

        $statusData = [];
        $labels = [];
        $colors = [];

        foreach (ProjectStatusEnum::cases() as $status) {
            $count = $projects->get($status->value, collect())->count();
            $statusData[] = $count;
            $labels[] = ucfirst(str_replace('_', ' ', $status->value));

            // Set colors based on status
            $colors[] = match ($status) {
                ProjectStatusEnum::Planning => 'rgba(59, 130, 246, 0.8)',      // blue
                ProjectStatusEnum::InProgress => 'rgba(245, 158, 11, 0.8)',   // yellow
                ProjectStatusEnum::Completed => 'rgba(34, 197, 94, 0.8)',     // green
                ProjectStatusEnum::OnHold => 'rgba(156, 163, 175, 0.8)',      // gray
                ProjectStatusEnum::Cancelled => 'rgba(239, 68, 68, 0.8)',     // red
                ProjectStatusEnum::Archived => 'rgba(236, 68, 68, 0.8)',     // red
            };
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projects by Status',
                    'data' => $statusData,
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
        return 'pie';
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
