<?php

namespace App\Filament\Tenant\Resources\Products\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStats extends BaseWidget
{
    public ?object $record = null;

    protected function getStats(): array
    {
        if (!$this->record) {
            return [];
        }

        return [
            Stat::make('Current Price', $this->record->getFormattedCurrentPrice())
                ->description($this->record->sale_price ? 'On sale' : 'Regular price')
                ->descriptionIcon($this->record->sale_price ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-currency-dollar')
                ->color($this->record->sale_price ? 'success' : 'primary'),

            Stat::make('Stock Level', $this->record->quantity)
                ->description($this->record->getStockStatus())
                ->descriptionIcon($this->record->isLowStock() ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($this->record->getStockStatusColor()),

            Stat::make('Total Value', $this->record->getFormattedCurrentPrice() . ' × ' . $this->record->quantity)
                ->description('$' . number_format($this->record->getTotalValue(), 2))
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info'),

            Stat::make('Profit Margin', $this->record->getProfitMargin() ? $this->record->getProfitMargin() . '%' : 'N/A')
                ->description($this->record->cost_price ? 'Based on cost price' : 'No cost price set')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color($this->record->getProfitMargin() && $this->record->getProfitMargin() > 20 ? 'success' : 'warning'),
        ];
    }
}
