<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'Nama_Pelanggan');
        $sortDir = $request->input('sort_dir', 'asc');
        $perPage = $request->input('per_page', 50);
        if ($perPage === 'all') $perPage = 9999;

        $pelanggans = Pelanggan::orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

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
        ], [
            'Nama_Pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'Alamat_Pelanggan.required' => 'Alamat pelanggan wajib diisi.',
            'NoTelp_Pelanggan.required' => 'Nomor telepon wajib diisi.',
        ]);

        try {
            Pelanggan::create([
                'ID_Pelanggan' => Pelanggan::generateId('PLG'),
                'Nama_Pelanggan' => $request->Nama_Pelanggan,
                'Alamat_Pelanggan' => $request->Alamat_Pelanggan,
                'NoTelp_Pelanggan' => $request->NoTelp_Pelanggan,
            ]);

            return redirect()->route('data.pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan pelanggan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama_Pelanggan' => 'required|string|max:255',
            'Alamat_Pelanggan' => 'required|string',
            'NoTelp_Pelanggan' => 'required|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        try {
            $pelanggan->update($request->all());
            return redirect()->route('data.pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pelanggan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        try {
            $pelanggan->delete();
            return redirect()->route('data.pelanggan')->with('success', 'Data pelanggan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pelanggan: ' . $e->getMessage());
        }
    }
}
