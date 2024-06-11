<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/guest/{id}', [GuestController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('guest.index')
    ->where('id', '[0-9]+');
