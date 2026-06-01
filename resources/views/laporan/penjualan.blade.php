@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="space-y-8">
    <!-- Filter Card -->
    <div class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-pie text-teal-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-xl tracking-tight">Filter Laporan</h2>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Analisa Omzet Penjualan</p>
                </div>
            </div>
            
            <form action="{{ route('laporan.penjualan') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4">
                <div class="space-y-2 flex-1 sm:flex-initial">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <div class="space-y-2 flex-1 sm:flex-initial">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <button type="submit" class="bg-teal-600 text-white font-black px-6 py-3 rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-95 transition-all text-xs uppercase tracking-widest">
                    Terapkan
                </button>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center bg-slate-50/30 gap-4">
            <h3 class="font-black text-slate-800 text-lg">Detail Transaksi Keluar</h3>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('util.export', 'penjualan') }}" class="flex items-center justify-center px-5 py-2.5 bg-slate-100 text-slate-600 border border-slate-200 font-black rounded-xl text-xs uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">
                    <i class="fas fa-file-excel mr-2"></i> Ekspor Excel
                </a>
                <button onclick="window.print()" class="flex items-center justify-center px-5 py-2.5 bg-white text-slate-600 border border-slate-200 font-black rounded-xl text-xs uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">
                    <i class="fas fa-print mr-2"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100">
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
