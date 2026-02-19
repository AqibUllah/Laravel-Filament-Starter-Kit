<?php

namespace App\Http\Middleware;

use App\Models\CustomDomain;
use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HandleCustomDomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Skip for default domain and localhost
        if (in_array($host, [
            config('app.url_host', 'localhost'),
            'localhost',
            '127.0.0.1',
            'test',
        ])) {
            return $next($request);
        }

        // Check if this is a custom domain
        $customDomain = Cache::remember(
            "custom_domain_{$host}",
            now()->addHours(1),
            function () use ($host) {
                return CustomDomain::where('domain', $host)
                    ->where('is_verified', true)
                    ->with('team')
                    ->first();
            }
        );

        if ($customDomain && $customDomain->team) {
            // Set the tenant for this request
            app('filament')->setTenant($customDomain->team);
            
            // Add custom domain to request for later use
            $request->merge([
                'custom_domain' => $customDomain,
                'is_custom_domain' => true,
            ]);
        }

        return $next($request);
    }
}
