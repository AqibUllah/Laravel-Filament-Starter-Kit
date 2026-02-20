<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Usage;
use App\Services\UsageService;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StorageUsageWidget extends BaseWidget
{
    protected ?string $heading = 'Storage Usage';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [];
        }

        // Get storage limits and usage
        $storageLimit = $currentTeam->featureValue('Storage', '1GB');
        $usageService = app(UsageService::class);
        $usageSummary = $usageService->getUsageSummary($currentTeam);

        // Find storage usage from the metrics
        $storageUsage = $usageSummary['metrics']
            ->where('metric_name', 'Storage')
            ->first();

        $currentUsageGB = $storageUsage ? $storageUsage->total_quantity : 0;

        // Convert storage limit to GB for comparison
        $limitGB = $this->convertToGB($storageLimit);
        $remainingGB = max(0, $limitGB - $currentUsageGB);
        $usagePercentage = $limitGB > 0 ? ($currentUsageGB / $limitGB) * 100 : 0;

        // Determine color based on usage
        $color = match(true) {
            $usagePercentage >= 90 => 'danger',
            $usagePercentage >= 75 => 'warning',
            default => 'success'
        };

        return [
            Stat::make('Storage Usage', number_format($currentUsageGB, 2).' GB')
                ->description('Limit: '.$storageLimit.' | Remaining: '.number_format($remainingGB, 2).' GB ('.number_format(100 - $usagePercentage, 1).'%)')
                ->descriptionIcon('heroicon-m-server')
                ->color($color)
                ->chart([$currentUsageGB])
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-cyan-500/25 bg-gradient-to-br from-cyan-50 to-blue-100 dark:from-cyan-900/20 dark:to-blue-800/20 rounded-xl p-4 hover:border-cyan-300 dark:hover:border-cyan-600',
                ]),

            Stat::make('Storage Plan', $storageLimit)
                ->description('Based on your '.$currentTeam->subscription?->plan?->name.' plan')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info')
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/25 bg-gradient-to-br from-indigo-50 to-purple-100 dark:from-indigo-900/20 dark:to-purple-800/20 rounded-xl p-4 hover:border-indigo-300 dark:hover:border-indigo-600',
                ]),

            Stat::make('Usage Status', $this->getUsageStatus($usagePercentage))
                ->description($this->getUsageDescription($usagePercentage, $remainingGB))
                ->descriptionIcon($this->getUsageIcon($usagePercentage))
                ->color($this->getUsageColor($usagePercentage))
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-emerald-500/25 bg-gradient-to-br from-emerald-50 to-teal-100 dark:from-emerald-900/20 dark:to-teal-800/20 rounded-xl p-4 hover:border-emerald-300 dark:hover:border-emerald-600',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }

    private function convertToGB(string $storage): float
    {
        // Convert storage string to GB
        $storage = strtoupper($storage);

        if (str_contains($storage, 'TB')) {
            return (float) str_replace('TB', '', $storage) * 1024;
        }

        if (str_contains($storage, 'GB')) {
            return (float) str_replace('GB', '', $storage);
        }

        if (str_contains($storage, 'MB')) {
            return (float) str_replace('MB', '', $storage) / 1024;
        }

        // Assume GB if no unit specified
        return (float) $storage;
    }

    private function getUsageStatus(float $percentage): string
    {
        return match(true) {
            $percentage >= 90 => 'Critical',
            $percentage >= 75 => 'Warning',
            $percentage >= 50 => 'Moderate',
            default => 'Healthy'
        };
    }

    private function getUsageDescription(float $percentage, float $remainingGB): string
    {
        if ($percentage >= 90) {
            return 'Only '.number_format($remainingGB, 2).' GB remaining. Consider upgrading!';
        }

        if ($percentage >= 75) {
            return 'Storage getting full. '.number_format($remainingGB, 2).' GB remaining.';
        }

        if ($percentage >= 50) {
            return 'Moderate usage. '.number_format($remainingGB, 2).' GB available.';
        }

        return 'Plenty of space available. '.number_format($remainingGB, 2).' GB free.';
    }

    private function getUsageIcon(float $percentage): string
    {
        return match(true) {
            $percentage >= 90 => 'heroicon-m-exclamation-triangle',
            $percentage >= 75 => 'heroicon-m-exclamation-circle',
            $percentage >= 50 => 'heroicon-m-information-circle',
            default => 'heroicon-m-check-circle'
        };
    }

    private function getUsageColor(float $percentage): string
    {
        return match(true) {
            $percentage >= 90 => 'danger',
            $percentage >= 75 => 'warning',
            $percentage >= 50 => 'info',
            default => 'success'
        };
    }
}
