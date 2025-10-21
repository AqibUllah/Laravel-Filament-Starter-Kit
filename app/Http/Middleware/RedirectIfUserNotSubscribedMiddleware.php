<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

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

        // Redirect to plans page if not subscribed
        return redirect()->route('filament.plans')->with('error', 'Please subscribe to access this resource.');
    }
}
