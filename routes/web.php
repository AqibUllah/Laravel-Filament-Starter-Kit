<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;

Route::get('/', function () {
    return view('welcome');
});

// Coupon API routes
Route::middleware(['auth'])->group(function () {
    Route::post('/api/coupons/validate', [CouponController::class, 'validate']);
    Route::get('/api/coupons/available', [CouponController::class, 'available']);
    Route::get('/api/coupons/stats', [CouponController::class, 'stats']);
});
