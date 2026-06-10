@extends('layouts.app')

@section('title', 'Master Stok Barang')

@section('content')
<div class="space-y-8">
    <!-- Action Bar Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-[#A98D66] font-black tracking-tightest uppercase text-lg">Manajemen Stok Gudang</h2>
                    <p class="text-slate-500 text-xs font-medium">Lakukan penyesuaian stok masuk/keluar secara manual dengan audit trail</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <form method="GET" action="{{ route('data.stok') }}" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#ca5b33]">
                            <i class="fas fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all w-full sm:w-[260px]" 
                            placeholder="Cari ID atau nama produk...">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative">
            <table id="stok-table" class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#B04025] text-white text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">
                        <th class="py-6 px-8 sticky left-0 bg-[#B04025] z-20 shadow-[4px_0_10px_-3px_rgba(0,0,0,0.2)]">ID Stok</th>
                        <th class="py-6 px-8">Produk</th>
                        <th class="py-6 px-8 text-center">Saldo Stok</th>
                        <th class="py-6 px-8">Status</th>
                        <th class="py-6 px-8 text-center">Riwayat</th>
                        <th class="py-6 px-8 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($stokMaster as $stok)
                        <tr class="group bg-white hover:bg-[#A98D66]/10 transition-all duration-200">
                            <td class="py-5 px-8 text-xs font-black text-slate-400 uppercase tracking-widest sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0] transition-colors whitespace-nowrap">
                                {{ $stok->ID_Stok }}
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex flex-col min-w-[200px]">
                                    <span class="text-sm font-bold text-slate-800 leading-tight">{{ $stok->dataBarang->Nama_Barang ?? '-' }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-1.5 py-0.5 bg-slate-100 rounded text-[9px] font-bold text-slate-500 uppercase tracking-tighter">{{ $stok->dataBarang->Jenis_Barang ?? '-' }}</span>
                                        <span class="text-[9px] font-medium text-slate-400 uppercase tracking-tighter">{{ $stok->dataBarang->Warna_Barang }} / {{ $stok->dataBarang->Ukuran_Barang }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-center whitespace-nowrap">
                                @php $qty_akhir = $stok->Stok_Akhir ?? 0; @endphp
                                <span class="text-base font-black {{ $qty_akhir < 10 ? 'text-[#ca5b33]' : 'text-slate-800' }}">
                                    {{ number_format($qty_akhir, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                @php
                                    $qty = $stok->Stok_Akhir;
                                    if ($qty > 10) {
                                        $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                        $statusLabel = 'Tersedia';
                                        $dotClass = 'bg-emerald-500';
                                    } elseif ($qty > 0) {
                                        $badgeClass = 'bg-[#ca5b33]/5 text-[#ca5b33] border-[#ca5b33]/10';
                                        $statusLabel = 'Menipis';
                                        $dotClass = 'bg-[#ca5b33]';
                                    } else {
                                        $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                                        $statusLabel = 'Habis';
                                        $dotClass = 'bg-rose-500';
                                    }
                                @endphp
                                <div class="inline-flex items-center px-2.5 py-1 {{ $badgeClass }} border rounded-lg gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} animate-pulse"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest">{{ $statusLabel }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <a href="{{ route('data.stok.history', $stok->ID_Stok) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#A98D66] hover:text-white transition-all shadow-sm" title="Lihat History Stok">
                                    <i class="fas fa-clock-rotate-left text-xs"></i>
                                </a>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('data.barang.edit', $stok->ID_Stok) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-xl bg-slate-50 text-slate-800 hover:bg-[#3B8A7F] hover:text-white shadow-sm transition-all" title="Penyesuaian Stok (Update)">
                                        <i class="fas fa-sliders text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-box-open text-slate-300 text-2xl"></i>
                                    </div>
                                    <h3 class="text-slate-800 font-bold">Data Stok Kosong</h3>
                                    <p class="text-slate-400 text-sm mt-1">Belum ada data stok barang yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-50">
            {{ $stokMaster->links() }}
        </div>
    </div>
</div>
@endsection
