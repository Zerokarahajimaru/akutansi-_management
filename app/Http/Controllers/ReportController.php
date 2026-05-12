<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\StokBarang;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function pembelian(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());

        $pembelians = Pembelian::with(['dataBarang', 'pemasok'])
            ->whereBetween('Tgl_Pembelian', [$start_date, $end_date])
            ->orderBy('Tgl_Pembelian', 'desc')
            ->get();

        return view('laporan.pembelian', compact('pembelians', 'start_date', 'end_date'));
    }

    public function penjualan(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan'])
            ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date])
            ->orderBy('Tanggal_Penjualan', 'desc')
            ->get();

        return view('laporan.penjualan', compact('penjualans', 'start_date', 'end_date'));
    }

    public function stok()
    {
        $stoks = StokBarang::with('dataBarang')->get();
        return view('laporan.stok', compact('stoks'));
    }

    public function riwayat()
    {
        $limit = 50;

        $pembelians = Pembelian::with(['dataBarang', 'pemasok'])
            ->orderBy('Tgl_Pembelian', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->Tgl_Pembelian,
                    'tipe' => 'Pembelian',
                    'produk' => $item->dataBarang->Nama_Barang ?? 'Produk Dihapus',
                    'entitas' => $item->pemasok->Nama_Pemasok ?? 'Pemasok Dihapus',
                    'qty' => $item->Kuantitas,
                    'nominal' => $item->Total_Harga,
                    'icon' => 'fa-cart-shopping',
                    'color' => 'indigo'
                ];
            });

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan'])
            ->orderBy('Tanggal_Penjualan', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->Tanggal_Penjualan,
                    'tipe' => 'Penjualan',
                    'produk' => $item->dataBarang->Nama_Barang ?? 'Produk Dihapus',
                    'entitas' => $item->pelanggan->Nama_Pelanggan ?? 'Pelanggan Dihapus',
                    'qty' => $item->Kuantitas,
                    'nominal' => $item->Total_Harga,
                    'icon' => 'fa-hand-holding-dollar',
                    'color' => 'emerald'
                ];
            });

        $activities = $pembelians->concat($penjualans)
            ->sortByDesc('tanggal')
            ->take($limit)
            ->values();

        return view('laporan.riwayat', compact('activities'));
    }
}
