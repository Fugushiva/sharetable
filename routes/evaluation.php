<?php

use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Route;


Route::get('/reservation/{reservation_id}/evaluate', [EvaluationController::class, 'create'])
    ->name('evaluation.create')
    ->where('reservation_id', '[0-9]+');
Route::post('/reservation/{reservation_id}/evaluate', [EvaluationController::class, 'store'])
    ->name('evaluation.store')
    ->where('reservation_id', '[0-9]+');
