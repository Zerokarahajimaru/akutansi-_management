@extends('layouts.app')

@section('title', 'Ketersediaan Stok')

@section('content')
<div class="space-y-8">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-teal-50 rounded-xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-boxes-stacked text-teal-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-2xl tracking-tight">Ketersediaan Stok</h2>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Pantau Inventaris Secara Real-Time</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <form action="{{ route('laporan.stok') }}" method="GET" class="w-full sm:w-[300px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-magnifying-glass text-slate-400 text-xs"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all shadow-sm placeholder:text-slate-400" 
                        placeholder="Cari Produk atau Kategori...">
                </form>

                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('util.export', 'barang') }}" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-2.5 bg-teal-600 text-white font-black rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-teal-500/20 hover:bg-teal-700 active:scale-95 transition-all">
                        <i class="fas fa-file-excel mr-2"></i> Ekspor
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Grid/Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-teal-50/80 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                        <th class="py-5 px-8 whitespace-nowrap sticky left-0 bg-teal-50 z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">ID Produk</th>
                        <th class="py-5 px-8 whitespace-nowrap">Nama Produk</th>
                        <th class="py-5 px-8 whitespace-nowrap">Kategori</th>
                        <th class="py-5 px-8 whitespace-nowrap text-center">Stok Awal</th>
                        <th class="py-5 px-8 whitespace-nowrap text-center">Stok Akhir</th>
                        <th class="py-5 px-8 whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($stoks as $s)
                    <tr class="even:bg-slate-50/50 hover:bg-teal-50/60 transition-colors group">
                        <td class="py-5 px-8 whitespace-nowrap sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-teal-50">
                            <span class="text-[11px] font-black font-mono text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">{{ $s->ID_Barang ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[200px]">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors max-w-xs truncate" title="{{ $s->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}">{{ $s->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</span>
                                <span class="text-[10px] text-slate-400 font-black uppercase mt-0.5 tracking-widest">{{ $s->dataBarang->Warna_Barang ?? '-' }} / {{ $s->dataBarang->Ukuran_Barang ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest">{{ $s->dataBarang->Jenis_Barang ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 text-center text-sm text-slate-400 font-medium italic whitespace-nowrap">
                            {{ $s->Stok_Awal ?? 0 }}
                        </td>
                        <td class="py-5 px-8 text-center whitespace-nowrap">
                            @php
                                $statusClass = ($s->Stok_Akhir ?? 0) < 10 ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                            @endphp
                            <span class="px-4 py-1.5 {{ $statusClass }} rounded-xl text-sm font-black shadow-sm">
                                {{ $s->Stok_Akhir ?? 0 }}
                            </span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            @if(($s->Stok_Akhir ?? 0) < 10)
                                <div class="flex items-center gap-2 text-amber-500 animate-pulse">
                                    <i class="fas fa-triangle-exclamation text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Stok Kritis</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-emerald-500">
                                    <i class="fas fa-circle-check text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Tersedia</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <i class="fas fa-cubes text-6xl mb-4 text-slate-200"></i>
                                <p class="text-slate-500 font-black uppercase tracking-[0.2em] text-xs">Gudang Kosong</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
