@extends('layouts.app')

@section('title', 'Data Barang & Stok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Action Bar -->
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Master Data Barang</h2>
            <p class="text-slate-500 text-xs">Kelola informasi produk dan pantau ketersediaan stok</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                <i class="fas fa-file-export mr-2"></i> Export
            </button>
            <button class="flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                <i class="fas fa-download mr-2"></i> Unduh Template
            </button>
            <button class="flex items-center px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors">
                <i class="fas fa-file-import mr-2"></i> Import Data
            </button>
            <a href="{{ route('input.barang') }}" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                <i class="fas fa-plus mr-2"></i> Tambah Barang
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest font-black">
                    <th class="py-4 px-6">ID Barang</th>
                    <th class="py-4 px-6">Nama Produk</th>
                    <th class="py-4 px-6">Jenis</th>
                    <th class="py-4 px-6">Warna</th>
                    <th class="py-4 px-6">Ukuran</th>
                    <th class="py-4 px-6">Harga Beli</th>
                    <th class="py-4 px-6">Harga Jual</th>
                    <th class="py-4 px-6 text-center">Stok Akhir</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($stocks as $barang)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 text-xs font-mono text-slate-400">{{ $barang->ID_Barang }}</td>
                    <td class="py-4 px-6 text-sm font-bold text-slate-800">{{ $barang->Nama_Barang }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $barang->Jenis_Barang }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $barang->Warna_Barang }}</td>
                    <td class="py-4 px-6">
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase">{{ $barang->Ukuran_Barang }}</span>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-500 italic">Rp {{ number_format($barang->Harga_Beli, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-sm font-bold text-indigo-600">Rp {{ number_format($barang->Harga_Jual, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $stok_akhir = $barang->stokBarangs->sum('Stok_Akhir');
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-black {{ $stok_akhir < 10 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">
                            {{ $stok_akhir }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 hover:bg-orange-500 hover:text-white transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-10 text-center text-slate-400 italic text-sm">Belum ada data barang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
