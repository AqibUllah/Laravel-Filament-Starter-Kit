<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Widgets\CouponStatsWidget;
use App\Filament\Admin\Widgets\UsageStatsWidget;
use App\Services\UsageService;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use RickDBCN\FilamentEmail\FilamentEmail;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use Visualbuilder\EmailTemplates\EmailTemplatesPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->brandName('Admin Panel')
            ->login()
            ->passwordReset()
            ->authPasswordBroker('admins')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                CouponStatsWidget::class,
                UsageStatsWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('admin')
            ->plugins([
                EmailTemplatesPlugin::make(),
                FilamentEmail::make(),
                FilamentLaravelLogPlugin::make()
                ->navigationGroup('Admin')
                ->navigationSort('5')
                    ->navigationIcon('heroicon-o-bug-ant')
                    ->activeNavigationIcon('heroicon-s-bug-ant')
                    ->navigationBadge('+10')
                    ->navigationBadgeColor('danger')
                    ->navigationBadgeTooltip('New logs available')
                    ->navigationSort(1)
                    ->title('Application Logs')
            ]);
    }

    /**
     * Configure usage-based billing for the admin panel
     * This method provides configuration for usage-based billing features
     */
    protected function configureUsageBasedBilling(): array
    {
        return [
            'enabled' => true,
            'metrics' => [
                'api_calls' => [
                    'name' => 'API Calls',
                    'unit' => 'calls',
                    'unit_price' => 0.001,
                    'description' => 'Number of API requests made',
                ],
                'storage_gb' => [
                    'name' => 'Storage Usage',
                    'unit' => 'GB',
                    'unit_price' => 0.10,
                    'description' => 'Storage space used in gigabytes',
                ],
                'active_users' => [
                    'name' => 'Active Users',
                    'unit' => 'users',
                    'unit_price' => 2.00,
                    'description' => 'Number of active users',
                ],
                'database_queries' => [
                    'name' => 'Database Queries',
                    'unit' => 'queries',
                    'unit_price' => 0.0001,
                    'description' => 'Number of database queries executed',
                ],
                'email_sends' => [
                    'name' => 'Email Sends',
                    'unit' => 'emails',
                    'unit_price' => 0.01,
                    'description' => 'Number of emails sent',
                ],
            ],
            'billing_periods' => [
                'monthly' => [
                    'name' => 'Monthly',
                    'days' => 30,
                    'default' => true,
                ],
                'weekly' => [
                    'name' => 'Weekly',
                    'days' => 7,
                ],
                'daily' => [
                    'name' => 'Daily',
                    'days' => 1,
                ],
            ],
            'overage_policies' => [
                'block' => 'Block usage when limit exceeded',
                'charge' => 'Charge overage fees',
                'warn' => 'Send warning notifications',
            ],
            'default_overage_policy' => 'charge',
            'usage_service' => UsageService::class,
        ];
    }
}
