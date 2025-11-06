<?php

namespace App\Settings\Resolvers;

use Illuminate\Support\Facades\Log;

class TenantResolver
{
    public static function tenantId(): ?int
    {
        // Filament tenancy context (preferred)
        try {
            if (function_exists('filament') && filament()->hasTenancy()) {
                $tenant = filament()->getTenant();
                if ($tenant) {
                    Log::info('TenantResolver: Using Filament tenant ID: '.$tenant->id);

                    return $tenant->id;
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error getting Filament tenant ID: '.$e->getMessage());
        }

        // Fallback to authenticated user's current team
        try {
            $user = auth()->user();
            if ($user) {
                // Try to get the current team from user's teams
                $currentTeam = $user->currentTeam();
                if ($currentTeam) {
                    Log::info('TenantResolver: Using user current team ID: '.$currentTeam->id);

                    return $currentTeam->id;
                }

                // Fallback to first team
                $firstTeam = $user->teams()->first();
                if ($firstTeam) {
                    Log::info('TenantResolver: Using user first team ID: '.$firstTeam->id);

                    return $firstTeam->id;
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error getting user team ID: '.$e->getMessage());
        }

        Log::warning('TenantResolver: No tenant ID found');

        return null;
    }
}
