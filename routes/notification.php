<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

route::get('/notifications', [NotificationController::class, 'show'])->name('notifications.show');
