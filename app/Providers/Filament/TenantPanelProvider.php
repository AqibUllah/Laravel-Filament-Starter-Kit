<?php

namespace App\Providers\Filament;

use Alizharb\FilamentThemesManager\FilamentThemesManagerPlugin;
use App\Filament\Tenant\Pages\PlansDashboard;
use App\Filament\Tenant\Pages\ProjectDashboard;
use App\Filament\Tenant\Pages\TaskDashboard;
use App\Filament\Tenant\Pages\Plans;
use App\Filament\Tenant\Pages\Team\Profile as TeamProfile;
use App\Filament\Tenant\Pages\Tenancy\RegisterTeam;
use App\Filament\Tenant\Resources\Tasks\Widgets\TimeTrackingWidget;
use App\Filament\Tenant\Widgets\TaskStatsWidget;
use App\Http\Middleware\RedirectIfUserNotSubscribedMiddleware;
use App\Models\Team;
use App\Providers\StripeBillingProvider;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Middleware\SyncShieldTenant;
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

class TenantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Laravel Filament Saas Starter Kit')
            ->id('tenant')
            ->path('tenant')
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Tenant/Resources'), for: 'App\Filament\Tenant\Resources')
            ->discoverPages(in: app_path('Filament/Tenant/Pages'), for: 'App\Filament\Tenant\Pages')
            ->discoverLivewireComponents(app_path('Filament/Schemas/Components'), for: 'App\Filament\Schemas\Components')
            ->pages([
                Dashboard::class,
                Plans::class,
                ProjectDashboard::class,
                PlansDashboard::class,
                TaskDashboard::class,
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Billing')
                    ->url(fn (): string => route('filament.tenant.tenant.billing',['tenant' => filament()->getTenant()]))
                    ->icon('heroicon-o-credit-card')
                    ->sort(3),
            ])
            ->viteTheme('resources/css/filament/team/theme.css')
            ->discoverWidgets(in: app_path('Filament/Tenant/Widgets'), for: 'App\Filament\Tenant\Widgets')
            ->widgets([
                TimeTrackingWidget::class,
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
                    ->globallySearchable()
                    ->ScopeToTenant()
                    ->navigationSort(5)
                    ->navigationGroup('User Management')
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
