<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes - Accessible to both Admin and Pegawai
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Management (View Only / List)
    Route::prefix('data')->group(function () {
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('data.pelanggan');
        Route::get('/pemasok', [PemasokController::class, 'index'])->name('data.pemasok');
        Route::get('/barang', [StockController::class, 'index'])->name('data.barang.list');
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('data.pembelian');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('data.penjualan');
    });

    // Input Forms & Logic
    Route::prefix('input')->group(function () {
        Route::get('/pelanggan', [PelangganController::class, 'create'])->name('input.pelanggan');
        Route::post('/pelanggan', [PelangganController::class, 'store']);
        
        Route::get('/pemasok', [PemasokController::class, 'create'])->name('input.pemasok');
        Route::post('/pemasok', [PemasokController::class, 'store']);
        
        Route::get('/barang', [StockController::class, 'create'])->name('input.barang');
        Route::post('/barang', [StockController::class, 'store']);
        
        Route::get('/pembelian', [PembelianController::class, 'create'])->name('input.pembelian');
        Route::post('/pembelian', [PembelianController::class, 'store']);
        
        Route::get('/penjualan', [PenjualanController::class, 'create'])->name('input.penjualan');
        Route::post('/penjualan', [PenjualanController::class, 'store']);
    });

    // Reports
    Route::prefix('laporan')->group(function () {
        Route::get('/pembelian', function () { return 'Laporan Pembelian'; })->name('laporan.pembelian');
        Route::get('/penjualan', function () { return 'Laporan Penjualan'; })->name('laporan.penjualan');
        Route::get('/stok', function () { return 'Laporan Stok'; })->name('laporan.stok');
    });
});

// Admin Only Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/data/admin', function () { return 'Data Admin'; })->name('data.admin');
    Route::get('/input/admin', function () { return 'Input Admin'; })->name('input.admin');
    Route::post('/input/admin', function () { return 'Store Admin'; });
});
