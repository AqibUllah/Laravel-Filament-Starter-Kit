<?php

namespace App\Helpers;

use App\Models\Team;
use Filament\Facades\Filament;
use Illuminate\View\View;

class FeatureLimitHelper
{
    /**
     * Check if the team has exceeded a feature limit
     * and return a rendered LimitAlert Blade view if so.
     *
     * @param  string  $featureKey  The key in plan_features table (e.g., 'max_users', 'max_storage')
     * @param  int|null  $usedValue  Current usage (optional). If null, auto-detects for common types.
     * @return string|null
     */
    public static function alertIfExceeded(
        string $featureKey,
        ?int $usedValue = null,
        ?string $upgradeUrl = null
    ): string|null|View {
        $team = Filament::getTenant();
        if (! $team) {
            return null;
        }

        $limit = self::getFeatureLimit($team, $featureKey);
        if ($limit === null) {
            return null;
        }

        // Auto-detect usage if not provided
        if ($usedValue === null) {
            $usedValue = self::detectUsage($team, $featureKey);
        }

        // Only show alert if limit reached
        if ($limit > 0 && $usedValue >= $limit) {
            return view('filament.schemas.components.limit-alert', [
                'type' => 'warning',
                'title' => self::getFeatureTitle($featureKey),
                'message' => "Your plan allows only {$limit} {$featureKey}. You’ve reached your current limit ({$usedValue}/{$limit}). Upgrade your plan to unlock more.",
                'upgradeUrl' => $upgradeUrl ?? route('filament.admin.pages.plans'),
                'actionLabel' => 'Upgrade Plan',
            ]);
        }

        return null;
    }

    /**
     * Get the plan limit value from the team's active plan or feature relation.
     */
    protected static function getFeatureLimit($team, string $key): ?int
    {
        try {
            return (int) optional($team->subscription->plan->features->firstWhere('name', $key))->value;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Detect usage automatically based on feature key name.
     */
    protected static function detectUsage(Team $team, string $key): int
    {
        return match ($key) {
            'Users' => $team->members()->count(),
            //            'max_projects', 'max_tasks' => $team->projects()->count() ?? 0,
            'Storage' => self::getStorageUsage($team),
            default => 0,
        };
    }

    /**
     * Custom usage detection for storage (example only).
     */
    protected static function getStorageUsage($team): int
    {
        // Example: get total file size in MB from team folder
        $path = storage_path("app/teams/{$team->id}/uploads");

        if (! is_dir($path)) {
            return 0;
        }

        $size = 0;
        foreach (glob($path.'/*') as $file) {
            $size += is_file($file) ? filesize($file) : 0;
        }

        // Convert bytes to MB
        return (int) round($size / 1024 / 1024);
    }

    /**
     * Get a human-readable feature name for alerts.
     */
    protected static function getFeatureTitle(string $key): string
    {
        return match ($key) {
            'Users' => 'User Limit Reached',
            'Projects' => 'Project Limit Reached',
            'Tasks' => 'Task Limit Reached',
            'Storage' => 'Storage Limit Reached',
            default => 'Limit Reached',
        };
    }
}
