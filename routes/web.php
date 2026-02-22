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

// Marketplace Routes
Route::prefix('marketplace')->name('marketplace.')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');
    Route::get('/product/{product}', [MarketplaceController::class, 'show'])->name('show');
    Route::post('/cart/add/{product}', [MarketplaceController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{product}', [MarketplaceController::class, 'updateCart'])->name('cart.update');
    Route::get('/cart', [MarketplaceController::class, 'getCart'])->name('cart');
    Route::get('/cart/count', [MarketplaceController::class, 'getCartCount'])->name('cart.count');
    Route::delete('/cart/remove/{product}', [MarketplaceController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/empty', [MarketplaceController::class, 'cartEmpty'])->name('cart.empty');
    Route::post('/cart/clear', [MarketplaceController::class, 'clearCart'])->name('cart.clear');
    Route::get('/checkout', [MarketplaceController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [MarketplaceController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/payment/selection', [MarketplaceController::class, 'paymentSelection'])->name('payment.selection');
    Route::post('/payment/initiate/{order}', [MarketplaceController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/success/{order}', [MarketplaceController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel/{order}', [MarketplaceController::class, 'paymentCancel'])->name('payment.cancel');
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
