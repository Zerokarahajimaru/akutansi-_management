<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\StokBarang;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function pembelian(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $query = Pembelian::with(['dataBarang', 'pemasok'])
            ->whereBetween('Tgl_Pembelian', [$start_date, $end_date]);

        if ($search) {
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
        }

        $pembelians = $query->orderBy('Tgl_Pembelian', 'desc')->get();

        // Analytics Summary
        $summary = [
            'total_pengeluaran' => $pembelians->sum('Total_Harga'),
            'total_barang_masuk' => $pembelians->sum('Kuantitas'),
            'top_pemasok' => $pembelians->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first() 
                ? (\App\Models\Pemasok::find($pembelians->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first())->Nama_Pemasok ?? '-') 
                : '-'
        ];

        return view('laporan.pembelian', compact('pembelians', 'start_date', 'end_date', 'summary'));
    }

    public function penjualan(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $query = Penjualan::with(['dataBarang', 'pelanggan'])
            ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date]);

        if ($search) {
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
        }

        $penjualans = $query->orderBy('Tanggal_Penjualan', 'desc')->get();

        // Analytics Summary
        $summary = [
            'total_pendapatan' => $penjualans->sum('Total_Harga'),
            'total_transaksi' => $penjualans->count(),
            'best_seller' => $penjualans->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first()
                ? (\App\Models\DataBarang::find($penjualans->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first())->Nama_Barang ?? '-')
                : '-'
        ];

        return view('laporan.penjualan', compact('penjualans', 'start_date', 'end_date', 'summary'));
    }

    public function stok(Request $request)
    {
        $search = $request->input('search');

        $query = StokBarang::with('dataBarang');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('ID_Stok', 'ilike', "%{$search}%")
                  ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                  ->orWhereHas('dataBarang', function($sub) use ($search) {
                      $sub->where('Nama_Barang', 'ilike', "%{$search}%")
                          ->orWhere('Jenis_Barang', 'ilike', "%{$search}%");
                  });
            });
        }

        $stoks = $query->get();

        // Analytics Summary
        $summary = [
            'valuasi_aset' => $stoks->sum(fn($s) => $s->Stok_Akhir * ($s->dataBarang->Harga_Beli ?? 0)),
            'stok_aman' => $stoks->where('Stok_Akhir', '>=', 10)->count(),
            'stok_kritis' => $stoks->where('Stok_Akhir', '<', 10)->count(),
        ];

        return view('laporan.stok', compact('stoks', 'summary'));
    }
}
