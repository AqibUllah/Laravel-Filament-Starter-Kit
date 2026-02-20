<?php

namespace App\Http\Middleware;

use App\Services\FeatureLimiterService;
use Closure;
use Illuminate\Http\Request;

class ApiAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $tenant = $user->teams()->first();
        
        if (!$tenant) {
            return response()->json([
                'message' => 'No tenant found for this user.',
            ], 403);
        }

        // Check if the tenant's plan has API access
        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);
        $apiAccess = $limiter->getFeatureLimit('API Access');

        if (!$apiAccess) {
            return response()->json([
                'message' => 'API access is not available on your current plan. Please upgrade to access the API.',
                'feature' => 'API Access',
                'current_plan' => $tenant->currentPlan->name ?? 'Unknown',
            ], 403);
        }

        return $next($request);
    }
}
