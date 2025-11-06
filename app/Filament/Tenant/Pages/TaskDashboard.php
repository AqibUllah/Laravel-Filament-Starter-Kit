<?php

namespace App\Filament\Tenant\Pages;

use App\Filament\Tenant\Widgets\TaskPriorityChartWidget;
use App\Filament\Tenant\Widgets\TaskProgressChartWidget;
use App\Filament\Tenant\Widgets\TaskStatsWidget;
use Filament\Pages\Page;

class TaskDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $title = 'Task Analytics';

    protected string $view = 'filament.tenant.pages.dashboards.task-dashboard';

    protected static ?string $navigationLabel = 'Task Dashboard';

    protected static ?int $navigationSort = 3;

    protected static string|\UnitEnum|null $navigationGroup = 'Analytics';

    public function getHeaderWidgets(): array
    {
        return [
            TaskStatsWidget::class,
            TaskProgressChartWidget::class,
            TaskPriorityChartWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
