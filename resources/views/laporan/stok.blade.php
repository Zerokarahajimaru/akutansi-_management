@extends('layouts.app')

@section('title', 'Ketersediaan Stok')

@section('content')
<div class="space-y-8">
    <!-- Header Card -->
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-boxes-stacked text-teal-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-2xl tracking-tight">Ketersediaan Stok</h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Pantau Inventaris Secara Real-Time</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <a href="{{ route('util.export', 'barang') }}" class="flex items-center justify-center px-6 py-3 bg-teal-600 text-white font-black rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-95 transition-all">
                    <i class="fas fa-file-excel mr-2"></i> Ekspor CSV
                </a>
                <button onclick="window.print()" class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">
                    <i class="fas fa-print mr-2"></i> Cetak PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Inventory Grid/Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-teal-50/80 text-slate-600 text-[10px] font-black uppercase tracking-widest whitespace-nowrap">
                        <th class="py-5 px-8">ID Produk</th>
                        <th class="py-5 px-8">Nama Produk</th>
                        <th class="py-5 px-8">Kategori</th>
                        <th class="py-5 px-8 text-center">Stok Awal</th>
                        <th class="py-5 px-8 text-center">Stok Akhir</th>
                        <th class="py-5 px-8">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($stoks as $s)
                    <tr class="hover:bg-teal-50/30 transition-colors group">
                        <td class="py-5 px-8 whitespace-nowrap">
                            <span class="text-[11px] font-black font-mono text-teal-600 bg-teal-50 px-2 py-1 rounded-md">{{ $s->ID_Barang }}</span>
                        </td>
                        <td class="py-5 px-8">
                            <div class="flex flex-col min-w-[200px]">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ $s->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</span>
                                <span class="text-[10px] text-slate-400 font-medium uppercase mt-0.5 tracking-wider">{{ $s->dataBarang->Warna_Barang ?? '-' }} / {{ $s->dataBarang->Ukuran_Barang ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $s->dataBarang->Jenis_Barang ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 text-center text-sm text-slate-400 font-medium italic whitespace-nowrap">
                            {{ $s->Stok_Awal }}
                        </td>
                        <td class="py-5 px-8 text-center whitespace-nowrap">
                            @php
                                $statusClass = $s->Stok_Akhir < 10 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600';
                            @endphp
                            <span class="px-4 py-1.5 {{ $statusClass }} rounded-full text-sm font-black shadow-sm">
                                {{ $s->Stok_Akhir }}
                            </span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            @if($s->Stok_Akhir < 10)
                                <div class="flex items-center gap-2 text-rose-500 animate-pulse">
                                    <i class="fas fa-triangle-exclamation text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-tighter">Stok Kritis</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-emerald-500">
                                    <i class="fas fa-circle-check text-xs"></i>
                                    <span class="text-[10px] font-black uppercase tracking-tighter">Tersedia</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
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
