@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Filter Bar -->
 <div class="p-6 border-b border-gray-50">
 <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Laporan Penjualan Produk</h2>
 <p class="text-gray-500 text-xs">Analisa performa penjualan dan pendapatan toko</p>
 </div>
 <form action="{{ route('laporan.penjualan') }}" method="GET" class="flex flex-wrap items-center gap-3">
 <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-3 py-2">
 <i class="fas fa-calendar text-gray-400 mr-2 text-xs"></i>
 <input type="date" name="start_date" value="{{ $start_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-gray-700">
 <span class="mx-2 text-gray-300">-</span>
 <input type="date" name="end_date" value="{{ $end_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-gray-700">
 </div>
 <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-200">
 FILTER
 </button>
 <a href="{{ route('util.export', 'penjualan') }}" class="bg-teal-50 text-teal-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-teal-100 transition-all flex items-center">
 <i class="fas fa-file-excel mr-1"></i> EXPORT
 </a>
 </form>
 </div>
 </div>

 <!-- Stats Summary -->
 <div class="grid grid-cols-1 md:grid-cols-3 border-b border-gray-50">
 <div class="p-6 border-r border-gray-50">
 <p class="text-xs font-bold text-gray-400 mb-1">Total Transaksi</p>
 <h3 class="text-xl font-bold text-gray-800">{{ $penjualans->count() }}</h3>
 </div>
 <div class="p-6 border-r border-gray-50">
 <p class="text-xs font-bold text-gray-400 mb-1">Total Produk Terjual</p>
 <h3 class="text-xl font-bold text-red-600">-{{ $penjualans->sum('Kuantitas') }} <span class="text-xs text-gray-400 font-medium">Unit</span></h3>
 </div>
 <div class="p-6">
 <p class="text-xs font-bold text-gray-400 mb-1">Total Pendapatan (Gross)</p>
 <h3 class="text-xl font-bold text-teal-600">Rp {{ number_format($penjualans->sum('Total_Harga'), 0, ',', '.') }}</h3>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table class="w-full text-left">
 <thead>
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 <th class="py-4 px-6">Tanggal</th>
 <th class="py-4 px-6">Produk</th>
 <th class="py-4 px-6">Pelanggan</th>
 <th class="py-4 px-6 text-center">Qty</th>
 <th class="py-4 px-6 text-right">Total Nominal</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($penjualans as $item)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($item->Tanggal_Penjualan)->format('d/m/Y') }}</td>
 <td class="py-4 px-6">
 <p class="text-sm font-bold text-gray-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
 <p class="text-xs text-gray-400 font-medium uppercase">{{ $item->dataBarang->Ukuran_Barang }} | {{ $item->dataBarang->Warna_Barang }}</p>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ $item->pelanggan->Nama_Pelanggan ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
 <span class="px-2 py-1 bg-red-50 text-red-600 text-[11px] font-bold rounded-lg">-{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-gray-900 text-right">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="py-12 text-center text-gray-400 italic text-sm font-medium">Tidak ada data penjualan pada periode ini</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
