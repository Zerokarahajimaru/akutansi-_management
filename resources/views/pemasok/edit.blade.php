@extends('layouts.app')

@section('title', 'Edit Pemasok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Edit Data Pemasok</h2>
        </div>
        <form action="{{ route('data.pemasok.update', $pemasok->ID_Pemasok) }}" method="POST" class="p-8 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pemasok</label>
                <input type="text" name="Nama_Pemasok" value="{{ old('Nama_Pemasok', $pemasok->Nama_Pemasok) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">No. HP</label>
                <input type="text" name="NoTelp_Pemasok" value="{{ old('NoTelp_Pemasok', $pemasok->NoTelp_Pemasok) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat</label>
                <textarea name="Alamat_Pemasok" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required>{{ old('Alamat_Pemasok', $pemasok->Alamat_Pemasok) }}</textarea>
            </div>
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('data.pemasok') }}" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-200">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
