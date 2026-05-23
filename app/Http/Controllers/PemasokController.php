<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemasokController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Nama_Pemasok');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') {
            $perPage = 9999;
        }

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
        ]);

        Pemasok::create([
            'ID_Pemasok' => 'PMS-' . strtoupper(Str::random(8)),
            'Nama_Pemasok' => $request->Nama_Pemasok,
            'Alamat_Pemasok' => $request->Alamat_Pemasok,
            'NoTelp_Pemasok' => $request->NoTelp_Pemasok,
        ]);

        return redirect()->route('data.pemasok')->with('success', 'Pemasok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return view('pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, $id)
    {
        $pemasok = Pemasok::findOrFail($id);

        $request->validate([
            'Nama_Pemasok' => 'required|string|max:255',
            'Alamat_Pemasok' => 'required|string',
            'NoTelp_Pemasok' => 'required|string|max:20',
        ]);

        $pemasok->update($request->all());

        return redirect()->route('data.pemasok')->with('success', 'Pemasok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        $pemasok->delete();

        return redirect()->route('data.pemasok')->with('success', 'Pemasok berhasil dihapus.');
    }
}
