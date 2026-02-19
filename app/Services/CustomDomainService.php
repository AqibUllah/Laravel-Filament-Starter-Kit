<?php

namespace App\Services;

use App\Models\CustomDomain;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class CustomDomainService
{
    public function getTenantDomain(?Team $team): ?CustomDomain
    {
        if (!$team) {
            return null;
        }

        return Cache::remember(
            "tenant_primary_domain_{$team->id}",
            now()->addHours(1),
            function () use ($team) {
                return $team->customDomains()
                    ->where('is_primary', true)
                    ->where('is_verified', true)
                    ->first();
            }
        );
    }

    public function getTenantDomains(?Team $team): array
    {
        if (!$team) {
            return [];
        }

        return Cache::remember(
            "tenant_domains_{$team->id}",
            now()->addHours(1),
            function () use ($team) {
                return $team->customDomains()
                    ->where('is_verified', true)
                    ->get()
                    ->map(function ($domain) {
                        return [
                            'domain' => $domain->domain,
                            'full_url' => $domain->full_url,
                            'is_primary' => $domain->is_primary,
                            'verified_at' => $domain->verified_at,
                        ];
                    })
                    ->toArray();
            }
        );
    }

    public function isCustomDomainRequest(Request $request): bool
    {
        return $request->has('is_custom_domain') && $request->get('is_custom_domain');
    }

    public function getCustomDomainFromRequest(Request $request): ?CustomDomain
    {
        if (!$this->isCustomDomainRequest($request)) {
            return null;
        }

        return $request->get('custom_domain');
    }

    public function clearTenantDomainCache(Team $team): void
    {
        Cache::forget("tenant_primary_domain_{$team->id}");
        Cache::forget("tenant_domains_{$team->id}");
    }
}
