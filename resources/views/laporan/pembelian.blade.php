@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="space-y-8">
    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Pengeluaran -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/20 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Total Pengeluaran</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($summary['total_pengeluaran'] ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-[#A98D66]/10 rounded-xl flex items-center justify-center border border-[#3B8A7F]/20 shadow-sm">
                <i class="fas fa-cart-arrow-down text-slate-800 text-lg"></i>
            </div>
        </div>

        <!-- Total Barang Masuk -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Total Barang Masuk</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($summary['total_barang_masuk'] ?? 0, 0, ',', '.') }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Pcs</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 shadow-sm">
                <i class="fas fa-boxes-stacked text-blue-600 text-lg"></i>
            </div>
        </div>

        <!-- Top Pemasok -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all duration-300">
            <div class="min-w-0 flex-1 mr-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Mitra Teraktif</p>
                <h3 class="text-lg font-black text-slate-800 truncate" title="{{ $summary['top_pemasok'] ?? '-' }}">{{ $summary['top_pemasok'] ?? '-' }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center border border-amber-100 shadow-sm flex-shrink-0">
                <i class="fas fa-truck-fast text-amber-600 text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Universal Filter & Action Bar -->
    <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100">
        <!-- TOP DECK (Filters) -->
        <form action="{{ route('laporan.pembelian') }}" method="GET" class="w-full flex flex-col xl:flex-row items-end gap-4">
            <div class="relative flex-1 w-full min-w-[250px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-magnifying-glass text-slate-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all shadow-sm placeholder:text-slate-400" 
                    placeholder="Cari nota, produk, atau pemasok...">
            </div>
            <div class="flex flex-col sm:flex-row items-end gap-4 w-full xl:w-auto">
                <div class="space-y-1 flex-1 sm:flex-none w-full sm:w-auto">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Mulai</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="w-full bg-white border border-[#3B8A7F]/20 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all">
                </div>
                <div class="space-y-1 flex-1 sm:flex-none w-full sm:w-auto">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Sampai</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="w-full bg-white border border-[#3B8A7F]/20 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all">
                </div>
                <button type="submit" class="bg-[#ca5b33] text-white font-black px-6 py-3.5 rounded-xl shadow-lg shadow-[#ca5b33]/20 hover:bg-[#B04025] hover:-translate-y-0.5 active:scale-95 transition-all duration-300 text-[10px] uppercase tracking-widest flex-shrink-0 w-full sm:w-auto">
                    Terapkan
                </button>
            </div>
        </form>

        <!-- DIVIDER -->
        <hr class="border-slate-100 my-6">

        <!-- BOTTOM DECK (Exports) -->
        <div class="flex flex-col sm:flex-row justify-start xl:justify-end w-full">
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm w-full sm:w-auto">
                <a href="{{ route('laporan.export.excel', array_merge(request()->query(), ['type' => 'pembelian'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-emerald-50 text-slate-800 hover:text-emerald-700 text-[10px] font-black uppercase tracking-widest transition-all border-r border-slate-200 flex items-center justify-center gap-2">
                    <i class="fas fa-file-excel text-emerald-600 text-sm"></i> Ekspor Excel
                </a>
                <a href="{{ route('laporan.export.pdf', array_merge(request()->query(), ['type' => 'pembelian'])) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-50 hover:bg-white/5 text-slate-800 hover:text-[#B04025] text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-file-pdf text-[#B04025] text-sm"></i> Cetak PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100 m-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-white text-slate-800 text-[10px] font-black uppercase tracking-widest border-b-2 border-[#8E734B]">
                        <th class="py-5 px-8 whitespace-nowrap sticky left-0 bg-inherit z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Tanggal</th>
                        <th class="py-5 px-8 whitespace-nowrap">Produk / Barang</th>
                        <th class="py-5 px-8 whitespace-nowrap text-center">Qty</th>
                        <th class="py-5 px-8 whitespace-nowrap">Pemasok</th>
                        <th class="py-5 px-8 whitespace-nowrap">Pembayaran</th>
                        <th class="py-5 px-8 whitespace-nowrap text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembelians as $p)
                    <tr class="bg-white even:bg-white even:text-white hover:bg-[#A98D66]/20 transition-all group">
                        <td class="py-5 px-8 text-sm text-slate-800 font-medium whitespace-nowrap sticky left-0 bg-white even:bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#A98D66]/10">{{ $p->Tgl_Pembelian ? date('d/m/Y', strtotime($p->Tgl_Pembelian)) : '-' }}</td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[150px]">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-slate-800 transition-colors max-w-xs truncate" title="{{ $p->dataBarang->Nama_Barang ?? '' }}">{{ $p->dataBarang->Nama_Barang ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono uppercase">{{ $p->ID_Barang ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 text-center whitespace-nowrap">
                            <span class="px-3 py-1 bg-[#3B8A7F]/10 text-slate-800 rounded-xl text-xs font-black">+{{ $p->Kuantitas ?? 0 }}</span>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <div class="flex flex-col min-w-[150px]">
                                <span class="text-sm text-slate-800 font-semibold max-w-xs truncate" title="{{ $p->pemasok->Nama_Pemasok ?? '' }}">{{ $p->pemasok->Nama_Pemasok ?? '-' }}</span>
                                <span class="text-[10px] text-slate-800 font-bold uppercase tracking-tighter">{{ $p->ID_Pemasok ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 whitespace-nowrap">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 border border-slate-200 px-2 py-0.5 rounded-xl">{{ $p->jenis_pembayaran ?? '-' }}</span>
                        </td>
                        <td class="py-5 px-8 text-right whitespace-nowrap">
                            <span class="text-sm font-black text-slate-800">Rp {{ number_format($p->Total_Harga ?? 0, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <i class="fas fa-file-invoice text-5xl mb-4 text-slate-300"></i>
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
ion
