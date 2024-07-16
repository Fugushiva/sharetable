<?php

use App\Http\Controllers\StripeController;
use App\Http\Middleware\CheckReferrer;
use Illuminate\Support\Facades\Route;

Route::get('/stripe', [StripeController::class, 'index'])
    ->name('stripe.index');

Route::post('/checkout', [StripeController::class, 'checkout'])
    ->name('stripe.checkout');

Route::middleware([CheckReferrer::class])->group(function () {
    Route::get('/success', [StripeController::class, 'success'])
        ->name('stripe.success');

    Route::get('/refundAll', [StripeController::class, 'refundAll'])
        ->name('stripe.refundAll');
});

Route::delete('/refund', [StripeController::class, 'refund'])
    ->name('stripe.refund')
    ->where('id', '[0-9]+');


