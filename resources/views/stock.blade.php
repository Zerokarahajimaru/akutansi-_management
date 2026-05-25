@extends('layouts.app')

@section('title', 'Katalog Produk & Stok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Stok & Master Barang</h2>
 <p class="text-gray-500 text-xs">Pantau ketersediaan stok produk dan kelola informasi barang</p>
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

 <a href="{{ route('util.template', 'barang') }}" class="flex items-center px-4 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-100 transition-colors border border-gray-200">
    <i class="fas fa-file-arrow-down mr-2"></i> Unduh Template
 </a>

 <div x-data="{ openImport: false, isDragging: false }" class="relative z-[100]">
     <button @click="openImport = true" class="flex items-center px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors border border-amber-200">
         <i class="fas fa-file-import mr-2"></i> Impor Data
     </button>
     
     <div x-show="openImport" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
         <div @click.outside="openImport = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all" x-transition.scale.95>
             <div class="flex justify-between items-center mb-5">
                 <h3 class="text-lg font-bold text-gray-800">Impor Data Barang</h3>
                 <button @click="openImport = false" class="text-gray-400 hover:text-red-500 transition-colors">
                     <i class="fas fa-xmark text-lg"></i>
                 </button>
             </div>
             <form action="{{ route('util.import', 'barang') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                 @csrf
                 <div 
                     class="relative group rounded-[2.25rem] transition-all duration-500 p-2 bg-gray-200 border border-gray-300"
                     :class="isDragging ? 'bg-teal-50 border-teal-200 shadow-lg scale-[1.02]' : ''"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; document.getElementById('fileNameBarang').textContent = $event.dataTransfer.files[0].name"
                 >
                     <div 
                         class="border-2 border-dashed rounded-[1.75rem] p-10 text-center transition-all duration-300 relative overflow-hidden"
                         :class="isDragging ? 'bg-white/50 border-teal-400' : 'border-gray-300 group-hover:border-teal-300'"
                     >
                         <input 
                             type="file" 
                             name="csv_file" 
                             x-ref="fileInput"
                             class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                             accept=".xlsx,.xls,.csv" 
                             required 
                             @change="document.getElementById('fileNameBarang').textContent = $event.target.files[0].name"
                         >
                         <div class="relative z-0">
                             <i class="fas fa-cloud-arrow-up text-3xl text-teal-500 mb-3 transition-transform duration-300 group-hover:-translate-y-1"></i>
                             <p class="text-sm font-semibold text-gray-700">Silakan klik atau seret file Excel ke area ini</p>
                             <p class="text-xs text-gray-500 mt-1">Format yang didukung: .xlsx, .xls, .csv</p>
                             <p id="fileNameBarang" class="text-xs font-bold text-teal-600 mt-3 truncate"></p>
                         </div>
                     </div>
                 </div>
                 <div class="flex justify-end space-x-3 pt-2">
                     <button type="button" @click="openImport = false" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl text-sm hover:bg-gray-200 transition-colors">Batal</button>
                     <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm hover:bg-teal-700 shadow-lg shadow-teal-200 transition-colors group">
                        <span>Impor Saja</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <a href="{{ route('util.export', 'barang') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Ekspor Excel
 </a>
 <a href="{{ route('input.barang') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-boxes-packing mr-2"></i> Tambah Produk
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table id="stock-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'Nama_Barang');
    $currentSortDir = request('sort_dir', 'asc');
 @endphp
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold uppercase tracking-wider">
 <th class="py-4 px-6">ID Barang</th>
 @php $newDir = ($currentSortBy === 'Nama_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Nama_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Informasi Produk
        <i class="fas {{ $currentSortBy === 'Nama_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6">ID Pemasok</th>
 <th class="py-4 px-6 text-center">Stok Awal</th>
 <th class="py-4 px-6 text-center">Stok Akhir</th>
 <th class="py-4 px-6">Harga Jual</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($stocks as $barang)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-teal-600 font-bold uppercase">{{ $barang->ID_Barang }}</td>
 <td class="py-4 px-6">
 <div class="flex flex-col">
 <p class="text-sm font-bold text-gray-800">{{ $barang->Nama_Barang }}</p>
 <div class="flex gap-2 mt-1">
 <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded uppercase font-bold">{{ $barang->Jenis_Barang }}</span>
 <span class="text-[10px] bg-teal-50 text-teal-600 px-1.5 py-0.5 rounded uppercase font-bold">{{ $barang->Ukuran_Barang }}</span>
 </div>
 </div>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600 uppercase font-medium">{{ $barang->ID_Pemasok }}</td>
 <td class="py-4 px-6 text-center text-sm text-gray-500">{{ $barang->stokBarangs->first()->Stok_Awal ?? 0 }}</td>
 <td class="py-4 px-6 text-center">
 @php $stok = $barang->stokBarangs->first()->Stok_Akhir ?? 0; @endphp
 <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $stok < 10 ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-teal-50 text-teal-600 border border-teal-100' }}">
 {{ $stok }}
 </span>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-gray-900">Rp {{ number_format($barang->Harga_Jual, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.barang.edit', $barang->ID_Barang) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors" title="Ubah Produk">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.barang.destroy', $barang->ID_Barang) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors" title="Hapus Produk">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="7" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
 <i class="fas fa-tags text-gray-300 text-3xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Produk Belum Tersedia</h3>
 <p class="text-gray-400 text-sm mt-1">Gunakan tombol di atas untuk menambah produk master baru.</p>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-gray-50">
 {{ $stocks->links() }}
 </div>
</div>
@endsection
