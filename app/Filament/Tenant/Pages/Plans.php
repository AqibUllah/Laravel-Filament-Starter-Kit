<?php

namespace App\Filament\Tenant\Pages;

use App\Models\Plan;
use App\Models\Subscription;
use App\Providers\StripeBillingProvider;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithHeaderActions;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Plans extends Page implements HasActions
{
    use InteractsWithHeaderActions;
    use InteractsWithActions;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::CreditCard;
    protected static bool $shouldRegisterNavigation = true;
    protected static string | UnitEnum | null $navigationGroup = 'Billing';

    protected static bool $isScopedToTenant = false;

    // \Filament\Resource\Resource::scopeToTenant(false);

    protected string $view = 'filament.pages.plans';

    public $plans;
    public $currentSubscription;

    public function mount(): void
    {
         $this->plans = Plan::with(['features'])
            ->where('is_active', true)
             ->orderBy('sort_order')
             ->get();

        // Get current team's subscription
        $team = Filament::getTenant();

        if ($team) {
            $this->currentSubscription = Subscription::where('team_id',$team->id)
                ->where('status','active')
                ->first();
        }
    }

    protected function getBillingPortalAction(): Action
    {
          return  Action::make('billing_portal')
                ->label('Manage Billing')
                ->color('gray')
                ->visible(fn () => $this->currentSubscription && $this->currentSubscription->stripe_customer_id)
                ->action(function () {
                    $billingProvider = app(StripeBillingProvider::class);
                    return $billingProvider->getRouteAction();
                });
    }

//    protected function getHeaderActions(): array
//    {
//        return [
//            Action::make('billing_portal')
//                ->label('Manage Billing')
//                ->color('gray')
//                ->visible(fn () => $this->currentSubscription && $this->currentSubscription->stripe_customer_id)
//                ->action(function () {
//                    $billingProvider = app(StripeBillingProvider::class);
//                    return $billingProvider->getRouteAction();
//                })
//        ];
//    }

    public function subscribe($planId): void
    {
        $plan = Plan::findOrFail($planId);
        $team = Filament::getTenant();
        $user = Filament::auth()->user();

        if (!$team) {
            Notification::make()
                ->title('No team selected')
                ->danger()
                ->send();
            return;
        }

        try {
            $billingProvider = app(StripeBillingProvider::class);
            $checkoutSession = $billingProvider->createCheckoutSession($plan, $team, $user);
            // Redirect to Stripe Checkout
            $this->redirect($checkoutSession->url);

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error creating checkout session')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function isCurrentPlan($planId): bool
    {
        return $this->currentSubscription && $this->currentSubscription->plan_id == $planId;
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Only show in navigation if user has a team
        return Filament::getTenant() !== null;
    }
}
