<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\FeatureLimiterService;
use Symfony\Component\HttpFoundation\Response;
class CheckFeatureLimitMiddleware
{
    public function handle(Request $request,string $feature , Closure $next)
    {
        $tenant = $request->user()->tenant;

        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);

        if (!$limiter->{"canCreate{$feature}"}()) {
            return response()->json([
                'message' => "You have reached your {$feature} limit. Please upgrade your plan.",
                'current_usage' => $this->getCurrentUsage($tenant, $feature),
                'limit' => $this->getLimit($limiter, $feature),
            ], 422);
        }

        return $next($request);
    }

    private function getCurrentUsage($tenant, $feature): int
    {
        return match($feature) {
            'User' => $tenant->users()->count(),
            'Task' => $tenant->tasks()->count(),
            'Storage' => $tenant->files()->sum('size'),
            default => 0
        };
    }

    private function getLimit($limiter, $feature): int
    {
        return match($feature) {
            'User' => $limiter->getRemainingUsers(),
            'Task' => $limiter->getRemainingTasks(),
            'Storage' => $limiter->getRemainingStorage(),
            default => 0
        };
    }
}
