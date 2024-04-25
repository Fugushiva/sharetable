<?php

use App\Http\Controllers\AnnonceController;
use Illuminate\Support\Facades\Route;

Route::get('/annonces', [AnnonceController::class, 'index'])
    ->name('annonce.index');
Route::get('/annonce/{id}', [AnnonceController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('annonce.show');
