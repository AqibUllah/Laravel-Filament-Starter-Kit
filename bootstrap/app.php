<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            \Illuminate\Support\Facades\Route::prefix('filament')
                ->name('filament.')
                ->group(base_path('routes/filament.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \Alizharb\FilamentThemesManager\Http\Middleware\ThemePreviewMiddleware::class,
            //            \App\Http\Middleware\RedirectIfUserNotSubscribedMiddleware::class
        ]);

        $middleware->alias([
            'api.access' => \App\Http\Middleware\ApiAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
