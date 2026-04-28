<?php

namespace App\Http\Controllers; // Pastikan ini benar!

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        // Data Dummy untuk Card
        $stats = [
            'penjualan_hari_ini' => 'Rp 600.000',
            'pembelian_hari_ini' => 'Rp 150.000',
            'total_stok' => 30
        ];

        // Data Dummy untuk Tabel Aktivitas
        $activities = [
            ['date' => '30-09-2023', 'tipe' => 'Penjualan', 'produk' => 'Produk', 'nominal' => 'Rp 200.000'],
            ['date' => '08-08-2023', 'tipe' => 'Penjualan', 'produk' => 'Pembelian', 'nominal' => 'Rp 100.000'],
            ['date' => '19-08-2023', 'tipe' => 'Penjualan', 'produk' => 'Produk', 'nominal' => 'Rp 50.000'],
            ['date' => '13-08-2023', 'tipe' => 'Penjualan', 'produk' => 'Pembelian', 'nominal' => 'Rp 100.000'],
            ['date' => '19-08-2023', 'tipe' => 'Penjualan', 'produk' => 'Produk', 'nominal' => 'Rp 10.000'],
        ];

        // Data Dummy untuk Stok Kritis
        $critical_stocks = [
            ['name' => 'Item ko 1', 'level' => 5],
            ['name' => 'Item ko 2', 'level' => 5],
            ['name' => 'Item ko 3', 'level' => 5],
            ['name' => 'Item ko 4', 'level' => 5],
        ];

        return view('dashboard', compact('stats', 'activities', 'critical_stocks'));
    }
}