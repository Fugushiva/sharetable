<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/guest', [GuestController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('guest.index');
