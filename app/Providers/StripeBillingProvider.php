<?php

namespace App\Providers;

use Filament\Billing\Providers\Contracts\BillingProvider;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Customer;
class StripeBillingProvider extends ServiceProvider implements BillingProvider
{

    public function boot()
    {
    }

    public function register()
    {

    }
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function getRouteAction(): string|\Closure
    {
        return function (): RedirectResponse {
            $team = Filament::getTenant();

            if (!$team || !$team->subscription || !$team->subscription->stripe_customer_id) {
                // Redirect to plans page if no subscription
                return redirect()->route('filament.admin.pages.plans');
            }

            // Redirect to Stripe Customer Portal
            return $this->redirectToCustomerPortal($team);
        };
    }

    public function getSubscribedMiddleware(): string
    {
        return \App\Http\Middleware\RedirectIfUserNotSubscribedMiddleware::class;
    }

    private function redirectToCustomerPortal($team): RedirectResponse
    {
        try {
            $session = Session::create([
                'customer' => $team->subscription->stripe_customer_id,
                'return_url' => Filament::getUrl(), // Return to Filament dashboard
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->route('filament.admin.pages.plans',['tenant' => filament()->getTenant()])
                ->with('error', 'Unable to access billing portal: ' . $e->getMessage());
        }
    }

    // Additional methods for subscription management
    public function createCheckoutSession(Plan $plan, $team, $user)
    {
        $customer = $this->getOrCreateStripeCustomer($team, $user);

        $checkoutSession = Session::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('filament.admin.pages.subscription-success',['tenant' => $team]) . '?session_id={CHECKOUT_SESSION_ID}&team_id=' . $team->id,
            'cancel_url' => route('filament.admin.pages.plans', ['tenant' => $team]),
            'subscription_data' => [
                'metadata' => [
                    'team_id' => $team->id,
                    'plan_id' => $plan->id,
                ],
            ],
        ]);

        return $checkoutSession;
    }

    private function getOrCreateStripeCustomer($team, $user)
    {
        if ($team->subscription && $team->subscription->stripe_customer_id) {
            return Customer::retrieve($team->subscription->stripe_customer_id);
        }

        $customer = Customer::create([
            'email' => $user->email,
            'name' => $team->name,
            'metadata' => [
                'team_id' => $team->id,
                'user_id' => $user->id,
            ],
        ]);

        return $customer;
    }
}
