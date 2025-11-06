<?php

namespace App\Filament\Tenant\Pages;

use App\Filament\Tenant\Widgets\PlansStatsWidget;
use App\Filament\Tenant\Widgets\SubscriptionChartWidget;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class PlansDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected string $view = 'filament.tenant.pages.dashboards.plans-dashboard';

    protected static ?string $title = 'Plans & Billing';

    protected static ?string $slug = 'plans-dashboard';

    protected static ?string $navigationLabel = 'Plans Dashboard';

    protected static ?int $navigationSort = 2;

    protected static string|UnitEnum|null $navigationGroup = 'Analytics';

    public function getHeaderWidgets(): array
    {
        return [
            PlansStatsWidget::class,
            SubscriptionChartWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
