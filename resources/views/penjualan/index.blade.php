@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Data Transaksi Penjualan</h2>
 <p class="text-gray-500 text-xs">Kelola riwayat transaksi penjualan barang kepada pelanggan Xyra.id</p>
 </div>
 <div class="flex flex-wrap items-center gap-2">
    <!-- Per Page Selector -->
    <div x-data="{ open: false }" class="relative inline-block text-left z-[100]" x-cloak>
        <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex items-center justify-between min-w-[140px] px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-teal-50 hover:text-teal-700 hover:border-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-500/30 transition-all shadow-sm group">
            <span class="truncate">Tampilkan: <span class="text-teal-600">{{ request('per_page', 50) === 'all' ? 'Semua' : request('per_page', 50) }}</span></span>
            <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-teal-600' : 'text-gray-400 group-hover:text-teal-500'"></i>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute left-0 mt-2 w-full min-w-[140px] bg-white border border-gray-100 rounded-xl shadow-xl z-50 py-1 overflow-hidden" style="display: none; top: 100%;">
            @foreach([5, 10, 25, 50, 'all'] as $size)
                <a href="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" wire:navigate class="block px-4 py-2 text-sm transition-all duration-200 {{ request('per_page', 50) == $size ? 'bg-teal-50 text-teal-700 font-bold border-l-2 border-teal-500' : 'text-gray-600 hover:bg-teal-50 hover:text-teal-700 border-l-2 border-transparent' }}">
                    {{ $size === 'all' ? 'Semua Data' : $size . ' Baris' }}
                </a>
            @endforeach
        </div>
    </div>

 <a href="{{ route('util.template', 'penjualan') }}" class="flex items-center px-4 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-100 transition-colors border border-gray-200">
    <i class="fas fa-file-arrow-down mr-2"></i> Unduh Template
 </a>

 <div x-data="{ openImport: false }" class="relative z-[100]">
     <button @click="openImport = true" class="flex items-center px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors border border-amber-200">
         <i class="fas fa-file-import mr-2"></i> Impor Data
     </button>
     
     <div x-show="openImport" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
         <div @click.outside="openImport = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all" x-transition.scale.95>
             <div class="flex justify-between items-center mb-5">
                 <h3 class="text-lg font-bold text-gray-800">Impor Data Penjualan</h3>
                 <button @click="openImport = false" class="text-gray-400 hover:text-red-500 transition-colors">
                     <i class="fas fa-xmark text-lg"></i>
                 </button>
             </div>
             <form action="{{ route('util.import', 'penjualan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                 @csrf
                 <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-teal-500 hover:bg-teal-50/50 transition-colors cursor-pointer relative">
                     <input type="file" name="csv_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".xlsx,.xls,.csv" required onchange="document.getElementById('fileNamePenjualan').textContent = this.files[0].name">
                     <i class="fas fa-cloud-arrow-up text-3xl text-teal-500 mb-3"></i>
                     <p class="text-sm font-semibold text-gray-700">Silakan klik atau seret file Excel ke area ini</p>
                     <p class="text-xs text-gray-500 mt-1">Format yang didukung: .xlsx, .xls, .csv</p>
                     <p id="fileNamePenjualan" class="text-xs font-bold text-teal-600 mt-3 truncate"></p>
                 </div>
                 <div class="flex justify-end space-x-3 pt-2">
                     <button type="button" @click="openImport = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl text-sm hover:bg-gray-200 transition-colors">Batal</button>
                     <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm hover:bg-teal-700 shadow-lg shadow-teal-200 transition-colors">Mulai Impor</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <a href="{{ route('util.export', 'penjualan') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Ekspor Excel
 </a>
 <a href="{{ route('input.penjualan') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-cart-shopping mr-2"></i> Tambah Penjualan
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table id="penjualan-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'Tanggal_Penjualan');
    $currentSortDir = request('sort_dir', 'desc');
 @endphp
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold uppercase tracking-wider">
 @php $newDir = ($currentSortBy === 'Tanggal_Penjualan' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Tanggal_Penjualan', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Tanggal
        <i class="fas {{ $currentSortBy === 'Tanggal_Penjualan' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6">Informasi Produk</th>
 <th class="py-4 px-6">Data Pelanggan</th>
 <th class="py-4 px-6">Metode Pembayaran</th>
 <th class="py-4 px-6 text-center">Kuantitas</th>
 <th class="py-4 px-6">Admin Pencatat</th>
 <th class="py-4 px-6">Total Harga</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($penjualans as $item)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ date('d/m/Y', strtotime($item->Tanggal_Penjualan)) }}</td>
 <td class="py-4 px-6">
 <div class="flex flex-col">
 <p class="text-sm font-bold text-gray-800">{{ $item->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</p>
 <p class="text-[10px] text-gray-400 font-bold uppercase italic">{{ $item->ID_Barang }}</p>
 </div>
 </td>
 <td class="py-4 px-6">
    <div class="flex flex-col">
        <p class="text-sm text-gray-700 font-semibold">{{ $item->pelanggan->Nama_Pelanggan ?? 'Umum' }}</p>
        <p class="text-[10px] text-teal-600 font-bold uppercase tracking-tighter">{{ $item->ID_Pelanggan ?? '-' }}</p>
    </div>
 </td>
 <td class="py-4 px-6">
    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-gray-200 bg-gray-50 text-gray-500">
        {{ $item->jenis_pembayaran ?? 'Tunai' }}
    </span>
 </td>
 <td class="py-4 px-6 text-center">
 <span class="text-sm font-bold text-rose-600">-{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6">
    <div class="flex flex-col">
        <span class="text-xs font-bold text-gray-700">{{ $item->user->name ?? 'Sistem' }}</span>
        <span class="text-[10px] text-teal-600 font-mono font-bold">{{ $item->user_id ?? '-' }}</span>
    </div>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-gray-900">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.penjualan.edit', $item->ID_Penjualan) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors" title="Ubah Data">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.penjualan.destroy', $item->ID_Penjualan) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors" title="Hapus Data">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr class="empty-state">
    <td colspan="100%" class="py-16 text-center">
        <div class="flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                <i class="fas fa-receipt text-gray-300 text-3xl"></i>
            </div>
            <h3 class="text-gray-800 font-bold text-base">Riwayat Penjualan Kosong</h3>
            <p class="text-gray-400 text-sm mt-1">Belum ada transaksi penjualan yang tercatat hari ini.</p>
        </div>
    </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-gray-50">
 {{ $penjualans->links() }}
 </div>
</div>
@endsection
