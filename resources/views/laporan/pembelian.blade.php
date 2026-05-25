@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 overflow-hidden">
 <!-- Filter Bar -->
 <div class="p-6 border-b border-slate-50">
 <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
 <div>
 <h2 class="font-bold text-slate-800 text-lg">Laporan Pembelian Stok</h2>
 <p class="text-slate-500 text-xs">Analisa riwayat pengadaan barang dari pemasok</p>
 </div>
 <form action="{{ route('laporan.pembelian') }}" method="GET" class="flex flex-wrap items-center gap-3">
 <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
 <i class="fas fa-calendar text-slate-400 mr-2 text-xs"></i>
 <input type="date" name="start_date" value="{{ $start_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-slate-700">
 <span class="mx-2 text-slate-300">-</span>
 <input type="date" name="end_date" value="{{ $end_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-slate-700">
 </div>
 <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-xl text-xs font-black hover:bg-teal-700 transition-all shadow-lg shadow-teal-500/30 hover:-translate-y-0.5">
 FILTER
 </button>
 <a href="{{ route('util.export', 'pembelian') }}" class="bg-teal-50 text-teal-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-teal-100 transition-all flex items-center">
 <i class="fas fa-file-excel mr-1"></i> EXPORT
 </a>
 </form>
 </div>
 </div>

 <!-- Stats Summary -->
 <div class="grid grid-cols-1 md:grid-cols-3 border-b border-slate-50">
 <div class="p-6 border-r border-slate-50">
 <p class="text-xs font-bold text-slate-400 mb-1">Total Transaksi</p>
 <h3 class="text-xl font-bold text-slate-800">{{ $pembelians->count() }}</h3>
 </div>
 <div class="p-6 border-r border-slate-50">
 <p class="text-xs font-bold text-slate-400 mb-1">Total Kuantitas</p>
 <h3 class="text-xl font-bold text-teal-600">+{{ $pembelians->sum('Kuantitas') }} <span class="text-xs text-slate-400 font-medium">Unit</span></h3>
 </div>
 <div class="p-6">
 <p class="text-xs font-bold text-slate-400 mb-1">Total Pengeluaran</p>
 <h3 class="text-xl font-bold text-teal-600">Rp {{ number_format($pembelians->sum('Total_Harga'), 0, ',', '.') }}</h3>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table class="w-full text-left">
 <thead>
 <tr class="bg-slate-50/80 backdrop-blur-sm text-slate-400 text-xs font-bold uppercase tracking-wider">
 <th class="py-4 px-6">Tanggal</th>
 <th class="py-4 px-6">Produk</th>
 <th class="py-4 px-6">Pemasok</th>
 <th class="py-4 px-6 text-center">Qty</th>
 <th class="py-4 px-6 text-right">Total Nominal</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-50">
 @forelse($pembelians as $item)
 <tr class="hover:bg-slate-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->Tgl_Pembelian)->format('d/m/Y') }}</td>
 <td class="py-4 px-6">
 <p class="text-sm font-bold text-slate-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
 <p class="text-xs text-slate-400 font-medium uppercase">{{ $item->dataBarang->Ukuran_Barang }} | {{ $item->dataBarang->Warna_Barang }}</p>
 </td>
 <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $item->pemasok->Nama_Pemasok ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
 <span class="px-2 py-1 bg-teal-50 text-teal-600 text-[11px] font-bold rounded-lg">+{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-slate-900 text-right">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 </tr>
 @empty
 <tr>
    <td colspan="100%" class="py-16 text-center">
        <div class="flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm">
                <i class="fas fa-file-invoice-dollar text-slate-300 text-3xl"></i>
            </div>
            <h3 class="text-slate-800 font-bold text-base">Data Laporan Kosong</h3>
            <p class="text-slate-400 text-sm mt-1">Belum ada catatan pembelian untuk ditampilkan pada periode ini.</p>
        </div>
    </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
