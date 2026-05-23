<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DataBarang;
use App\Models\Pelanggan;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Tanggal_Penjualan');
        $sortDir = $request->input('sort_dir', 'desc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') {
            $perPage = 9999;
        }

        $penjualans = Penjualan::with(['dataBarang', 'pelanggan'])
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $barangs = DataBarang::all();
        $pelanggans = Pelanggan::all();
        return view('penjualan.create', compact('barangs', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Barang' => 'required',
            'ID_Pelanggan' => 'required',
            'Tanggal_Penjualan' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $stok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();

        if (!$stok || $stok->Stok_Akhir < $request->Kuantitas) {
            return back()->with('error', 'Stok tidak mencukupi. Stok saat ini: ' . ($stok->Stok_Akhir ?? 0));
        }

        $total_harga_barang = $barang->Harga_Jual * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::create([
                'ID_Penjualan' => 'PJ-' . strtoupper(Str::random(8)),
                'ID_Admin' => auth()->user()->ID_Admin ?? 'ADM001',
                'ID_Barang' => $request->ID_Barang,
                'ID_Pelanggan' => $request->ID_Pelanggan,
                'Tanggal_Penjualan' => $request->Tanggal_Penjualan,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Update Stok_Barang
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
        $penjualan = Penjualan::findOrFail($id);

        $request->validate([
            'ID_Barang' => 'required',
            'ID_Pelanggan' => 'required',
            'Tanggal_Penjualan' => 'required|date',
            'Kuantitas' => 'required|integer|min:1',
            'Jenis_Pembayaran' => 'required',
            'Ongkir' => 'required|numeric|min:0',
        ]);

        $barang = DataBarang::findOrFail($request->ID_Barang);
        $total_harga_barang = $barang->Harga_Jual * $request->Kuantitas;
        $total_harga = $total_harga_barang + $request->Ongkir;

        DB::beginTransaction();
        try {
            // Revert old stock adjustment
            $oldStok = StokBarang::where('ID_Barang', $penjualan->ID_Barang)->first();
            if ($oldStok) {
                $oldStok->increment('Stok_Akhir', $penjualan->Kuantitas);
            }

            // Check if new stock is sufficient
            $newStok = StokBarang::where('ID_Barang', $request->ID_Barang)->first();
            if (!$newStok || $newStok->Stok_Akhir < $request->Kuantitas) {
                DB::rollBack();
                return back()->with('error', 'Stok tidak mencukupi untuk pembaruan ini.');
            }

            // Update record
            $penjualan->update([
                'ID_Barang' => $request->ID_Barang,
                'ID_Pelanggan' => $request->ID_Pelanggan,
                'Tanggal_Penjualan' => $request->Tanggal_Penjualan,
                'Kuantitas' => $request->Kuantitas,
                'Jenis_Pembayaran' => $request->Jenis_Pembayaran,
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $request->Ongkir,
                'Total_Harga' => $total_harga,
            ]);

            // Apply new stock adjustment
            $newStok->decrement('Stok_Akhir', $request->Kuantitas);

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
            // Revert stock adjustment
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
