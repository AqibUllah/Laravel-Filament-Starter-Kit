<?php

namespace App\Http\Middleware;

use App\Models\Team;
use App\Services\UsageService;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class RecordUsageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Mark request start time to measure response time later
        $request->attributes->set('usage_start_time', microtime(true));

        return $next($request);
    }

    public function terminate(Request $request, $response): void
    {
        try {
            /** @var Team|null $team */
            $team = Filament::getTenant();
            if (! $team || ! $team->subscription) {
                return;
            }

            $endpoint = $request->route()?->getName() ?? $request->path();
            $start = (float) ($request->attributes->get('usage_start_time') ?? microtime(true));
            $responseTimeMs = (int) ((microtime(true) - $start) * 1000);

            // Always record api_calls unless disabled
            if (config('usage.enabled')) {
                \App\Jobs\RecordApiCallUsage::dispatch($team->id, (string) $endpoint, $responseTimeMs);

                // Route-based additional metrics
                $rules = (array) config('usage.routes', []);
                foreach ($rules as $rule) {
                    if (! $this->matchesRule($request, $rule)) {
                        continue;
                    }

                    $metric = (string) ($rule['metric'] ?? 'custom');
                    $quantity = (float) ($rule['quantity'] ?? 1);
                    $unitPrice = (float) ($rule['unit_price'] ?? (config('usage.unit_prices.' . $metric) ?? 0));
                    $metadataBuilder = $rule['metadata'] ?? null;
                    $metadata = is_callable($metadataBuilder) ? (array) $metadataBuilder($request) : [];

                    \App\Jobs\RecordStorageUsage::dispatch($team->id, 0); // placeholder for example; not used unless metric is storage
                    app(UsageService::class)->recordUsage($team, $metric, $quantity, $unitPrice, null, $metadata);
                }
            }
        } catch (\Throwable $e) {
            // Fail silently; never block user requests due to metering
        }
    }

    private function matchesRule(Request $request, array $rule): bool
    {
        $routeName = (string) ($request->route()?->getName() ?? '');
        $method = strtoupper($request->getMethod());
        $path = '/' . ltrim($request->path(), '/');

        // Match by HTTP method
        if (! empty($rule['http'] ?? [])) {
            $http = array_map('strtoupper', (array) $rule['http']);
            if (! in_array($method, $http, true)) {
                return false;
            }
        }

        // Match by route name with wildcard support
        if (! empty($rule['name'])) {
            $pattern = '#^' . str_replace(['*', '.'], ['.*', '\.'], (string) $rule['name']) . '$#';
            if ($routeName === '' || ! preg_match($pattern, $routeName)) {
                return false;
            }
        }

        // Match by path regex
        if (! empty($rule['path_regex'])) {
            if (! preg_match($rule['path_regex'], $path)) {
                return false;
            }
        }

        return true;
    }
}


