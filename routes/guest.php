<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/guest', [GuestController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('guest.index');


Route::middleware('auth')->group(function () {
    Route::get('guest/{id}/evaluate/{reservationId}', [GuestController::class, 'show'])
        ->name('guest.show')
        ->where('id', '[0-9]+')
        ->where('reservationId', '[0-9]+');
    Route::post('guest/evaluate', [GuestController::class, 'storeEvaluation'])->name('guest.evaluation.store');
});
