<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RedirectIfUserNotSubscribedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('filament.admin.auth.login');
        }

        $team = Filament::getTenant();
        setPermissionsTeamId($team->id);
        Artisan::call('cache:clear');

        // Allow access if team has active subscription or is on trial
        if ($team->hasActiveSubscription() || $team->isOnTrial()) {

            return $next($request);
        }

        // 🚫 Skip plans or checkout routes to prevent loops
        if (
            $request->routeIs('filament.tenant.pages.plans') ||
            $request->routeIs('filament.tenant.pages.subscription-success')
        ) {
            return $next($request);
        }

        Notification::make('Error')
            ->title('Error')
            ->danger()
            ->body('Please subscribe to access the features.')->send();

        // Redirect to plans page if not subscribed
        return redirect()->route('filament.tenant.pages.plans', ['tenant' => $team])->with('error', 'Please subscribe to access the features.');
    }
}
