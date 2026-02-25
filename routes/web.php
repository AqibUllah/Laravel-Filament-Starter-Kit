<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\StripeWebhookController;
use App\Models\Plan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $plans = Plan::with(['features'])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    return view('welcome', compact('plans'));
})->name('home');

Route::get('/landing', function () {
    return view('landing');
});


// Coupon API routes
Route::middleware(['auth'])->group(function () {
    Route::post('/api/coupons/validate', [CouponController::class, 'validate']);
    Route::get('/api/coupons/available', [CouponController::class, 'available']);
    Route::get('/api/coupons/stats', [CouponController::class, 'stats']);
});

// Webhook routes
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handleWebhook']);
Route::post('/webhooks/stripe/test', [StripeWebhookController::class, 'handleTestWebhook']);
