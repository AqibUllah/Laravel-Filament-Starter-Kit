<?php

use App\Models\Team;
use App\Services\CustomDomainService;

if (!function_exists('get_current_domain')) {
    function get_current_domain(): ?string
    {
        $request = request();
        $customDomain = $request->get('custom_domain');
        
        if ($customDomain && $customDomain instanceof \App\Models\CustomDomain) {
            return $customDomain->domain;
        }

        // Check if we're in a custom domain context
        if (app('services')->isCustomDomainRequest($request)) {
            $tenant = filament()->getTenant();
            if ($tenant) {
                $service = app(CustomDomainService::class);
                $primaryDomain = $service->getTenantDomain($tenant);
                if ($primaryDomain) {
                    return $primaryDomain->domain;
                }
            }
        }

        // Fallback to default domain
        return parse_url(config('app.url'), PHP_URL_HOST);
    }
}

if (!function_exists('get_current_domain_url')) {
    function get_current_domain_url(): string
    {
        $domain = get_current_domain();
        $protocol = request()->secure() ? 'https://' : 'http://';
        return $protocol . $domain;
    }
}
