<?php

namespace App\Providers;

use App\Services\FeatureLimiterService;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FeatureLimiterPolicyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::after(function ($user, string $ability, ?bool $result, array $arguments) {
            // Only act if policy allowed or hasn't decided (null)
            if ($result === false) {
                return false;
            }

            // Apply only on `create` actions
            // if ($ability !== 'create') {
            //     return $result;
            // }

            // Detect model class from arguments
            $model = $arguments[0] ?? null;

            // Some "create" calls may pass the model class name instead of instance
            if (is_string($model) && class_exists($model)) {
                $model = new $model;
            }

            if (! $model instanceof Model) {
                return $result; // not a model-based gate
            }

            // Map model to feature key
            $featureKey = match (class_basename($model)) {
                'User' => 'Users',
                'Project' => 'Projects',
                'Task' => 'Tasks',
                default => null,
            };

            if (! $featureKey) {
                return $result;
            }

            // Call your FeatureLimiterService
            $canCreate = app(FeatureLimiterService::class)
                ->forTenant(Filament::getTenant())
                ->canCreate($featureKey);

            return $canCreate && $result;
        });
    }
}
