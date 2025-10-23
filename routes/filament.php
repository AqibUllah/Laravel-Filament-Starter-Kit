<?php

use Illuminate\Support\Facades\Route;

// routes/web.php or routes/filament.php

Route::get('/plans', \App\Filament\Tenant\Pages\Plans::class)->name('plans');
//Route::get('/subscription/success', [\App\Http\Controllers\SubscriptionController::class, 'success'])->name('subscription.success');
//Route::get('/subscription/cancel', [\App\Http\Controllers\SubscriptionController::class, 'cancel'])->name('subscription.cancel');

// Webhook route
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handleWebhook']);
