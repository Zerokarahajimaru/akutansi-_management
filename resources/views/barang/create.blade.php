@extends('layouts.app')

@section('title', 'Input Barang Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Tambah Produk Ke Katalog</h2>
            <p class="text-slate-500 text-sm mt-1">Lengkapi informasi detail produk untuk ditambahkan ke sistem inventaris.</p>
        </div>

        <form action="{{ route('input.barang') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Barang -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Produk</label>
                    <input type="text" name="Nama_Barang" placeholder="Contoh: Gamis Chino Premium" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Jenis -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis / Kategori</label>
                    <select name="Jenis_Barang" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="Baju">Baju</option>
                        <option value="Celana">Celana</option>
                        <option value="Gamis">Gamis</option>
                        <option value="Aksesoris">Aksesoris</option>
                    </select>
                </div>

                <!-- Warna -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Warna</label>
                    <input type="text" name="Warna_Barang" placeholder="Contoh: Kuning, Navy, Hitam" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Ukuran -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ukuran</label>
                    <select name="Ukuran_Barang" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        <option value="S">S (Small)</option>
                        <option value="M">M (Medium)</option>
                        <option value="L">L (Large)</option>
                        <option value="XL">XL (Extra Large)</option>
                        <option value="XXL">XXL (Double XL)</option>
                        <option value="All Size">All Size</option>
                    </select>
                </div>

                <!-- Pemasok -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pemasok Utama</label>
                    <select name="ID_Pemasok" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                        @foreach($pemasoks as $pemasok)
                        <option value="{{ $pemasok->ID_Pemasok }}">{{ $pemasok->Nama_Pemasok }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Beli -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Beli (Rp)</label>
                    <input type="number" name="Harga_Beli" placeholder="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Harga Jual -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Jual (Rp)</label>
                    <input type="number" name="Harga_Jual" placeholder="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Stok Awal -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Awal Inventaris</label>
                    <input type="number" name="Stok_Awal" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    <p class="text-[10px] text-slate-400">Stok ini akan dicatat sebagai saldo awal di tabel stok.</p>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.barang.list') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Daftarkan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection
