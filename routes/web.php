<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\StockController;

Route::get('/', [dashboardController::class, 'index']);
Route::get('/stock', [StockController::class, 'index']);
