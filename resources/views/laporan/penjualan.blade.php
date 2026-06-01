@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="space-y-8">
    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-teal-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Total Pendapatan</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($summary['total_pendapatan'] ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center border border-teal-100 shadow-sm">
                <i class="fas fa-wallet text-teal-600 text-lg"></i>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Total Transaksi</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['total_transaksi'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Nota</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 shadow-sm">
                <i class="fas fa-receipt text-blue-600 text-lg"></i>
            </div>
        </div>

        <!-- Produk Best Seller -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all duration-300">
            <div class="min-w-0 flex-1 mr-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Produk Terlaris</p>
                <h3 class="text-lg font-black text-slate-800 truncate" title="{{ $summary['best_seller'] ?? '-' }}">{{ $summary['best_seller'] ?? '-' }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center border border-amber-100 shadow-sm flex-shrink-0">
                <i class="fas fa-crown text-amber-600 text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Universal Filter & Action Bar -->
    <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100">
        <!-- TOP DECK (Filters) -->
        <form action="{{ route('laporan.penjualan') }}" method="GET" class="w-full flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 w-full">
            <div class="relative flex-1 w-full min-w-[250px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-magnifying-glass text-slate-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all shadow-sm placeholder:text-slate-400" 
                    placeholder="Cari nota, produk, atau pelanggan...">
            </div>
            <div class="flex flex-col sm:flex-row items-end gap-4 w-full xl:w-auto">
                <div class="space-y-1 flex-1 sm:flex-none w-full sm:w-auto">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Mulai</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="w-full bg-white border border-teal-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <div class="space-y-1 flex-1 sm:flex-none w-full sm:w-auto">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Sampai</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="w-full bg-white border border-teal-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <button type="submit" class="bg-teal-600 text-white font-black px-6 py-3.5 rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 active:scale-95 transition-all text-[10px] uppercase tracking-widest flex-shrink-0 w-full sm:w-auto">
                    Terapkan
                </button>
            </div>
        </form>

        <!-- DIVIDER -->
        <hr class="border-slate-100 my-6">

        <!-- BOTTOM DECK (Exports) -->
        <div class="flex flex-col sm:flex-row justify-start xl:justify-end w-full">
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm w-full sm:w-auto">
                <a href="{{ route('laporan.export.excel', array_merge(request()->query(), ['type' => 'penjualan'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-[10px] font-black uppercase tracking-widest transition-all border-r border-slate-200 flex items-center justify-center gap-2">
                    <i class="fas fa-file-excel text-emerald-600 text-sm"></i> Ekspor Excel
                </a>
                <a href="{{ route('laporan.export.pdf', array_merge(request()->query(), ['type' => 'penjualan'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-rose-50 text-slate-600 hover:text-rose-700 text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-file-pdf text-rose-600 text-sm"></i> Cetak PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100 m-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-teal-50/80 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                        <th class="py-5 px-8 whitespace-nowrap sticky left-0 bg-teal-50 z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Tanggal</th>
                        <th class="py-5 px-8 whitespace-nowrap">Produk / Barang</th>
                        <th class="py-5 px-8 whitespace-nowrap text-center">Qty</th>
                        <th class="py-5 px-8 whitespace-nowrap">Nama Pelanggan</th>
                        <th class="py-5 px-8 whitespace-nowrap">Pembayaran</th>
                        <th class="py-5 px-8 whitespace-nowrap text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($penjualans as $p)
                    <tr class="even:bg-slate-50/50 hover:bg-teal-50/60 transition-colors group">
                        <td class="py-5 px-8 text-sm text-slate-600 font-medium whitespace-nowrap sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-teal-50">{{ $p->Tanggal_Penjualan ? date('d/m/Y', strtotime($p->Tanggal_Penjualan)) : '-' }}</td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[150px]">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors max-w-xs truncate" title="{{ $p->dataBarang->Nama_Barang ?? '' }}">{{ $p->dataBarang->Nama_Barang ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono uppercase">{{ $p->ID_Barang ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 text-center whitespace-nowrap">
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-xl text-xs font-black">-{{ $p->Kuantitas ?? 0 }}</span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[150px]">
                                <span class="text-sm text-slate-700 font-semibold max-w-xs truncate" title="{{ $p->pelanggan->Nama_Pelanggan ?? 'Umum' }}">{{ $p->pelanggan->Nama_Pelanggan ?? 'Umum' }}</span>
                                <span class="text-[10px] text-teal-600 font-bold uppercase tracking-tighter">{{ $p->ID_Pelanggan ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 border border-slate-200 px-2 py-0.5 rounded-xl">{{ $p->jenis_pembayaran ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 text-right whitespace-nowrap">
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($p->Total_Harga ?? 0, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <i class="fas fa-receipt text-5xl mb-4 text-slate-300"></i>
                                <p class="text-slate-500 font-black uppercase tracking-widest text-xs">Data Tidak Ditemukan</p>
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
