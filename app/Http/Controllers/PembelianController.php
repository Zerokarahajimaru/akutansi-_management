<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Tgl_Pembelian');
        $sortDir = $request->input('sort_dir', 'desc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $pembelians = Pembelian::with(['dataBarang', 'pemasok'])
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $barangs = Cache::rememberForever('active_barangs_list', function() {
            return DataBarang::all();
        });
        $pemasoks = Cache::rememberForever('active_pemasoks_list', function() {
            return Pemasok::all();
        });
        return view('pembelian.create', compact('barangs', 'pemasoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Pemasok' => 'required|string',
            'ID_Barang' => 'required|string',
            'Tgl_Pembelian' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Beli * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            Pembelian::create([
                'ID_Pembelian' => 'PB-' . strtoupper(Str::random(8)),
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Barang' => $request->ID_Barang,
                'user_id' => auth()->id(),
                'Tgl_Pembelian' => $request->Tgl_Pembelian,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Update Stock
            $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $request->Kuantitas);
            } else {
                StokBarang::create([
                    'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
                    'user_id' => auth()->id(),
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
        $request->validate([
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $barang = DataBarang::findOrFail($pembelian->ID_Barang);
        
        $diff = $request->Kuantitas - $pembelian->Kuantitas;
        $total_harga_barang = $barang->Harga_Beli * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            // Update Stock
            $stok = StokBarang::where('ID_Barang', $pembelian->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $diff);
            }

            $pembelian->update([
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Ongkir' => $request->Ongkir,
                'Total_Harga_Barang' => $total_harga_barang,
                'Total_Harga' => $total_harga,
            ]);

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
            // Revert Stock
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
