<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Pelanggan' => 'required|string|max:255',
            'Alamat_Pelanggan' => 'required|string',
            'NoTelp_Pelanggan' => 'required|string|max:20',
        ]);

        Pelanggan::create([
            'ID_Pelanggan' => 'PLG-' . strtoupper(Str::random(8)),
            'Nama_Pelanggan' => $request->Nama_Pelanggan,
            'Alamat_Pelanggan' => $request->Alamat_Pelanggan,
            'NoTelp_Pelanggan' => $request->NoTelp_Pelanggan,
        ]);

        return redirect()->route('data.pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'Nama_Pelanggan' => 'required|string|max:255',
            'Alamat_Pelanggan' => 'required|string',
            'NoTelp_Pelanggan' => 'required|string|max:20',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('data.pelanggan')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('data.pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
