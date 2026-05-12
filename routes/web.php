<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportImportController;
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
        Route::get('/admin', [AdminController::class, 'index'])->name('data.admin');
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('data.pelanggan');
        Route::get('/pemasok', [PemasokController::class, 'index'])->name('data.pemasok');
        Route::get('/barang', [StockController::class, 'index'])->name('data.barang.list');
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('data.pembelian');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('data.penjualan');

        // Edit & Delete Routes
        Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('data.pelanggan.edit');
        Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('data.pelanggan.update');
        Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('data.pelanggan.destroy');

        Route::get('/pemasok/{id}/edit', [PemasokController::class, 'edit'])->name('data.pemasok.edit');
        Route::put('/pemasok/{id}', [PemasokController::class, 'update'])->name('data.pemasok.update');
        Route::delete('/pemasok/{id}', [PemasokController::class, 'destroy'])->name('data.pemasok.destroy');

        Route::get('/barang/{id}/edit', [StockController::class, 'edit'])->name('data.barang.edit');
        Route::put('/barang/{id}', [StockController::class, 'update'])->name('data.barang.update');
        Route::delete('/barang/{id}', [StockController::class, 'destroy'])->name('data.barang.destroy');

        Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('data.pembelian.edit');
        Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('data.pembelian.update');
        Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('data.pembelian.destroy');

        Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit'])->name('data.penjualan.edit');
        Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('data.penjualan.update');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('data.penjualan.destroy');
    });

    // Export/Import Utility Routes
    Route::prefix('util')->group(function () {
        Route::get('/export/{type}', [ExportImportController::class, 'exportCSV'])->name('util.export');
        Route::get('/template/{type}', [ExportImportController::class, 'downloadTemplate'])->name('util.template');
        Route::post('/import/{type}', [ExportImportController::class, 'importCSV'])->name('util.import');
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
        Route::get('/pembelian', [ReportController::class, 'pembelian'])->name('laporan.pembelian');
        Route::get('/penjualan', [ReportController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/stok', [ReportController::class, 'stok'])->name('laporan.stok');
        Route::get('/riwayat', [ReportController::class, 'riwayat'])->name('laporan.riwayat');
    });
});

// Admin Only Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/input/admin', [AdminController::class, 'create'])->name('input.admin');
    Route::post('/input/admin', [AdminController::class, 'store']);
    Route::get('/data/admin/{id}/edit', [AdminController::class, 'edit'])->name('data.admin.edit');
    Route::put('/data/admin/{id}', [AdminController::class, 'update'])->name('data.admin.update');
    Route::delete('/data/admin/{id}', [AdminController::class, 'destroy'])->name('data.admin.destroy');
});
