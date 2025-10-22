<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Team;
use App\Models\Plan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\HttpFoundation\Response;
class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], Response::HTTP_BAD_REQUEST);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], Response::HTTP_BAD_REQUEST);
        }

        Log::info('Stripe Webhook Received', ['type' => $event->type]);

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            case 'invoice.payment_succeeded':
                $this->handleInvoicePaymentSucceeded($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->handleInvoicePaymentFailed($event->data->object);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function handleCheckoutSessionCompleted(StripeSession $session)
    {
        Log::info('Checkout session completed', ['session_id' => $session->id]);

        // Get subscription from session
        $subscription = StripeSubscription::retrieve($session->subscription);

        $this->handleSubscriptionUpdated($subscription);
    }

    private function handleSubscriptionUpdated(StripeSubscription $stripeSubscription)
    {
        $teamId = $stripeSubscription->metadata->team_id ?? null;

        if (!$teamId) {
            Log::error('Webhook: No team_id in subscription metadata', [
                'subscription_id' => $stripeSubscription->id
            ]);
            return;
        }

        $team = Team::find($teamId);

        if (!$team) {
            Log::error('Webhook: Team not found', ['team_id' => $teamId]);
            return;
        }

        // Find plan by Stripe price ID
        $priceId = $stripeSubscription->items->data[0]->price->id;
        $plan = Plan::where('stripe_price_id', $priceId)->first();

        if (!$plan) {
            Log::error('Webhook: Plan not found for price_id', [
                'price_id' => $priceId
            ]);
            return;
        }

        // Create or update subscription
        $subscription = Subscription::updateOrCreate(
            ['stripe_subscription_id' => $stripeSubscription->id],
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

        // Apply plan features to team (role/permission updates)
        $this->applyPlanFeaturesToTeam($team, $plan);

        Log::info('Webhook: Subscription updated and features applied', [
            'team_id' => $team->id,
            'plan_id' => $plan->id,
            'subscription_id' => $subscription->id,
            'status' => $stripeSubscription->status
        ]);
    }

    private function handleSubscriptionDeleted(StripeSubscription $stripeSubscription)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscription->id)->first();

        if ($subscription) {
            $team = $subscription->team;

            // Downgrade to free plan or mark as canceled
            $freePlan = Plan::where('price', 0)->first();

            if ($freePlan) {
                $subscription->update([
                    'plan_id' => $freePlan->id,
                    'status' => 'canceled',
                    'ends_at' => now(),
                    'canceled_at' => now(),
                ]);

                $this->applyPlanFeaturesToTeam($team, $freePlan);
            } else {
                $subscription->update([
                    'status' => 'canceled',
                    'ends_at' => now(),
                    'canceled_at' => now(),
                ]);
            }

            Log::info('Webhook: Subscription canceled', [
                'team_id' => $team->id,
                'subscription_id' => $subscription->id
            ]);
        }
    }

    private function handleInvoicePaymentSucceeded($invoice)
    {
        // Handle successful payment
        Log::info('Invoice payment succeeded', ['invoice_id' => $invoice->id]);
    }

    private function handleInvoicePaymentFailed($invoice)
    {
        // Handle failed payment
        $subscription = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();

        if ($subscription) {
            $subscription->update(['status' => 'past_due']);

            Log::warning('Invoice payment failed', [
                'team_id' => $subscription->team_id,
                'subscription_id' => $subscription->id
            ]);
        }
    }

    /**
     * Apply plan features to team (update roles/permissions)
     */
    private function applyPlanFeaturesToTeam(Team $team, Plan $plan)
    {
        // Get plan features
        $features = $plan->features()->pluck(column: 'value', 'name');

        // Update team limits based on plan features
        $team->update([
            'max_users' => $features['Users'] ?? 1,
            'max_projects' => $features['Projects'] ?? 1,
            'max_storage_mb' => $this->convertStorageToMB($features['Storage'] ?? '0'),
            // Add other limits based on your features
        ]);

        // Update team members' roles/permissions if needed
        $this->updateTeamPermissions($team, $features);

        Log::info('Plan features applied to team', [
            'team_id' => $team->id,
            'plan_id' => $plan->id,
            'features' => $features->toArray()
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
        // Implement your role/permission logic here
        // This depends on your permission system (Spatie, custom, etc.)

        // Example with Spatie permissions:

        $members = $team->members;

        foreach ($members as $member) {
            if ($features['Advanced Analytics'] === 'true') {
                $member->givePermissionTo('view_advanced_analytics');
            } else {
                $member->revokePermissionTo('view_advanced_analytics');
            }

            // Add other permission updates based on features
        }


        // If you're using Filament's role system:
        $this->updateFilamentRoles($team, $features);
    }

    private function updateFilamentRoles(Team $team, $features)
    {
        // Update team role based on plan features
        // This is just an example - adjust based on your role system

        $roleName = 'member';

        if (($features['Users'] ?? 0) > 10) {
            $roleName = 'premium_member';
        }

        if (($features['Users'] ?? 0) > 50) {
            $roleName = 'business_member';
        }

        // Update team members' roles
        foreach ($team->users as $user) {
            // Your role assignment logic here
            $user->assignRole($roleName);
        }
    }
}
