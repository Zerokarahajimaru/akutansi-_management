@extends('layouts.app')

@section('title', 'Edit Pembelian')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Edit Transaksi Pembelian</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi transaksi stok masuk.</p>
        </div>

        <form action="{{ route('data.pembelian.update', $pembelian->ID_Pembelian) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
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
                        @foreach($barangs as $barang)
                        <option value="{{ $barang->ID_Barang }}" {{ $pembelian->ID_Barang === $barang->ID_Barang ? 'selected' : '' }}>{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pemasok -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pemasok</label>
                    <select name="ID_Pemasok" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        @foreach($pemasoks as $pemasok)
                        <option value="{{ $pemasok->ID_Pemasok }}" {{ $pembelian->ID_Pemasok === $pemasok->ID_Pemasok ? 'selected' : '' }}>{{ $pemasok->Nama_Pemasok }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Pembelian</label>
                    <input type="date" name="Tgl_Pembelian" value="{{ old('Tgl_Pembelian', \Carbon\Carbon::parse($pembelian->Tgl_Pembelian)->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Kuantitas -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kuantitas</label>
                    <input type="number" name="Kuantitas" value="{{ old('Kuantitas', $pembelian->Kuantitas) }}" placeholder="0" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Pembayaran</label>
                    <select name="Jenis_Pembayaran" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="Tunai" {{ $pembelian->Jenis_Pembayaran === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Transfer" {{ $pembelian->Jenis_Pembayaran === 'Transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="Kredit" {{ $pembelian->Jenis_Pembayaran === 'Kredit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                </div>

                <!-- Ongkir -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ongkir (Rp)</label>
                    <input type="number" name="Ongkir" value="{{ old('Ongkir', $pembelian->Ongkir) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.pembelian') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Perbarui Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection
