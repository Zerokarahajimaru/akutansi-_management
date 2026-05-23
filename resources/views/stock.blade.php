@extends('layouts.app')

@section('title', 'Data Barang & Stok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Master Data Barang</h2>
 <p class="text-gray-500 text-xs">Kelola informasi produk dan pantau ketersediaan stok</p>
 </div>
 <div class="flex flex-wrap items-center gap-2" x-data="{ 
 triggerImport() { document.getElementById('import-file').click() },
 submitImport() { document.getElementById('import-form').submit() }
 }">
 <div class="flex items-center gap-2 text-xs text-gray-500 bg-gray-50/50 px-3 py-2 rounded-xl border border-gray-100">
    <span class="font-medium">Show:</span>
    <div x-data="{ 
        open: false, 
        selected: '{{ request('per_page', 50) }}',
        options: [
            {val: '5', label: '5'},
            {val: '10', label: '10'},
            {val: '25', label: '25'},
            {val: '50', label: '50'},
            {val: 'all', label: 'All'}
        ],
        init() {
            // Ensure selected matches request exactly
            this.selected = '{{ request('per_page', 50) }}';
        },
        changePerPage(val) {
            this.selected = val;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    }" class="relative">
        <button @click="open = !open" type="button" class="flex items-center gap-2 bg-white border border-gray-200 rounded-lg px-2.5 py-1 hover:border-teal-500 transition-all shadow-sm">
            <span x-text="selected === 'all' ? 'All' : selected" class="font-bold text-teal-600"></span>
            <i class="fas fa-chevron-down text-[9px] text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
        </button>
        <div x-show="open" @click.away="open = false" x-cloak 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute right-0 mt-1 w-20 bg-white border border-gray-100 rounded-xl shadow-xl z-50 py-1">
            <template x-for="opt in options" :key="opt.val">
                <div @click="changePerPage(opt.val)" 
                     class="px-3 py-1.5 hover:bg-teal-50 hover:text-teal-700 cursor-pointer transition-colors text-center" 
                     :class="selected == opt.val ? 'text-teal-600 font-bold bg-teal-50/50' : 'text-gray-600'">
                    <span x-text="opt.label"></span>
                </div>
            </template>
        </div>
    </div>
</div>
 <form id="import-form" action="{{ route('util.import', 'barang') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'barang') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'barang') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.barang') }}" class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-box-archive mr-2"></i> Tambah Barang
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
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 @php $newDir = ($currentSortBy === 'Nama_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Nama_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Nama Produk
        <i class="fas {{ $currentSortBy === 'Nama_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Jenis_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Jenis_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Jenis
        <i class="fas {{ $currentSortBy === 'Jenis_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Warna_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Warna_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Warna
        <i class="fas {{ $currentSortBy === 'Warna_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Ukuran_Barang' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Ukuran_Barang', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Ukuran
        <i class="fas {{ $currentSortBy === 'Ukuran_Barang' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Harga_Beli' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Harga_Beli', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Harga Beli
        <i class="fas {{ $currentSortBy === 'Harga_Beli' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Harga_Jual' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Harga_Jual', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Harga Jual
        <i class="fas {{ $currentSortBy === 'Harga_Jual' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6 text-center">
    <div class="flex items-center text-gray-400">
        Stok Akhir
    </div>
 </th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($stocks as $barang)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm font-bold text-gray-800">{{ $barang->Nama_Barang }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $barang->Jenis_Barang }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $barang->Warna_Barang }}</td>
 <td class="py-4 px-6">
 <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg uppercase">{{ $barang->Ukuran_Barang }}</span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-500 italic">Rp {{ number_format($barang->Harga_Beli, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm font-bold text-teal-600">Rp {{ number_format($barang->Harga_Jual, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center">
 @php
 $stok_akhir = $barang->stokBarangs->sum('Stok_Akhir');
 @endphp
 <span class="px-3 py-1 rounded-full text-xs font-bold {{ $stok_akhir < 10 ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-teal-600' }}">
 {{ $stok_akhir }}
 </span>
 </td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.barang.edit', $barang->ID_Barang) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.barang.destroy', $barang->ID_Barang) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="9" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
 <i class="fas fa-tags text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Produk Belum Tersedia</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Katalog produk dan stok Anda masih kosong saat ini.</p>
 <a href="{{ route('input.barang') }}" class="mt-4 text-teal-600 text-xs font-bold hover:underline">Tambah Produk Master</a>
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
