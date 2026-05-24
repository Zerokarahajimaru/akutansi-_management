<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\StokBarang;
use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Nama_Barang');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $stocks = DataBarang::with('stokBarangs')
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('stock', compact('stocks'));
    }

    public function create()
    {
        $pemasoks = Cache::rememberForever('active_pemasoks_list', function() {
            return Pemasok::all();
        });
        return view('barang.create', compact('pemasoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Barang' => 'required|string|max:255',
            'Jenis_Barang' => 'required|string',
            'Warna_Barang' => 'required|string',
            'Ukuran_Barang' => 'required|string',
            'Harga_Beli' => 'required|numeric|min:0',
            'Harga_Jual' => 'required|numeric|min:0',
            'ID_Pemasok' => 'required|string',
            'Stok_Awal' => 'required|integer|min:0',
        ]);

        $id_barang = 'BRG-' . strtoupper(Str::random(8));

        DB::beginTransaction();
        try {
            DataBarang::create([
                'ID_Barang' => $id_barang,
                'ID_Pemasok' => $request->ID_Pemasok,
                'Jenis_Barang' => $request->Jenis_Barang,
                'Nama_Barang' => $request->Nama_Barang,
                'Warna_Barang' => $request->Warna_Barang,
                'Ukuran_Barang' => $request->Ukuran_Barang,
                'Harga_Beli' => $request->Harga_Beli,
                'Harga_Jual' => $request->Harga_Jual,
            ]);

            StokBarang::create([
                'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'ID_Pemasok' => $request->ID_Pemasok,
                'ID_Barang' => $id_barang,
                'Stok_Awal' => $request->Stok_Awal,
                'Stok_Akhir' => $request->Stok_Awal,
            ]);

            DB::commit();
            return redirect()->route('data.barang.list')->with('success', 'Barang berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $barang = DataBarang::findOrFail($id);
        $pemasoks = Pemasok::all();
        return view('barang.edit', compact('barang', 'pemasoks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama_Barang' => 'required|string|max:255',
            'Jenis_Barang' => 'required|string',
            'Warna_Barang' => 'required|string',
            'Ukuran_Barang' => 'required|string',
            'Harga_Beli' => 'required|numeric|min:0',
            'Harga_Jual' => 'required|numeric|min:0',
            'ID_Pemasok' => 'required|string',
        ]);

        $barang = DataBarang::findOrFail($id);

        DB::beginTransaction();
        try {
            $barang->update($request->all());
            
            // Also update supplier in stock table if it exists
            $stok = StokBarang::where('ID_Barang', $id)->first();
            if ($stok) {
                $stok->update(['ID_Pemasok' => $request->ID_Pemasok]);
            }

            DB::commit();
            return redirect()->route('data.barang.list')->with('success', 'Data barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $barang = DataBarang::findOrFail($id);

        DB::beginTransaction();
        try {
            // StokBarang will be deleted automatically due to cascade on ID_Barang
            $barang->delete();

            DB::commit();
            return redirect()->route('data.barang.list')->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}
