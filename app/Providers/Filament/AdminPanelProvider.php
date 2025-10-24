<?php

namespace App\Providers\Filament;

use Alizharb\FilamentThemesManager\FilamentThemesManagerPlugin;
use App\Filament\Pages\Plans;
use App\Filament\Pages\Team\Profile as TeamProfile;
use App\Filament\Resources\Tasks\Widgets\TimeTrackingWidget;
use App\Filament\Widgets\TaskStatsWidget;
use App\Http\Middleware\RedirectIfUserNotSubscribedMiddleware;
use App\Providers\StripeBillingProvider;
use BezhanSalleh\FilamentShield\Middleware\SyncShieldTenant;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Models\Team;
use Filament\Actions\Action;
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
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                Plans::class
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Billing')
                    ->url(fn (): string => route('filament.admin.tenant.billing',['tenant' => filament()->getTenant()]))
                    ->icon('heroicon-o-credit-card')
                    ->sort(3),
            ])
            ->viteTheme('resources/css/filament/team/theme.css')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
                    ->ScopeToTenant(condition: false)
                    ->globalSearchResultsLimit(50),
                FilamentThemesManagerPlugin::make(),
            ])
            ->tenantMiddleware([
                SyncShieldTenant::class,
                RedirectIfUserNotSubscribedMiddleware::class
            ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenantBillingProvider(new StripeBillingProvider())
            ->simplePageMaxContentWidth(Width::ExtraLarge)
            ->searchableTenantMenu()
            ->tenantMenuItems([
                'billing' => fn (Action $action) => $action->label('Manage subscription'),
                // ...
            ])
            ->tenant(Team::class)
            ->tenantProfile(TeamProfile::class)
            ->tenantRegistration(RegisterTeam::class);
    }
}
