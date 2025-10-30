<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Filament::hasTenancy()) {
            $tenant = Filament::getTenant();

            if ($tenant) {
                app()->instance('currentTenantId', $tenant->id);
            }
        }

        return $next($request);
    }
}
