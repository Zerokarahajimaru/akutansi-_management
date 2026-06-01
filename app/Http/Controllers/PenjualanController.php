<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DataBarang;
use App\Models\Pelanggan;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'Tanggal_Penjualan');
        $sortDir = $request->input('sort_dir', 'desc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan', 'user'])
            ->when($search, function($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('ID_Penjualan', 'ilike', "%{$search}%")
                        ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                        ->orWhere('ID_Pelanggan', 'ilike', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $barangs = Cache::rememberForever('active_barangs_list', function() {
            return DataBarang::all();
        });
        $pelanggans = Cache::rememberForever('active_pelanggans_list', function() {
            return Pelanggan::all();
        });
        return view('penjualan.create', compact('barangs', 'pelanggans'));
    }

    public function store(Request $request)
    {
        // 1. Audit: Input name casing must match Blade, but Model maps to lowercase
        $request->validate([
            'ID_Barang' => 'required|string|exists:data_barangs,ID_Barang',
            'ID_Pelanggan' => 'required|string|exists:pelanggans,ID_Pelanggan',
            'Tanggal_Penjualan' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ], [
            'ID_Barang.exists' => 'Produk yang dipilih tidak ditemukan dalam katalog.',
            'ID_Pelanggan.exists' => 'Data pelanggan tidak valid.',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Jual * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        // 2. Audit: Pre-insertion stock check
        $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
        if (!$stok || $stok->Stok_Akhir < $request->Kuantitas) {
            $currentStok = $stok->Stok_Akhir ?? 0;
            return back()->with('error', "Stok tidak mencukupi. Stok saat ini: {$currentStok}")->withInput();
        }

        DB::beginTransaction();
        try {
            $newId = Penjualan::generateId('PJ');

            // 3. Audit: Mass Assignment and ID Assignment
            $penjualan = Penjualan::create([
                'ID_Penjualan' => $newId,
                'user_id' => auth()->id(),
                'ID_Barang' => $request->ID_Barang,
                'ID_Pelanggan' => $request->ID_Pelanggan,
                'Tanggal_Penjualan' => $request->Tanggal_Penjualan,
                'Kuantitas' => $request->Kuantitas,
                'jenis_pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // 4. Audit: Relational sync (Decreasing stock)
            $stok->decrement('Stok_Akhir', $request->Kuantitas);

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Transaksi penjualan ' . $newId . ' berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            // 5. Audit: Critical - Expose DB error message
            return back()->with('error', 'Gagal memproses penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $barangs = DataBarang::all();
        $pelanggans = Pelanggan::all();
        return view('penjualan.edit', compact('penjualan', 'barangs', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $barang = DataBarang::findOrFail($penjualan->ID_Barang);
        
        $diff = $request->Kuantitas - $penjualan->Kuantitas;
        $total_harga_barang = $barang->Harga_Jual * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        $stok = StokBarang::where('ID_Barang', $penjualan->ID_Barang)->first();
        if ($diff > 0 && (!$stok || $stok->Stok_Akhir < $diff)) {
            return back()->with('error', 'Update gagal: Stok tidak mencukupi untuk penambahan kuantitas.')->withInput();
        }

        DB::beginTransaction();
        try {
            if ($stok) {
                $stok->decrement('Stok_Akhir', $diff);
            }

            $penjualan->update([
                'Kuantitas' => $request->Kuantitas,
                'jenis_pembayaran' => $request->Jenis_Pembayaran,
                'Ongkir' => $request->Ongkir,
                'Total_Harga_Barang' => $total_harga_barang,
                'Total_Harga' => $total_harga,
            ]);

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Perubahan transaksi penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        DB::beginTransaction();
        try {
            $stok = StokBarang::where('ID_Barang', $penjualan->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $penjualan->Kuantitas);
            }

            $penjualan->delete();

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Data transaksi telah dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
