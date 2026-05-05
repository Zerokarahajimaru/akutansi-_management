<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemasokController extends Controller
{
    public function index()
    {
        $pemasoks = Pemasok::all();
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
            'Alamat' => 'required|string',
            'No_HP' => 'required|string|max:20',
        ]);

        Pemasok::create([
            'ID_Pemasok' => 'PMS-' . strtoupper(Str::random(8)),
            'Nama_Pemasok' => $request->Nama_Pemasok,
            'Alamat_Pemasok' => $request->Alamat,
            'NoTelp_Pemasok' => $request->No_HP,
        ]);

        return redirect()->route('data.pemasok')->with('success', 'Pemasok berhasil ditambahkan.');
    }
}
