<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Tgl_Pembelian');
        $sortDir = $request->input('sort_dir', 'desc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $pembelians = Pembelian::with(['dataBarang', 'pemasok', 'user'])
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
        // 1. Strict Validation: Ensure no silent failures here
        $request->validate([
            'ID_Pemasok' => 'required|string|exists:pemasoks,ID_Pemasok',
            'ID_Barang' => 'required|string|exists:data_barangs,ID_Barang',
            'Tgl_Pembelian' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ], [
            'ID_Pemasok.exists' => 'Data pemasok yang dipilih tidak terdaftar.',
            'ID_Barang.exists' => 'Produk yang dipilih tidak ditemukan.',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Beli * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            // 2. ID Generation Audit
            $newId = Pembelian::generateId('PB');

            // 3. Mass Assignment Audit: Map request to DB columns
            $pembelian = Pembelian::create([
                'ID_Pembelian' => $newId,
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Barang' => $request->ID_Barang,
                'user_id' => auth()->id(),
                'Tgl_Pembelian' => $request->Tgl_Pembelian,
                'Kuantitas' => $request->Kuantitas,
                'jenis_pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // 4. Relational Trigger: Update Stock
            $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $request->Kuantitas);
            } else {
                StokBarang::create([
                    'ID_Stok' => 'STK-' . substr($request->ID_Barang, 4),
                    'user_id' => auth()->id(),
                    'ID_Pemasok' => $request->ID_Pemasok,
                    'ID_Barang' => $request->ID_Barang,
                    'Stok_Awal' => 0,
                    'Stok_Akhir' => $request->Kuantitas,
                    'Keterangan' => 'Inisialisasi otomatis via Pembelian ' . $newId,
                ]);
            }

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Transaksi pembelian ' . $newId . ' berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // 5. Audit Fix: Return actual exception message instead of generic text
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())->withInput();
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
            $stok = StokBarang::where('ID_Barang', $pembelian->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $diff);
            }

            $pembelian->update([
                'Kuantitas' => $request->Kuantitas,
                'jenis_pembayaran' => $request->Jenis_Pembayaran,
                'Ongkir' => $request->Ongkir,
                'Total_Harga_Barang' => $total_harga_barang,
                'Total_Harga' => $total_harga,
            ]);

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Data transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        DB::beginTransaction();
        try {
            $stok = StokBarang::where('ID_Barang', $pembelian->ID_Barang)->first();
            if ($stok) {
                $stok->decrement('Stok_Akhir', $pembelian->Kuantitas);
            }

            $pembelian->delete();

            DB::commit();
            return redirect()->route('data.pembelian')->with('success', 'Transaksi berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
