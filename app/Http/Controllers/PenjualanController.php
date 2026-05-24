<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DataBarang;
use App\Models\Pelanggan;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Tanggal_Penjualan');
        $sortDir = $request->input('sort_dir', 'desc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan'])
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
        $request->validate([
            'ID_Barang' => 'required|string',
            'ID_Pelanggan' => 'required|string',
            'Tanggal_Penjualan' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required|string',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Jual * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        // Check stock
        $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
        if (!$stok || $stok->Stok_Akhir < $request->Kuantitas) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::create([
                'ID_Penjualan' => 'PJ-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'ID_Barang' => $request->ID_Barang,
                'ID_Pelanggan' => $request->ID_Pelanggan,
                'Tanggal_Penjualan' => $request->Tanggal_Penjualan,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Update Stock
            $stok->decrement('Stok_Akhir', $request->Kuantitas);

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Penjualan berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat penjualan: ' . $e->getMessage());
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

        // Check stock if increasing quantity
        $stok = StokBarang::where('ID_Barang', $penjualan->ID_Barang)->first();
        if ($diff > 0 && (!$stok || $stok->Stok_Akhir < $diff)) {
            return back()->with('error', 'Stok tidak mencukupi untuk penambahan kuantitas.');
        }

        DB::beginTransaction();
        try {
            // Update Stock
            if ($stok) {
                $stok->decrement('Stok_Akhir', $diff);
            }

            $penjualan->update([
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Ongkir' => $request->Ongkir,
                'Total_Harga_Barang' => $total_harga_barang,
                'Total_Harga' => $total_harga,
            ]);

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui penjualan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        DB::beginTransaction();
        try {
            // Revert Stock
            $stok = StokBarang::where('ID_Barang', $penjualan->ID_Barang)->first();
            if ($stok) {
                $stok->increment('Stok_Akhir', $penjualan->Kuantitas);
            }

            $penjualan->delete();

            DB::commit();
            return redirect()->route('data.penjualan')->with('success', 'Penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }
}
