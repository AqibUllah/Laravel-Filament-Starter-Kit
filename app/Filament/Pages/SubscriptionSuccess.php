<?php

namespace App\Filament\Pages;

use App\Models\Subscription;
use App\Models\Team;
use App\Models\Plan;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;
use Stripe\Checkout\Session;
use Stripe\Subscription as StripeSubscription;
use Stripe\Stripe;

class SubscriptionSuccess extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-check-badge';
     protected string $view = 'filament.pages.subscription-success';
    protected static bool $shouldRegisterNavigation = false;

    // Simple properties that Livewire supports
    public $sessionId;
    public $teamId;
    public $isProcessing = true;
    public $subscriptionId;
    public $planName;
    public $planPrice;
    public $planInterval;
    public $isOnTrial = false;
    public $trialEndsAt;
    public $status;
    public $isPlanSwitch = false;

    public function mount(): void
    {
        $this->sessionId = request()->get('session_id');
        $this->teamId = request()->get('team_id');

        if (!$this->sessionId || !$this->teamId) {
            Notification::make()
                ->title('Invalid session')
                ->danger()
                ->send();
            $this->isProcessing = false;
            return;
        }

        $this->processSubscription();
    }

    private function processSubscription()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve the session from Stripe
            $session = Session::retrieve($this->sessionId);

            if ($session->payment_status === 'paid' || $session->payment_status === 'unpaid') {
                // Get the subscription details from Stripe
                $stripeSubscription = StripeSubscription::retrieve($session->subscription);

                // For local development, create/update subscription directly
                if (app()->environment('local')) {
                    $this->handleLocalSubscription($stripeSubscription);
                } else {
                    // For production, just check if subscription exists
                    $this->checkExistingSubscription($session->subscription);
                }
            } else {
                Notification::make()
                    ->title('Payment not completed')
                    ->body('Your payment is still processing. Please wait a moment.')
                    ->warning()
                    ->send();
            }

            $this->isProcessing = false;

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error processing subscription')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->isProcessing = false;
        }
    }

    /**
     * Handle subscription creation/update for local development
     */
    private function handleLocalSubscription(StripeSubscription $stripeSubscription)
    {
        $team = Team::find($this->teamId);

        if (!$team) {
            throw new \Exception('Team not found');
        }

        // Find plan by Stripe price ID
        $priceId = $stripeSubscription->items->data[0]->price->id;
        $plan = Plan::where('stripe_price_id', $priceId)->first();

        if (!$plan) {
            throw new \Exception('Plan not found for price: ' . $priceId);
        }

        // Check if team already has an active subscription
        $existingSubscription = Subscription::where('team_id', $team->id)
            ->where('status', 'active')
            ->first();

        if ($existingSubscription) {
            // This is a plan switch - cancel old subscription and create new one
            $this->isPlanSwitch = true;

            // Cancel the old subscription in database (not in Stripe)
            $existingSubscription->update([
                'status' => 'canceled',
                'ends_at' => now(),
                'canceled_at' => now(),
            ]);
        }


        // Create or update subscription in database
        $subscription = Subscription::updateOrCreate(
            [
                'stripe_subscription_id' => $stripeSubscription->id,
                'team_id' => $team->id // Ensure we don't create duplicates for same team
            ],
            [
                'team_id' => $team->id,
                'plan_id' => $plan->id,
                'stripe_customer_id' => $stripeSubscription->customer,
                'status' => $stripeSubscription->status,
                'trial_ends_at' => $stripeSubscription->trial_end ?
                    \Carbon\Carbon::createFromTimestamp($stripeSubscription->trial_end) : null,
                'ends_at' => $stripeSubscription->cancel_at ?
                    \Carbon\Carbon::createFromTimestamp($stripeSubscription->cancel_at) : null,
                'canceled_at' => $stripeSubscription->canceled_at ?
                    \Carbon\Carbon::createFromTimestamp($stripeSubscription->canceled_at) : null,
            ]
        );

        // Apply plan features to team
        $this->applyPlanFeaturesToTeam($team, $plan);

        // Set simple properties for the view
        $this->subscriptionId = $subscription->id;
        $this->planName = $plan->name;
        $this->planPrice = $plan->price;
        $this->planInterval = $plan->interval;
        $this->isOnTrial = $subscription->isOnTrial();
        $this->trialEndsAt = $subscription->trial_ends_at?->format('M j, Y');
        $this->status = $subscription->status;

        \Log::info('Local: Subscription created and features applied', [
            'team_id' => $team->id,
            'plan_id' => $plan->id,
            'subscription_id' => $subscription->id,
            'is_plan_switch' => $this->isPlanSwitch,
            'old_subscription_id' => $existingSubscription?->id
        ]);

        if ($this->isPlanSwitch) {
            Notification::make()
                ->title('Plan upgraded successfully!')
                ->body("You've been upgraded from {$existingSubscription->plan->name} to {$plan->name}")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Subscription activated successfully!')
                ->body('Your team now has access to all plan features.')
                ->success()
                ->send();
        }
    }

    /**
     * Check for existing subscription (for production)
     */
    private function checkExistingSubscription($stripeSubscriptionId)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscriptionId)
            ->orWhere(function ($query) {
                $query->where('team_id', $this->teamId)
                    ->where('status', 'active');
            })
            ->first();

        if ($subscription) {
            $this->subscriptionId = $subscription->id;
            $this->planName = $subscription->plan->name;
            $this->planPrice = $subscription->plan->price;
            $this->planInterval = $subscription->plan->interval;
            $this->isOnTrial = $subscription->isOnTrial();
            $this->trialEndsAt = $subscription->trial_ends_at?->format('M j, Y');
            $this->status = $subscription->status;

            // Check if this was a plan switch
            $oldSubscription = Subscription::where('team_id', $this->teamId)
                ->where('status', 'canceled')
                ->where('id', '!=', $subscription->id)
                ->latest()
                ->first();

            $this->isPlanSwitch = !is_null($oldSubscription);

            if ($this->isPlanSwitch) {
                Notification::make()
                    ->title('Plan upgraded successfully!')
                    ->body("You've been upgraded to {$subscription->plan->name}")
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Subscription activated successfully!')
                    ->body('Your team now has access to all plan features.')
                    ->success()
                    ->send();
            }
        } else {
            Notification::make()
                ->title('Payment successful!')
                ->body('Your subscription is being activated. This may take a few moments.')
                ->warning()
                ->send();
        }
    }

    /**
     * Apply plan features to team (update roles/permissions)
     */
    private function applyPlanFeaturesToTeam(Team $team, Plan $plan)
    {
        // Get plan features
        $features = $plan->features()->pluck('value', 'name');

        // Update team limits based on plan features
        $team->update([
            'max_users' => $features['Users'] ?? 1,
            'max_projects' => $features['Projects'] ?? 1,
            'max_storage_mb' => $this->convertStorageToMB($features['Storage'] ?? '0'),
            'current_plan_id' => $plan->id, // Add this field to teams table
        ]);

        // Update team permissions/roles
        $this->updateTeamPermissions($team, $features);

        \Log::info('Plan features applied to team', [
            'team_id' => $team->id,
            'plan_id' => $plan->id,
        ]);
    }

    private function convertStorageToMB($storage)
    {
        if ($storage === 'Unlimited') {
            return -1; // Unlimited
        }

        $storage = strtolower($storage);
        if (strpos($storage, 'gb') !== false) {
            return (int) $storage * 1024;
        } elseif (strpos($storage, 'mb') !== false) {
            return (int) $storage;
        } else {
            return (int) $storage;
        }
    }

    private function updateTeamPermissions(Team $team, $features)
    {
        // Implement your specific role/permission logic here
        foreach ($team->members as $member) {
            // Your role assignment logic
            // Example:
            if (($features['Users'] ?? 0) > 10) {
                // $member->assignRole('premium_user');
            }

            if ($features['API Access'] === 'true') {
                // $member->givePermissionTo('api_access');
            }

            if ($features['Advanced Analytics'] === 'true') {
                // $member->givePermissionTo('advance_analytics');
            }
        }

        \Log::info('Team permissions updated', [
            'team_id' => $team->id,
            'users_count' => $team->members->count()
        ]);
    }

    public function checkSubscriptionStatus()
    {
        $this->isProcessing = true;
        $this->processSubscription();

        if ($this->subscriptionId) {
            $this->dispatch('subscription-activated');
        }
    }

    public function goToDashboard()
    {
        return redirect()->to(filament()->getUrl());
    }

    // Helper method to get subscription for view (if needed)
    public function getSubscriptionProperty()
    {
        if ($this->subscriptionId) {
            return Subscription::find($this->subscriptionId);
        }
        return null;
    }

    // Helper method to get plan features for view
    public function getPlanFeaturesProperty()
    {
        if ($this->subscriptionId) {
            $subscription = Subscription::find($this->subscriptionId);
            return $subscription->plan->features ?? collect();
        }
        return collect();
    }

    public function getTitle(): string
    {
        return 'Subscription Status';
    }

    public static function getRoutes(): \Closure
    {
        return function () {
            Route::get('/subscription/success', static::class)
                ->middleware(['web', 'auth'])
                ->name('subscription.success');
        };
    }
}
