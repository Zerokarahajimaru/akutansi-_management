<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Nama_Pemasok');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $pemasoks = Pemasok::orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('pemasok.index', compact('pemasoks'));
    }

    public function create()
    {
        return view('pemasok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Pemasok' => 'required|string|max:255',
            'Alamat_Pemasok' => 'required|string',
            'NoTelp_Pemasok' => 'required|string|max:20',
        ], [
            'Nama_Pemasok.required' => 'Nama pemasok wajib diisi.',
            'Alamat_Pemasok.required' => 'Alamat pemasok wajib diisi.',
            'NoTelp_Pemasok.required' => 'Nomor telepon wajib diisi.',
        ]);

        try {
            Pemasok::create([
                'ID_Pemasok' => Pemasok::generateId('PMS'),
                'Nama_Pemasok' => $request->Nama_Pemasok,
                'Alamat_Pemasok' => $request->Alamat_Pemasok,
                'NoTelp_Pemasok' => $request->NoTelp_Pemasok,
            ]);

            return redirect()->route('data.pemasok')->with('success', 'Data pemasok berhasil ditambahkan ke sistem.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan pemasok: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return view('pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama_Pemasok' => 'required|string|max:255',
            'Alamat_Pemasok' => 'required|string',
            'NoTelp_Pemasok' => 'required|string|max:20',
        ]);

        $pemasok = Pemasok::findOrFail($id);

        try {
            $pemasok->update($request->all());
            return redirect()->route('data.pemasok')->with('success', 'Informasi pemasok berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data pemasok: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pemasok = Pemasok::findOrFail($id);

        try {
            $pemasok->delete();
            return redirect()->route('data.pemasok')->with('success', 'Data pemasok telah dihapus dari sistem.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data pemasok: ' . $e->getMessage());
        }
    }
}
