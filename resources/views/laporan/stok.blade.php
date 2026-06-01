@extends('layouts.app')

@section('title', 'Ketersediaan Stok')

@section('content')
<div class="space-y-8">
    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Estimasi Valuasi Aset -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-teal-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Estimasi Valuasi Aset</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($summary['valuasi_aset'] ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center border border-teal-100 shadow-sm">
                <i class="fas fa-boxes-stacked text-teal-600 text-lg"></i>
            </div>
        </div>

        <!-- Stok Aman -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Stok Aman (>= 10)</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['stok_aman'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Item</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center border border-emerald-100 shadow-sm">
                <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Stok Kritis (< 10)</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['stok_kritis'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Item</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center border border-amber-100 shadow-sm">
                <i class="fas fa-triangle-exclamation text-amber-600 text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
        <form action="{{ route('laporan.stok') }}" method="GET" class="w-full md:max-w-md relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-magnifying-glass text-slate-400 text-xs"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all shadow-sm placeholder:text-slate-400" 
                placeholder="Cari produk atau kategori...">
        </form>

        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('util.export', 'barang') }}" class="flex-1 md:flex-none flex items-center justify-center px-6 py-2.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 font-bold rounded-xl text-[10px] uppercase tracking-widest transition-all active:scale-95">
                <i class="fas fa-file-excel mr-2"></i> Ekspor Excel
            </a>
            <button onclick="window.print()" class="flex-1 md:flex-none flex items-center justify-center px-6 py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white border border-rose-200 font-bold rounded-xl text-[10px] uppercase tracking-widest transition-all active:scale-95">
                <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
            </button>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100 m-4">
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
                                <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors max-w-xs truncate" title="{{ $s->dataBarang->Nama_Barang ?? '' }}">{{ $s->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</span>
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
