<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\StockController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/data-barang', [StockController::class, 'index']);
