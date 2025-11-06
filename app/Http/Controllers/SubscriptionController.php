<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (! $sessionId) {
            return redirect()->route('plans')->with('error', 'Invalid session.');
        }

        try {
            $session = Session::retrieve($sessionId);

            return view('subscription.success', [
                'session' => $session,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('plans')->with('error', 'Unable to verify subscription.');
        }
    }

    public function cancel()
    {
        return view('subscription.cancel');
    }
}
