<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;
use App\Models\Plan;

Route::get('/', function () {

    $plans = Plan::with(['features'])
            ->where('is_active', true)
             ->orderBy('sort_order')
             ->get();

    return view('welcome',compact('plans'));
});

Route::get('/landing', function () {
    return view('landing');
});

// Coupon API routes
Route::middleware(['auth'])->group(function () {
    Route::post('/api/coupons/validate', [CouponController::class, 'validate']);
    Route::get('/api/coupons/available', [CouponController::class, 'available']);
    Route::get('/api/coupons/stats', [CouponController::class, 'stats']);
});


