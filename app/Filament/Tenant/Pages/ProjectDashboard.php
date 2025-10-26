<?php

namespace App\Filament\Tenant\Pages;

use App\Filament\Tenant\Widgets\ProjectProgressChartWidget;
use App\Filament\Tenant\Widgets\ProjectStatsWidget;
use App\Filament\Tenant\Widgets\ProjectStatusChartWidget;
use Filament\Pages\Page;

class ProjectDashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $title = 'Project Analytics';

    protected string $view = 'filament.tenant.pages.dashboards.project-dashboard';

    protected static ?string $navigationLabel = 'Project Dashboard';

    protected static ?int $navigationSort = 1;

    protected static string | \UnitEnum | null $navigationGroup = 'Analytics';

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectStatsWidget::class,
            ProjectProgressChartWidget::class,
            ProjectStatusChartWidget::class,
        ];
    }


    public function getColumns(): int | array
    {
        return 2;
    }
}
