<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/conversations', [MessageController::class, 'index'])->name('conversations.index');
    // Route pour afficher le formulaire de création de conversation (GET)
    Route::get('/conversations/create', [MessageController::class, 'createForm'])->name('conversations.create');

    // Route pour créer la conversation (POST)
    Route::post('/conversations', [MessageController::class, 'createConversation'])->name('conversations.store');

    // Route pour afficher une conversation spécifique (GET)
    Route::get('/conversations/{threadId}', [MessageController::class, 'show'])->name('conversations.show');

    // Route pour répondre à une conversation (POST)
    Route::post('/conversations/{threadId}/reply', [MessageController::class, 'replyToConversation'])->name('conversations.reply');

});
