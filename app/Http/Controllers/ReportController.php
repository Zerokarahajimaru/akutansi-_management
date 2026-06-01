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
        $start_date = $request->input('start_date', Carbon::now()->subYear()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $pembelians = Pembelian::with(['dataBarang', 'pemasok'])
            ->whereBetween('Tgl_Pembelian', [$start_date, $end_date])
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('ID_Pembelian', 'ilike', "%{$search}%")
                      ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                      ->orWhere('ID_Pemasok', 'ilike', "%{$search}%")
                      ->orWhereHas('dataBarang', function($sub) use ($search) {
                          $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                      })
                      ->orWhereHas('pemasok', function($sub) use ($search) {
                          $sub->where('Nama_Pemasok', 'ilike', "%{$search}%");
                      });
                });
            })
            ->orderBy('Tgl_Pembelian', 'desc')
            ->get();

        return view('laporan.pembelian', compact('pembelians', 'start_date', 'end_date'));
    }

    public function penjualan(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->subYear()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan'])
            ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date])
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('ID_Penjualan', 'ilike', "%{$search}%")
                      ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                      ->orWhere('ID_Pelanggan', 'ilike', "%{$search}%")
                      ->orWhereHas('dataBarang', function($sub) use ($search) {
                          $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                      })
                      ->orWhereHas('pelanggan', function($sub) use ($search) {
                          $sub->where('Nama_Pelanggan', 'ilike', "%{$search}%");
                      });
                });
            })
            ->orderBy('Tanggal_Penjualan', 'desc')
            ->get();

        return view('laporan.penjualan', compact('penjualans', 'start_date', 'end_date'));
    }

    public function stok(Request $request)
    {
        $search = $request->input('search');

        $stoks = StokBarang::with('dataBarang')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('ID_Stok', 'ilike', "%{$search}%")
                      ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                      ->orWhereHas('dataBarang', function($sub) use ($search) {
                          $sub->where('Nama_Barang', 'ilike', "%{$search}%")
                              ->orWhere('Jenis_Barang', 'ilike', "%{$search}%");
                      });
                });
            })
            ->get();

        return view('laporan.stok', compact('stoks'));
    }
}
