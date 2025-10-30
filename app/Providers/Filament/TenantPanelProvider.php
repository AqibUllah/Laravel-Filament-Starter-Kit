<?php

namespace App\Providers\Filament;

use Alizharb\FilamentThemesManager\FilamentThemesManagerPlugin;
use App\Filament\Tenant\Pages\Dashboard;
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
use App\Settings\TenantGeneralSettings;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Middleware\SyncShieldTenant;
use Filament\Actions\Action;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\RecordUsageMiddleware;
use App\Http\Middleware\SetCurrentTenant;

class TenantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $settings = null;
        if (Schema::hasTable('settings')) {
            try {
                $settings = app(TenantGeneralSettings::class);
            } catch (\Throwable $e) {
                // The settings table might not be ready or filled, fallback to default values
                $settings = (object)[];
            }
        } else {
            // Table does not exist: fallback to default values for first-time setup
            $settings = (object)[];
        }
        return $panel
            ->default()
            ->brandName($settings->company_name ?? 'Team')
            ->brandLogo(isset($settings->company_logo_path) && $settings->company_logo_path ? asset($settings->company_logo_path) : null)
            ->id('tenant')
            ->path('tenant')
            ->login()
            ->profile()
            ->registration()
            ->colors([
                'primary' => $settings->primary_color ?? Color::Amber,
            ])
            ->multiFactorAuthentication([
                AppAuthentication::make()
                ->recoverable()
                ->recoveryCodeCount(10)
                ->brandName($settings->company_name ?? 'Team'),
            ],isRequired: $settings->require_2fa ?? false)
            // Sidebar behavior from tenant settings
            ->sidebarCollapsibleOnDesktop((bool)($settings->sidebar_collapsed_default ?? false))
            ->discoverResources(in: app_path('Filament/Tenant/Resources'), for: 'App\Filament\Tenant\Resources')
            ->discoverPages(in: app_path('Filament/Tenant/Pages'), for: 'App\Filament\Tenant\Pages')
            ->discoverLivewireComponents(app_path('Filament/Schemas/Components'), for: 'App\Filament\Schemas\Components')
            // Apply locale/timezone preferences for the tenant at boot time
            ->bootUsing(function () use ($settings): void {
                if (! empty($settings->locale)) {
                    app()->setLocale($settings->locale);
                    Carbon::setLocale($settings->locale);
                }

                if (! empty($settings->timezone)) {
                    Config::set(['app.timezone' => $settings->timezone]);
                    date_default_timezone_set($settings->timezone);
                }

                // disk
                if (! empty($settings->storage_upload_disk)) {
                    Config::set(['filament.default_filesystem_disk' => $settings->storage_upload_disk]);
                }
            })
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
                RedirectIfUserNotSubscribedMiddleware::class,
                SetCurrentTenant::class
            ], isPersistent: true)
            ->middleware([
                // Existing middleware are above; add usage recording as a global middleware for tenant panel
                RecordUsageMiddleware::class,
            ])
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
