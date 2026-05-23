@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Riwayat Penjualan Barang</h2>
 <p class="text-gray-500 text-xs">Daftar semua transaksi stok keluar (Sales)</p>
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
        <template x-if="open">
            <div x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-1 z-50">
                <div @click.away="open = false" x-cloak 
                     class="w-20 bg-white border border-gray-100 rounded-xl shadow-xl py-1">
                    <template x-for="opt in options" :key="opt.val">
                        <div @click="changePerPage(opt.val)" 
                             class="px-3 py-1.5 hover:bg-teal-50 hover:text-teal-700 cursor-pointer transition-colors text-center" 
                             :class="selected == opt.val ? 'text-teal-600 font-bold bg-teal-50/50' : 'text-gray-600'">
                            <span x-text="opt.label"></span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>
 <form id="import-form" action="{{ route('util.import', 'penjualan') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'penjualan') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'penjualan') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.penjualan') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition-colors shadow-lg shadow-red-200">
 <i class="fas fa-plus mr-2"></i> Tambah Penjualan
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
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 @php $newDir = ($currentSortBy === 'Tanggal_Penjualan' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Tanggal_Penjualan', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Tanggal
        <i class="fas {{ $currentSortBy === 'Tanggal_Penjualan' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
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
 @php $newDir = ($currentSortBy === 'ID_Pelanggan' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'ID_Pelanggan', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Pelanggan
        <i class="fas {{ $currentSortBy === 'ID_Pelanggan' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
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
 @forelse($penjualans as $item)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->Tanggal_Penjualan)->format('d/m/Y') }}</td>
 <td class="py-4 px-6">
 <p class="text-sm font-bold text-gray-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
 <p class="text-xs text-gray-400 font-medium">{{ $item->ID_Penjualan }}</p>
 </td>
 <td class="py-4 px-6">
 <div class="flex flex-wrap gap-1">
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Jenis_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Warna_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Ukuran_Barang ?? '-' }}</span>
 </div>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $item->pelanggan->Nama_Pelanggan ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
 <span class="text-red-500 font-bold text-sm">-{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Total_Harga_Barang, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Ongkir, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm font-bold text-teal-600">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 @if(Auth::user()->role === 'admin')
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.penjualan.edit', $item->ID_Penjualan) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.penjualan.destroy', $item->ID_Penjualan) }}" method="POST">
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
 <i class="fas fa-file-signature text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Belum Ada Penjualan</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Transaksi penjualan akan muncul setelah Anda menginput data baru.</p>
 <a href="{{ route('input.penjualan') }}" wire:navigate.hover class="mt-4 text-teal-600 text-xs font-bold hover:underline">Mulai Catat Penjualan</a>
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
