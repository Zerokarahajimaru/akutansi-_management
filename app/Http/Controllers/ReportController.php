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
}
