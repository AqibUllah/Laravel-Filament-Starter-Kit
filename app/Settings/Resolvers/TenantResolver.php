<?php

namespace App\Settings\Resolvers;

use Illuminate\Support\Facades\Log;

class TenantResolver
{
    public static function tenantId(): ?int
    {
        // Filament tenancy context
        try {
            if (function_exists('filament') && filament()->hasTenancy()) {
                return optional(filament()->getTenant())->id;
            }
        } catch (\Throwable $e) {
            // ignore
            Log::error('Error getting tenant ID: ' . $e->getMessage());
        }

        // Fallback to authenticated user's team/tenant
        return optional(auth()->user()?->tenant)->id;
    }
}


