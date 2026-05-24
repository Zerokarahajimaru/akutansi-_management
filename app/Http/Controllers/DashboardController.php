<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Penjualan Hari Ini
        $penjualan_hari_ini = Penjualan::whereDate('Tanggal_Penjualan', $today)->sum('Total_Harga');
        
        // 2. Pembelian Hari Ini
        $pembelian_hari_ini = Pembelian::whereDate('Tgl_Pembelian', $today)->sum('Total_Harga');

        // 3. Total Stok Akhir
        $total_stok = StokBarang::sum('Stok_Akhir');

        $stats = [
            'penjualan_hari_ini' => 'Rp ' . number_format($penjualan_hari_ini, 0, ',', '.'),
            'pembelian_hari_ini' => 'Rp ' . number_format($pembelian_hari_ini, 0, ',', '.'),
            'total_stok' => number_format($total_stok, 0, ',', '.')
        ];

        // 4. Aktivitas Terbaru (Gabungan Penjualan & Pembelian)
        $recent_penjualan = Penjualan::with('dataBarang')
            ->orderBy('Tanggal_Penjualan', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->Tanggal_Penjualan)->format('d-m-Y'),
                    'tipe' => 'Penjualan',
                    'produk' => $item->dataBarang->Nama_Barang ?? 'Unknown',
                    'nominal' => 'Rp ' . number_format($item->Total_Harga, 0, ',', '.')
                ];
            });

        $recent_pembelian = Pembelian::with('dataBarang')
            ->orderBy('Tgl_Pembelian', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->Tgl_Pembelian)->format('d-m-Y'),
                    'tipe' => 'Pembelian',
                    'produk' => $item->dataBarang->Nama_Barang ?? 'Unknown',
                    'nominal' => 'Rp ' . number_format($item->Total_Harga, 0, ',', '.')
                ];
            });

        $activities = $recent_penjualan->concat($recent_pembelian)
            ->sortByDesc(function ($item) {
                return Carbon::createFromFormat('d-m-Y', $item['date'])->timestamp;
            })
            ->take(5)
            ->values();

        // 5. Stok Kritis (Stok Akhir < 10)
        $critical_stocks = StokBarang::with('dataBarang')
            ->where('Stok_Akhir', '<', 10)
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->dataBarang->Nama_Barang ?? 'Unknown',
                    'level' => $item->Stok_Akhir
                ];
            });

        return view('dashboard', compact('stats', 'activities', 'critical_stocks'));
    }
}