@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="space-y-8">
    <!-- Filter Card -->
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-filter text-teal-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 text-xl tracking-tight">Filter Laporan</h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Pengadaan Stok Barang</p>
                </div>
            </div>
            
            <form action="{{ route('laporan.pembelian') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all">
                </div>
                <button type="submit" class="bg-teal-600 text-white font-black px-6 py-2.5 rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-95 transition-all text-xs uppercase tracking-widest">
                    Terapkan
                </button>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-800 text-lg">Ringkasan Transaksi</h3>
            <div class="flex gap-2">
                <a href="{{ route('util.export', 'pembelian') }}" class="flex items-center px-5 py-2.5 bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">
                    <i class="fas fa-file-excel mr-2"></i> Ekspor Excel
                </a>
                <button onclick="window.print()" class="flex items-center px-5 py-2.5 bg-white text-slate-600 border border-slate-200 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">
                    <i class="fas fa-print mr-2"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-teal-50/80 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                        <th class="py-5 px-8">Tanggal</th>
                        <th class="py-5 px-8">Produk / Barang</th>
                        <th class="py-5 px-8 text-center">Qty</th>
                        <th class="py-5 px-8">Pemasok</th>
                        <th class="py-5 px-8">Pembayaran</th>
                        <th class="py-5 px-8 text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembelians as $p)
                    <tr class="hover:bg-teal-50/30 transition-colors group">
                        <td class="py-5 px-8 text-sm text-slate-600 font-medium">{{ date('d/m/Y', strtotime($p->Tgl_Pembelian)) }}</td>
                        <td class="py-5 px-8">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ $p->dataBarang->Nama_Barang ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-mono uppercase">{{ $p->ID_Barang }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8 text-center">
                            <span class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs font-black">+{{ $p->Kuantitas }}</span>
                        </td>
                        <td class="py-5 px-8">
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-700 font-semibold">{{ $p->pemasok->Nama_Pemasok ?? '-' }}</span>
                                <span class="text-[10px] text-teal-600 font-bold uppercase tracking-tighter">{{ $p->ID_Pemasok }}</span>
                            </div>
                        </td>
                        <td class="py-5 px-8">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 border border-slate-200 px-2 py-0.5 rounded-lg">{{ $p->jenis_pembayaran }}</span>
                        </td>
                        <td class="py-5 px-8 text-right">
                            <span class="text-sm font-black text-slate-900">Rp {{ number_format($p->Total_Harga, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <i class="fas fa-file-invoice text-5xl mb-4 text-slate-300"></i>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Data Tidak Ditemukan</p>
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
