<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/book', [ReservationController::class, 'index'])
    ->name('reservation.index');

Route::get('/book/{id}', [ReservationController::class, 'create'])
    ->name('book.create')
    ->where('annonce.id', '[0-9]+');

Route::post('/book', [ReservationController::class, 'store'])
    ->name('book.store');

Route::post('/check-booking-code', [ReservationController::class, "checkBookingCode"])->name("reservation.code");
