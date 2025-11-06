<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\CouponService;
use CodeWithDennis\SimpleAlert\Components\SimpleAlert;
use Filament\Billing\Providers\Contracts\BillingProvider;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Stripe\BillingPortal\Session;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Customer;
use Stripe\Stripe;

class StripeBillingProvider extends ServiceProvider implements BillingProvider
{
    public function boot() {}

    public function register() {}

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function getRouteAction(): string|\Closure
    {
        return function (): RedirectResponse {
            $team = Filament::getTenant();

            if (! $team || ! $team->subscription || ! $team->subscription->stripe_customer_id) {

                // Redirect to plans page if no subscription
                return redirect()->route('filament.tenant.pages.plans', ['tenant' => $team])
                    ->with(['warning' => 'error here']);
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
            SimpleAlert::make('example')
                ->description('This is the description');

            return redirect()->route('filament.tenant.pages.plans', ['tenant' => filament()->getTenant()])
                ->with('error', 'Unable to access billing portal: '.$e->getMessage());
        }
    }

    // Additional methods for subscription management
    public function createCheckoutSession(Plan $plan, $team, $user, $couponCode = null)
    {
        $customer = $this->getOrCreateStripeCustomer($team, $user);

        $lineItems = [[
            'price' => $plan->stripe_price_id,
            'quantity' => 1,
        ]];

        $discounts = [];

        // Handle coupon if provided
        if ($couponCode) {
            $couponService = app(CouponService::class);
            $validation = $couponService->validateCoupon($couponCode, $team, $plan);

            if ($validation['valid']) {
                $coupon = $validation['coupon'];

                // Create Stripe coupon if it doesn't exist
                $stripeCouponId = $this->createStripeCoupon($coupon);

                if ($stripeCouponId) {
                    $discounts[] = ['coupon' => $stripeCouponId];
                }
            }
        }

        $checkoutSessionData = [
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'subscription',
            'success_url' => route('filament.tenant.pages.subscription-success', ['tenant' => $team]).'?session_id={CHECKOUT_SESSION_ID}&team_id='.$team->id,
            'cancel_url' => route('filament.tenant.pages.plans', ['tenant' => $team]),
            'subscription_data' => [
                'metadata' => [
                    'team_id' => $team->id,
                    'plan_id' => $plan->id,
                    'coupon_code' => $couponCode,
                ],
            ],
        ];

        if (! empty($discounts)) {
            $checkoutSessionData['discounts'] = $discounts;
        }

        $checkoutSession = CheckoutSession::create($checkoutSessionData);

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

    private function createStripeCoupon(Coupon $coupon): ?string
    {
        try {
            // Check if Stripe coupon already exists
            $existingCoupons = \Stripe\Coupon::all(['limit' => 100]);
            foreach ($existingCoupons->data as $stripeCoupon) {
                if ($stripeCoupon->metadata['local_coupon_id'] ?? $coupon->id == null) {
                    return $stripeCoupon->id;
                }
            }

            // Create new Stripe coupon
            $stripeCouponData = [
                'id' => 'local_'.$coupon->id.'_'.time(), // Unique ID for Stripe
                'metadata' => [
                    'local_coupon_id' => $coupon->id,
                    'coupon_code' => $coupon->code,
                ],
            ];

            if ($coupon->type === 'percentage') {
                $stripeCouponData['percent_off'] = $coupon->value;
            } else {
                $stripeCouponData['amount_off'] = $coupon->value * 100; // Convert to cents
                $stripeCouponData['currency'] = 'usd';
            }

            if ($coupon->valid_until) {
                $stripeCouponData['redeem_by'] = $coupon->valid_until->timestamp;
            }

            if ($coupon->usage_limit) {
                $stripeCouponData['max_redemptions'] = $coupon->usage_limit;
            }

            $stripeCoupon = \Stripe\Coupon::create($stripeCouponData);

            return $stripeCoupon->id;
        } catch (\Exception $e) {
            \Log::error('Failed to create Stripe coupon: '.$e->getMessage());

            return null;
        }
    }
}
