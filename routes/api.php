<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReturnController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;

// TASK-06 / TASK-07 — order & return API endpoints
// Owner: Nigel
Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
Route::get('/returns/{orderNumber}', [ReturnController::class, 'show']);
Route::get('/returns-instructions', [ReturnController::class, 'instructions']);
Route::get('/stock/{sku}', [StockController::class, 'show']);
