<?php

namespace App\Providers\Filament;

use Alizharb\FilamentThemesManager\FilamentThemesManagerPlugin;
use App\Filament\Tenant\Resources\Tasks\Widgets\TimeTrackingWidget;
use App\Filament\Tenant\Widgets\TaskStatsWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Laravel Filament Saas Starter Kit')
            ->id('admin')
            ->path('admin')
            ->login()
            ->spa()
            ->colors([
                'primary' => Color::Purple,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Billing')
                    ->url(fn (): string => route('filament.plans'))
                    ->icon('heroicon-o-credit-card')
                    ->sort(3),
            ])
            ->viteTheme('resources/css/filament/team/theme.css')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                TimeTrackingWidget::class, // Add this
                TaskStatsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->globallySearchable(true)
                    ->ScopeToTenant(true)
                    ->globalSearchResultsLimit(50),
                FilamentThemesManagerPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->simplePageMaxContentWidth(Width::ExtraLarge);
    }
}
