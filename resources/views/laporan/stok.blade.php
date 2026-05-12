@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header Bar -->
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Status Inventaris Terkini</h2>
            <p class="text-slate-500 text-xs">Pantau ketersediaan stok barang di seluruh kategori</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('util.export', 'barang') }}" class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-emerald-100 transition-all flex items-center">
                <i class="fas fa-file-excel mr-1"></i> EXPORT CSV
            </a>
            <button type="button" onclick="window.print()" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-slate-200 transition-all">
                <i class="fas fa-print mr-1"></i> CETAK
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest font-black">
                    <th class="py-4 px-6">Nama Produk</th>
                    <th class="py-4 px-6">Kategori</th>
                    <th class="py-4 px-6 text-center">Stok Awal</th>
                    <th class="py-4 px-6 text-center">Stok Akhir</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($stoks as $stok)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6">
                        <p class="text-sm font-bold text-slate-800">{{ $stok->dataBarang->Nama_Barang ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase">{{ $stok->dataBarang->Ukuran_Barang }} | {{ $stok->dataBarang->Warna_Barang }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $stok->dataBarang->Jenis_Barang ?? '-' }}</td>
                    <td class="py-4 px-6 text-center text-sm font-medium text-slate-400">{{ $stok->Stok_Awal }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="text-sm font-black {{ $stok->Stok_Akhir < 10 ? 'text-rose-600' : 'text-indigo-600' }}">
                            {{ $stok->Stok_Akhir }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($stok->Stok_Akhir <= 0)
                            <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-black rounded uppercase">Habis</span>
                        @elseif($stok->Stok_Akhir < 10)
                            <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black rounded uppercase">Menipis</span>
                        @else
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded uppercase">Tersedia</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-xs text-slate-400 italic">
                        {{ $stok->Keterangan ?? 'Tidak ada catatan' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 italic text-sm font-medium">Data inventaris belum tersedia</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
