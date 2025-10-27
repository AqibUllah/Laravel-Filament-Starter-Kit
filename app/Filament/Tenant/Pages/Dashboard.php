<?php

namespace App\Filament\Tenant\Pages;

use App\Filament\Tenant\Resources\Tasks\Widgets\TimeTrackingWidget;
use Filament\Pages\Page;
use App\Filament\Tenant\Widgets\PlansStatsWidget;
use App\Filament\Tenant\Widgets\SubscriptionChartWidget;
use App\Filament\Tenant\Widgets\TaskStatsWidget;
use App\Filament\Tenant\Widgets\MainOverviewStatsWidget;
use App\Filament\Tenant\Widgets\RecentActivityWidget;
use App\Filament\Tenant\Widgets\TeamPerformanceWidget;
use App\Filament\Tenant\Widgets\QuickSummaryWidget;
use BackedEnum;
use Filament\Pages\Dashboard as MainDashboard;
use UnitEnum;

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