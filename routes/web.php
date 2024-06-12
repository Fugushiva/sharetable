<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SetUserLocale;
use Illuminate\Support\Facades\Route;


Route::middleware([SetUserLocale::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');

    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::get('/cities/{id}', [RegisteredUserController::class, 'getCities'])
        ->name('country.cities')
        ->where('id', '[0-9]+');

    Route::post('/change-language',[LanguageController::class, 'changeLanguage'])->name('change.language');

    require __DIR__ . '/auth.php';
    require __DIR__ . '/annonce.php';
    require __DIR__ . '/host.php';
    require __DIR__ . '/guest.php';

});
