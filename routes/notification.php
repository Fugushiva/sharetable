<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notification.index');
Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])
    ->name('notification.read');
