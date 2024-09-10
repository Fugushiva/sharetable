<?php

use App\Http\Controllers\AnnonceController;
use Illuminate\Support\Facades\Route;

Route::get('/annonces', [AnnonceController::class, 'index'])
    ->name('annonce.index');

Route::get('/annonce/{id}', [AnnonceController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('annonce.show');

Route::get('annonce/create', [AnnonceController::class, 'create'])
    ->name('annonce.create');
Route::post('/annonces', [AnnonceController::class, 'store'])
    ->name('annonce.store');

Route::delete('/annonce/{id}', [AnnonceController::class, 'destroy'])
    ->where('id', '[0-9]+')
    ->name('annonce.destroy');

Route::get('/annonce/search-by-country', [AnnonceController::class, 'searchByCountry'])->name('annonce.search_by_country');


Route::get('/annonce/search/{country}', [AnnonceController::class, 'search'])
    ->name('annonce.search')
    ->where('country_id', '[0-9]+');



