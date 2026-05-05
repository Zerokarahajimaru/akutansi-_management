<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with(['dataBarang', 'pemasok'])->orderBy('Tgl_Pembelian', 'desc')->get();
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $barangs = DataBarang::all();
        $pemasoks = Pemasok::all();
        return view('pembelian.create', compact('barangs', 'pemasoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Barang' => 'required',
            'ID_Pemasok' => 'required',
            'Tgl_Pembelian' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Beli * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::create([
                'ID_Pembelian' => 'PB-' . strtoupper(Str::random(8)),
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Barang' => $request->ID_Barang,
                'Tgl_Pembelian' => $request->Tgl_Pembelian,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Update Stok_Barang
            $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $request->Kuantitas);
            } else {
                // If no stock record exists, create one
                StokBarang::create([
                    'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
                    'ID_Admin' => auth()->user()->ID_Admin ?? 'ADM001', // Fallback for testing
                    'ID_Pemasok' => $request->ID_Pemasok,
                    'ID_Barang' => $request->ID_Barang,
                    'Stok_Awal' => 0,
                    'Stok_Akhir' => $request->Kuantitas,
                ]);
            }

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Pembelian berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat pembelian: ' . $e->getMessage());
        }
    }
}
