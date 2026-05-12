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

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $barangs = DataBarang::all();
        $pemasoks = Pemasok::all();
        return view('pembelian.edit', compact('pembelian', 'barangs', 'pemasoks'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

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
            // Revert old stock adjustment
            $oldStok = StokBarang::where('ID_Barang', $pembelian->ID_Barang)->first();
            if ($oldStok) {
                $oldStok->decrement('Stok_Akhir', $pembelian->Kuantitas);
            }

            // Update record
            $pembelian->update([
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Barang' => $request->ID_Barang,
                'Tgl_Pembelian' => $request->Tgl_Pembelian,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Apply new stock adjustment
            $newStok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
            if ($newStok) {
                $newStok->increment('Stok_Akhir', $request->Kuantitas);
            } else {
                StokBarang::create([
                    'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
                    'ID_Admin' => auth()->user()->ID_Admin ?? 'ADM001',
                    'ID_Pemasok' => $request->ID_Pemasok,
                    'ID_Barang' => $request->ID_Barang,
                    'Stok_Awal' => 0,
                    'Stok_Akhir' => $request->Kuantitas,
                ]);
            }

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Pembelian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui pembelian: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        DB::beginTransaction();
        try {
            // Revert stock adjustment
            $stok = StokBarang::where('ID_Barang', $pembelian->ID_Barang)->first();
            if ($stok) {
                $stok->decrement('Stok_Akhir', $pembelian->Kuantitas);
            }

            $pembelian->delete();

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Pembelian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }
}
