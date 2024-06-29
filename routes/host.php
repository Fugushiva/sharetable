<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;


Route::get('/host/create', [HostController::class, 'create'])
    ->name('host.create');
Route::post('/host', [HostController::class, 'store'])
    ->name('host.store');

Route::get('/profile/host', [HostController::class, 'profile'])
    ->name('host.profile');
