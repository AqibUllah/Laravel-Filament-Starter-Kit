<?php

namespace App\Filament\Pages;

use App\Models\Subscription;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionSuccess extends Page
{
    protected string $view = 'filament.pages.subscription-success';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CheckBadge;
    protected static bool $shouldRegisterNavigation = false;

    public $sessionId;
    public $teamId;
    public $isProcessing = true;
    public $subscription;

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

        $this->verifySubscription();
    }

    private function verifySubscription()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve the session from Stripe
            $session = Session::retrieve($this->sessionId);

            if ($session->payment_status === 'paid') {
                // Payment was successful, check if we have the subscription in our database
                $this->subscription = Subscription::where('stripe_subscription_id', $session->subscription)
                    ->orWhere(function ($query) use ($session) {
                        $query->where('team_id', $this->teamId)
                              ->where('status', 'active');
                    })
                    ->first();

                if ($this->subscription) {
                    // Subscription found in database (webhook already processed it)
                    Notification::make()
                        ->title('Subscription activated successfully!')
                        ->body('Your team now has access to all plan features.')
                        ->success()
                        ->send();
                } else {
                    // Subscription not in database yet (webhook might be delayed)
                    Notification::make()
                        ->title('Payment successful!')
                        ->body('Your subscription is being activated. This may take a few moments.')
                        ->warning()
                        ->send();

                    // You might want to poll for subscription status or show a loading state
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
                ->title('Error verifying subscription')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->isProcessing = false;
        }
    }

    public function checkSubscriptionStatus()
    {
        $this->verifySubscription();

        if ($this->subscription) {
            $this->dispatch('subscription-activated');
        }
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
