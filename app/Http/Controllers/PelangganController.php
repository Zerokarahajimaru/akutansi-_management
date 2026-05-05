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
            'Alamat' => 'required|string',
            'No_HP' => 'required|string|max:20',
        ]);

        Pelanggan::create([
            'ID_Pelanggan' => 'PLG-' . strtoupper(Str::random(8)),
            'Nama_Pelanggan' => $request->Nama_Pelanggan,
            'Alamat_Pelanggan' => $request->Alamat,
            'NoTelp_Pelanggan' => $request->No_HP,
        ]);

        return redirect()->route('data.pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }
}
