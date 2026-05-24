@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Riwayat Pembelian Barang</h2>
 <p class="text-gray-500 text-xs">Daftar semua transaksi stok masuk (Purchase)</p>
 </div>
 <div class="flex flex-wrap items-center gap-2" x-data="{ 
 triggerImport() { document.getElementById('import-file').click() },
 submitImport() { document.getElementById('import-form').submit() }
 }">
 <div x-data="{ open: false }" class="relative inline-block text-left z-[100]" x-cloak>
    <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex items-center justify-between min-w-[140px] px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-teal-50 hover:text-teal-700 hover:border-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-500/30 transition-all shadow-sm group">
        <span class="truncate">Tampilkan: <span class="text-teal-600">{{ request('per_page', 50) === 'all' ? 'Semua' : request('per_page', 50) }}</span></span>
        <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-teal-600' : 'text-gray-400 group-hover:text-teal-500'"></i>
    </button>
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-150" 
         x-transition:enter-start="opacity-0 scale-95 translate-y-1" 
         x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
         class="absolute left-0 mt-2 w-full min-w-[140px] bg-white border border-gray-100 rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
         style="display: none; top: 100%;">
        <div class="py-1">
            @foreach([5, 10, 25, 50, 'all'] as $size)
                <a href="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" 
                   wire:navigate 
                   class="block px-4 py-2 text-sm transition-all duration-200 {{ request('per_page', 50) == $size ? 'bg-teal-50 text-teal-700 font-bold' : 'text-gray-600 hover:bg-teal-50 hover:text-teal-700 border-l-2 border-transparent' }}">
                    {{ $size === 'all' ? 'Semua Data' : $size . ' Baris' }}
                </a>
            @endforeach
        </div>
    </div>
</div>
 <form id="import-form" action="{{ route('util.import', 'pembelian') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'pembelian') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'pembelian') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.pembelian') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-plus mr-2"></i> Tambah Transaksi
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table id="pembelian-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'Tgl_Pembelian');
    $currentSortDir = request('sort_dir', 'desc');
 @endphp
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 @php $newDir = ($currentSortBy === 'Tgl_Pembelian' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Tgl_Pembelian', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Tanggal
        <i class="fas {{ $currentSortBy === 'Tgl_Pembelian' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'ID_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'ID_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Produk
        <i class="fas {{ $currentSortBy === 'ID_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6 text-gray-400">Spesifikasi</th>
 @php $newDir = ($currentSortBy === 'ID_Pemasok' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'ID_Pemasok', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Pemasok
        <i class="fas {{ $currentSortBy === 'ID_Pemasok' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Kuantitas' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 text-center cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Kuantitas', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Kuantitas
        <i class="fas {{ $currentSortBy === 'Kuantitas' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Total_Harga_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Total_Harga_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Harga Barang
        <i class="fas {{ $currentSortBy === 'Total_Harga_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Ongkir' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Ongkir', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Ongkir
        <i class="fas {{ $currentSortBy === 'Ongkir' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Total_Harga' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 font-bold text-gray-700 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Total_Harga', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Total Harga
        <i class="fas {{ $currentSortBy === 'Total_Harga' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @if(Auth::user()->role === 'admin')
 <th class="py-4 px-6 text-center">Aksi</th>
 @endif
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($pembelians as $item)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->Tgl_Pembelian)->format('d/m/Y') }}</td>
 <td class="py-4 px-6">
 <p class="text-sm font-bold text-gray-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
 <p class="text-xs text-gray-400 font-medium">{{ $item->ID_Pembelian }}</p>
 </td>
 <td class="py-4 px-6">
 <div class="flex flex-wrap gap-1">
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Jenis_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Warna_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Ukuran_Barang ?? '-' }}</span>
 </div>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $item->pemasok->Nama_Pemasok ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
 <span class="text-teal-500 font-bold text-sm">+{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Total_Harga_Barang, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Ongkir, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm font-bold text-teal-600">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 @if(Auth::user()->role === 'admin')
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pembelian.edit', $item->ID_Pembelian) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pembelian.destroy', $item->ID_Pembelian) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 @endif
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="{{ Auth::user()->role === 'admin' ? 9 : 8 }}" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
 <i class="fas fa-file-invoice text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Riwayat Kosong</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Belum ada transaksi pembelian barang yang tercatat.</p>
 <a href="{{ route('input.pembelian') }}" wire:navigate.hover class="mt-4 text-teal-600 text-xs font-bold hover:underline">Input Pembelian Pertama</a>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-gray-50">
 {{ $pembelians->links() }}
 </div>
</div>
@endsection
