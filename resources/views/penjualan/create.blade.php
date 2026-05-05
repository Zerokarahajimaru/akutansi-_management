@extends('layouts.app')

@section('title', 'Input Penjualan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Catat Penjualan Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mencatat transaksi penjualan ke pelanggan.</p>
        </div>

        <form action="{{ route('input.penjualan') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barang -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Barang</label>
                    <select name="ID_Barang" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($barangs as $barang)
                        <option value="{{ $barang->ID_Barang }}">{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pelanggan -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</label>
                    <select name="ID_Pelanggan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->ID_Pelanggan }}">{{ $pelanggan->Nama_Pelanggan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Penjualan</label>
                    <input type="date" name="Tanggal_Penjualan" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Kuantitas -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kuantitas</label>
                    <input type="number" name="Kuantitas" placeholder="0" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Pembayaran</label>
                    <select name="Jenis_Pembayaran" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Qris">Qris</option>
                    </select>
                </div>

                <!-- Ongkir -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ongkir (Rp)</label>
                    <input type="number" name="Ongkir" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.penjualan') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-rose-600 text-white rounded-xl text-sm font-black hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Simpan Penjualan</button>
            </div>
        </form>
    </div>
</div>
@endsection
