<?php

namespace App\Filament\Tenant\Pages;

use App\Filament\Tenant\Widgets\MainOverviewStatsWidget;
use App\Filament\Tenant\Widgets\QuickSummaryWidget;
use App\Filament\Tenant\Widgets\RecentActivityWidget;
use App\Filament\Tenant\Widgets\TeamPerformanceWidget;
use Filament\Pages\Dashboard as MainDashboard;

class Dashboard extends MainDashboard
{
    public function getWidgets(): array
    {
        return [
            MainOverviewStatsWidget::class,
            RecentActivityWidget::class,
            TeamPerformanceWidget::class,
            QuickSummaryWidget::class,
        ];
    }
}
