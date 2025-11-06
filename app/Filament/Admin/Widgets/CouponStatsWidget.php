<?php

namespace App\Filament\Admin\Widgets;

use App\Services\CouponService;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CouponStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $team = Filament::getTenant();

        if (! $team) {
            return [];
        }

        $couponService = app(CouponService::class);
        $stats = $couponService->getCouponUsageStats($team);

        return [
            Stat::make('Coupons Used', $stats['total_coupons_used'])
                ->description('Total coupons used by your team')
                ->descriptionIcon('heroicon-m-tag')
                ->color('success'),

            Stat::make('Total Savings', '$'.number_format($stats['total_savings'], 2))
                ->description('Money saved with coupons')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Available Coupons', Coupon::active()->forTeam($team->id)->count())
                ->description('Coupons available for your team')
                ->descriptionIcon('heroicon-m-gift')
                ->color('warning'),
        ];
    }
}
