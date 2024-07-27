<?php


use App\Http\Controllers\api\AnnonceResourceController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\TransactionResourceController;
use App\Http\Controllers\api\UserCollectionController;
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

//notifications

Route::middleware('auth')->group(function () {
    Route::get('/api/notifications', [NotificationController::class, 'index'])
        ->name('notification.index');
    Route::post('/api/notifications/read', [NotificationController::class, 'markAsRead'])
        ->name('notification.read');
    Route::post('/api/notifications/send', [NotificationController::class, 'sendNotification']);

    Route::get('/api/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])
        ->name('notifications.unread');
});

//User API
Route::get('/api/user', [UserCollectionController::class, 'index'])
    ->name('user-api.index');
Route::get('/api/user/{id}', [UserCollectionController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('user-api.show');
Route::get('/api/user/{id}/reservations', [UserCollectionController::class, 'userReservations'])
    ->where('id', '[0-9]+')
    ->name('user-api.reservations');
Route::get('/api/user/{id}/annonces', [UserCollectionController::class, 'userAnnonces'])
    ->where('id', '[0-9]+')
    ->name('user-api.transactions');




