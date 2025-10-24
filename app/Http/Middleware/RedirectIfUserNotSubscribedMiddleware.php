<?php

namespace App\Http\Middleware;

use Closure;
use CodeWithDennis\SimpleAlert\Components\SimpleAlert;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedirectIfUserNotSubscribedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('filament.admin.auth.login');
        }

        $team = Filament::getTenant();

        // Allow access if team has active subscription or is on trial
        if ($team->hasActiveSubscription() || $team->isOnTrial()) {

            return $next($request);
        }

        // 🚫 Skip plans or checkout routes to prevent loops
        if (
            $request->routeIs('filament.admin.pages.plans') ||
            $request->routeIs('filament.admin.pages.subscription-success')
        ) {
            return $next($request);
        }

        Notification::make('Error')
        ->title('Error')
        ->danger()
        ->body('Please subscribe to access the features.')->send();

        // Redirect to plans page if not subscribed
        return redirect()->route('filament.admin.pages.plans',['tenant' => filament()->getTenant()])->with('error', 'Please subscribe to access the features.');
    }
}
