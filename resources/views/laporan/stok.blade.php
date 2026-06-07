@extends('layouts.app')

@section('title', 'Ketersediaan Stok')

@section('content')
<div class="space-y-8">
    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Estimasi Valuasi Aset -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Estimasi Valuasi Aset</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($summary['valuasi_aset'] ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-[#A98D66]/10 rounded-xl flex items-center justify-center border border-slate-200/20 shadow-sm">
                <i class="fas fa-boxes-stacked text-slate-800 text-lg"></i>
            </div>
        </div>

        <!-- Stok Aman -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Stok Aman (>= 10)</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['stok_aman'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Item</span></h3>
            </div>
            <div class="w-12 h-12 bg-[#3B8A7F]/10 rounded-xl flex items-center justify-center border border-[#3B8A7F]/20 shadow-sm">
                <i class="fas fa-check-circle text-slate-800 text-lg"></i>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#CA5B33]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Stok Kritis (< 10)</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['stok_kritis'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Item</span></h3>
            </div>
            <div class="w-12 h-12 bg-[#3B8A7F]/10 rounded-xl flex items-center justify-center border border-[#CA5B33]/20 shadow-sm">
                <i class="fas fa-triangle-exclamation text-[#CA5B33] text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
        <!-- Left Side (Form/Search) -->
        <form action="{{ route('laporan.stok') }}" method="GET" class="relative w-full md:w-96 flex-shrink-0">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-magnifying-glass text-slate-400 text-xs"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all shadow-sm placeholder:text-slate-400" 
                placeholder="Cari produk atau kategori...">
        </form>

        <!-- Right Side (Exports) -->
        <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm w-full sm:w-auto">
            <a href="{{ route('laporan.export.excel', array_merge(request()->query(), ['type' => 'stok'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-[#A98D66]/5 text-slate-800 hover:text-slate-800 text-[10px] font-black uppercase tracking-widest transition-all border-r border-slate-200 flex items-center justify-center gap-2">
                <i class="fas fa-file-excel text-slate-800 text-sm"></i> Ekspor Excel
            </a>
            <a href="{{ route('laporan.export.pdf', array_merge(request()->query(), ['type' => 'stok'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-white/5 text-slate-800 hover:text-[#B04025] text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                <i class="fas fa-file-pdf text-[#B04025] text-sm"></i> Cetak PDF
            </a>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#B04025] text-white text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">
                        <th class="py-6 px-8 whitespace-nowrap sticky left-0 bg-[#B04025] z-20 shadow-[4px_0_10px_-3px_rgba(0,0,0,0.2)]">ID Produk</th>
                            <th class="py-6 px-8 whitespace-nowrap">Nama Produk</th>
                            <th class="py-6 px-8 whitespace-nowrap">Kategori</th>
                            <th class="py-6 px-8 whitespace-nowrap text-center">Stok Awal</th>
                            <th class="py-6 px-8 whitespace-nowrap text-center">Stok Akhir</th>
                            <th class="py-6 px-8 whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($stoks as $s)
                        <tr class="hover:bg-[#A98D66]/10 transition-all group">
                            <td class="py-5 px-8 whitespace-nowrap sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0]">
                            <span class="text-[11px] font-black font-mono text-slate-800 bg-[#3B8A7F]/10 px-2 py-1 rounded-lg">{{ $s->ID_Barang ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[200px]">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-slate-800 transition-colors max-w-xs truncate" title="{{ $s->dataBarang->Nama_Barang ?? '' }}">{{ $s->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</span>
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
                                $statusClass = ($s->Stok_Akhir ?? 0) < 10 ? 'bg-[#3B8A7F]/10 text-[#CA5B33] border border-[#CA5B33]/20' : 'bg-[#3B8A7F]/10 text-slate-800 border border-[#3B8A7F]/20';
                            @endphp
                            <span class="px-4 py-1.5 {{ $statusClass }} rounded-xl text-sm font-black shadow-sm">
                                {{ $s->Stok_Akhir ?? 0 }}
                            </span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            @if(($s->Stok_Akhir ?? 0) < 10)
                                <div class="flex items-center gap-2 text-[#CA5B33] animate-pulse">
                                    <i class="fas fa-triangle-exclamation text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Stok Kritis</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-slate-800">
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
                                <i class="fas fa-cubes text-6xl mb-4 text-slate-500"></i>
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
