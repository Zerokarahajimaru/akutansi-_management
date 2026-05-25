@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_8px_30px_rgb(13,148,136,0.04)]">
 <!-- Action Bar -->
 <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-slate-800 text-lg">Data Transaksi Pembelian</h2>
 <p class="text-slate-500 text-xs">Kelola riwayat pengadaan stok barang dari pemasok Xyra.id</p>
 </div>
 <div class="flex flex-wrap items-center gap-2">
    <!-- Per Page Selector -->
    <div x-data="{ open: false }" class="relative inline-block text-left z-[100]" x-cloak>
        <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex items-center justify-between min-w-[140px] px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500/30 transition-all shadow-sm group">
            <span class="truncate">Tampilkan: <span class="text-teal-600">{{ request('per_page', 50) === 'all' ? 'Semua' : request('per_page', 50) }}</span></span>
            <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-teal-600' : 'text-slate-400 group-hover:text-teal-500'"></i>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute left-0 mt-2 w-full min-w-[140px] bg-white border border-slate-100 rounded-xl shadow-xl z-50 py-1 overflow-hidden" style="display: none; top: 100%;">
            @foreach([5, 10, 25, 50, 'all'] as $size)
                <a href="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" wire:navigate class="block px-4 py-2 text-sm transition-all duration-200 {{ request('per_page', 50) == $size ? 'bg-slate-50 text-teal-700 font-bold border-l-2 border-teal-500' : 'text-slate-600 hover:bg-slate-50 hover:text-teal-700 border-l-2 border-transparent' }}">
                    {{ $size === 'all' ? 'Semua Data' : $size . ' Baris' }}
                </a>
            @endforeach
        </div>
    </div>

 <a href="{{ route('util.template', 'pembelian') }}" class="bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 font-bold rounded-xl px-4 py-2 text-xs transition-all flex items-center">
    <i class="fas fa-file-arrow-down mr-2"></i> Unduh Template
 </a>

 <div x-data="{ openImport: false, isDragging: false }" class="relative z-[100]">
     <button @click="openImport = true" class="bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 flex items-center px-4 py-2 rounded-xl text-xs font-bold transition-all">
         <i class="fas fa-file-import mr-2"></i> Impor Data
     </button>
     
     <div x-show="openImport" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" x-transition.opacity>
         <div @click.outside="openImport = false" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl w-full max-w-md p-6 transform transition-all" x-transition.scale.95>
             <div class="flex justify-between items-center mb-5">
                 <h3 class="text-lg font-bold text-slate-800">Impor Data Pembelian</h3>
                 <button @click="openImport = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                     <i class="fas fa-xmark text-lg"></i>
                 </button>
             </div>
             <form action="{{ route('util.import', 'pembelian') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                 @csrf
                 <div 
                     class="relative group rounded-[2.25rem] transition-all duration-500 p-2 bg-slate-100 border border-slate-200"
                     :class="isDragging ? 'bg-teal-50 border-teal-200 shadow-lg scale-[1.02]' : ''"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; document.getElementById('fileNamePembelian').textContent = $event.dataTransfer.files[0].name"
                 >
                     <div 
                         class="border-2 border-dashed rounded-[1.75rem] p-10 text-center transition-all duration-300 relative overflow-hidden"
                         :class="isDragging ? 'bg-white/50 border-teal-400' : 'border-slate-300 group-hover:border-teal-300'"
                     >
                         <input 
                             type="file" 
                             name="csv_file" 
                             x-ref="fileInput"
                             class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                             accept=".xlsx,.xls,.csv" 
                             required 
                             @change="document.getElementById('fileNamePembelian').textContent = $event.target.files[0].name"
                         >
                         <div class="relative z-0">
                             <i class="fas fa-cloud-arrow-up text-3xl text-teal-500 mb-3 transition-transform duration-300 group-hover:-translate-y-1"></i>
                             <p class="text-sm font-semibold text-slate-700">Silakan klik atau seret file Excel ke area ini</p>
                             <p class="text-xs text-slate-500 mt-1">Format yang didukung: .xlsx, .xls, .csv</p>
                             <p id="fileNamePembelian" class="text-xs font-bold text-teal-600 mt-3 truncate"></p>
                         </div>
                     </div>
                 </div>
                 <div class="flex justify-end space-x-3 pt-2">
                     <button type="button" @click="openImport = false" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl px-5 py-2.5 text-sm hover:bg-slate-200 transition-all">Batal</button>
                     <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-5 py-2.5 text-sm group">
                        <span>Impor Saja</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform ml-1"></i>
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <a href="{{ route('util.export', 'pembelian') }}" class="bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 font-bold rounded-xl px-4 py-2 text-xs transition-all flex items-center">
 <i class="fas fa-file-export mr-2"></i> Ekspor Excel
 </a>
 <a href="{{ route('input.pembelian') }}" wire:navigate.hover class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-4 py-2 text-xs flex items-center">
 <i class="fas fa-cart-plus mr-2"></i> Tambah Transaksi
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
 <tr class="bg-teal-50/80 text-slate-600 text-[10px] font-black uppercase tracking-widest">
 @php $newDir = ($currentSortBy === 'Tgl_Pembelian' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Tgl_Pembelian', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Tanggal
        <i class="fas {{ $currentSortBy === 'Tgl_Pembelian' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-slate-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6">Informasi Produk</th>
 <th class="py-4 px-6">Data Pemasok</th>
 <th class="py-4 px-6">Metode Pembayaran</th>
 <th class="py-4 px-6 text-center">Kuantitas</th>
 <th class="py-4 px-6">Admin Pencatat</th>
 <th class="py-4 px-6">Total Harga</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-50">
 @forelse($pembelians as $item)
 <tr class="bg-white hover:bg-slate-50 transition-colors duration-200">
 <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ date('d/m/Y', strtotime($item->Tgl_Pembelian)) }}</td>
 <td class="py-4 px-6">
 <div class="flex flex-col">
 <p class="text-sm font-bold text-slate-800">{{ $item->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</p>
 <p class="text-[10px] text-slate-400 font-bold uppercase italic">{{ $item->ID_Barang }}</p>
 </div>
 </td>
 <td class="py-4 px-6">
    <div class="flex flex-col">
        <p class="text-sm text-slate-700 font-semibold">{{ $item->pemasok->Nama_Pemasok ?? 'Pemasok Dihapus' }}</p>
        <p class="text-[10px] text-teal-600 font-bold uppercase tracking-tighter">{{ $item->ID_Pemasok ?? '-' }}</p>
    </div>
 </td>
 <td class="py-4 px-6">
    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200 bg-slate-50 text-slate-500">
        {{ $item->jenis_pembayaran ?? 'Transfer' }}
    </span>
 </td>
 <td class="py-4 px-6 text-center">
 <span class="text-sm font-bold text-teal-600">+{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6">
    <div class="items-center">
        <span class="text-xs font-medium text-slate-600">{{ $item->user->name ?? 'Sistem' }}</span>
        <span class="ml-1.5 text-[9px] text-slate-400 font-mono">({{ $item->user->formatted_id ?? '-' }})</span>
    </div>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-slate-900">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pembelian.edit', $item->ID_Pembelian) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-teal-600 hover:bg-teal-600 hover:text-white shadow-sm transition-all" title="Ubah Data">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pembelian.destroy', $item->ID_Pembelian) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white shadow-sm transition-all" title="Hapus Data">
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
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm">
                <i class="fas fa-file-invoice-dollar text-slate-300 text-3xl"></i>
            </div>
            <h3 class="text-slate-800 font-bold text-base">Riwayat Pembelian Kosong</h3>
            <p class="text-slate-400 text-sm mt-1">Belum ada transaksi pembelian untuk ditampilkan pada periode ini.</p>
        </div>
    </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-slate-50">
 {{ $pembelians->links() }}
 </div>
</div>
@endsection
