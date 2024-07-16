<?php


use App\Http\Controllers\api\AnnonceResourceController;
use App\Http\Controllers\api\TransactionResourceController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

//Annonce API

//Toutes les annonces
route::get('/api/annonce', [AnnonceResourceController::class, 'index'])
    ->name('annonce-api.index');

//Annonce par ID
route::get('/api/annonce/{id}', [AnnonceResourceController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('annonce-api.show');


//Transaction API
Route::middleware([EnsureUserIsAdmin::class])->group(function () {
    //Toutes les transactions
    Route::get('/api/transaction', [TransactionResourceController::class, 'index'])
        ->name('transaction-api.index');
    //Transaction par ID
    Route::get('/api/transaction/{id}', [TransactionResourceController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('transaction-api.show');
    //Transaction remboursées
    Route::get('/api/transaction/refunded', [TransactionResourceController::class, 'refunded'])
        ->name('transaction-api.cancel');
    //Transaction par utilisateur (clients)
    Route::get('/api/transaction/user/{id}', [TransactionResourceController::class, 'userTransaction'])
        ->where('id', '[0-9]+')
        ->name('transaction-api.user');
    //Transaction par hôte (Bénéficaires)
    Route::get('/api/transaction/host/{id}', [TransactionResourceController::class, 'hostTransaction'])
        ->where('id', '[0-9]+')
        ->name('transaction-api.host');
});





