<?php

namespace App\Http\Controllers;

use App\Services\Payments\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __construct(
        private StripePaymentService $stripeService
    ) {}

    public function handleWebhook(Request $request): Response
    {
        $payload = $request->getContent();
        $signature = $request->header('stripe-signature');

        if (!$signature) {
            Log::error('Stripe webhook missing signature');
            return response('Webhook signature missing', 400);
        }

        if (!$this->stripeService->verifyWebhookSignature(json_decode($payload, true), $signature)) {
            Log::error('Stripe webhook signature verification failed');
            return response('Webhook signature verification failed', 403);
        }

        $event = json_decode($payload, true);
        
        Log::info('Stripe webhook received', [
            'event_type' => $event['type'] ?? 'unknown',
            'event_id' => $event['id'] ?? 'unknown',
        ]);

        try {
            $this->stripeService->handleWebhook($event);
            
            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            Log::error('Error processing Stripe webhook', [
                'event_type' => $event['type'] ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response('Webhook processing failed', 500);
        }
    }

    public function handleTestWebhook(Request $request): Response
    {
        Log::info('Stripe test webhook received', [
            'payload' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        return response('Test webhook received', 200);
    }
}
