@extends('layouts.app')

@section('title', 'Input Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Daftar Pelanggan Baru</h2>
        </div>
        <form action="{{ route('input.pelanggan') }}" method="POST" class="p-8 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pelanggan</label>
                <input type="text" name="Nama_Pelanggan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">No. HP</label>
                <input type="text" name="No_HP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat</label>
                <textarea name="Alamat" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-1" required></textarea>
            </div>
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('data.pelanggan') }}" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
