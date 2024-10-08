<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;


Route::get('/host/create', [HostController::class, 'create'])
    ->name('host.create');
Route::post('/host', [HostController::class, 'store'])
    ->name('host.store');

Route::get('/profile/host', [HostController::class, 'profile'])
    ->name('host.profile');

Route::get('/host/{host}', [HostController::class, 'show'])
    ->name('host.show')
    ->where('id', '[0-9]+');

// stripe connect
Route::get('/host/{host}/stripe-connect', [HostController::class, 'connectStripe'])
    ->name('host.stripe-connect')
    ->where('id', '[0-9]+');


Route::get('/host/verify-stripe', [HostController::class, 'verifyStripeAccount'])
    ->name('host.verify.stripe');
