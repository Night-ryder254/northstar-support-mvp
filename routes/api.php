<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReturnController;
use Illuminate\Support\Facades\Route;

// TASK-06 / TASK-07 — order & return API endpoints
// Owner: Nigel

Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
Route::get('/returns/{orderNumber}', [ReturnController::class, 'show']);
Route::get('/returns-instructions', [ReturnController::class, 'instructions']);
