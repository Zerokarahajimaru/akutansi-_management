@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgba(13,148,136,0.05)]">
 <!-- Action Bar -->
 <div class="p-6 border-b border-slate-50">
 <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
 <div>
 <h2 class="font-black text-[#ca5b33] text-lg tracking-tight">Data Transaksi Penjualan</h2>
 <p class="text-slate-500 text-xs font-medium">Kelola riwayat transaksi penjualan barang kepada pelanggan Xyra.id</p>
 </div>
 </div>

 <div class="flex flex-col xl:flex-row justify-between items-center gap-4 mb-6 w-full">
    <form method="GET" action="" class="w-full sm:w-[320px] lg:w-[400px] flex-shrink-0 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-magnifying-glass text-slate-400"></i>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" 
            class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3B8A7F]/20 focus:border-[#3B8A7F] transition-all shadow-sm placeholder:text-slate-400" 
            placeholder="Cari data berdasarkan nama, ID, atau kategori...">
        @if(request('search'))
            <a href="{{ request()->url() }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#B04025] transition-colors">
                <i class="fas fa-circle-xmark"></i>
            </a>
        @endif
    </form>

    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Per Page Selector -->
        <div x-data="{ open: false }" class="relative inline-block text-left z-[30] w-full sm:w-auto" x-cloak>
            <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex items-center justify-between w-full sm:min-w-[140px] px-4 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#3B8A7F]/30 transition-all shadow-sm group">
                <span class="truncate">Tampilkan: <span class="text-slate-800">{{ request('per_page', 50) === 'all' ? 'Semua' : request('per_page', 50) }}</span></span>
                <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-slate-800' : 'text-slate-400 group-hover:text-slate-800'"></i>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute left-0 mt-2 w-full min-w-[140px] bg-white border border-slate-100 rounded-xl shadow-xl z-[100] py-1 overflow-hidden" style="display: none; top: 100%;">
                @foreach([5, 10, 25, 50, 'all'] as $size)
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" wire:navigate class="block px-4 py-2 text-sm transition-all duration-200 {{ request('per_page', 50) == $size ? 'bg-slate-50 text-slate-800 font-bold border-l-2 border-[#3B8A7F]' : 'text-slate-800 hover:bg-slate-50 hover:text-slate-800 border-l-2 border-transparent' }}">
                        {{ $size === 'all' ? 'Semua Data' : $size . ' Baris' }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Utility Toolbar -->
        <div class="flex items-center bg-slate-100 border border-slate-200 rounded-xl shadow-sm w-full sm:w-auto divide-x divide-slate-200 overflow-hidden">
            <!-- Unduh Template -->
            <a href="{{ route('util.template', 'penjualan') }}" class="flex-1 lg:flex-none flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-slate-800 transition-all" title="Unduh Template Excel">
                <i class="fas fa-file-arrow-down mr-2 text-slate-400"></i> <span>Template</span>
            </a>

            <!-- Impor Data -->
            <div x-data="{ openImport: false, isDragging: false, isSubmitting: false }" class="flex-1 lg:flex-none">
                <button @click="openImport = true" class="w-full flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-[#CA5B33] transition-all" title="Impor Data Excel">
                    <i class="fas fa-file-import mr-2 text-[#CA5B33]"></i> <span>Impor</span>
                </button>
                
                <div x-show="openImport" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" x-transition.opacity>
                    <div @click.outside="openImport = false" class="bg-white rounded-2xl border border-slate-100 shadow-xl w-full max-w-md p-6 transform transition-all" x-transition.scale.95>
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-lg font-bold text-slate-800">Impor Data Penjualan</h3>
                            <button @click="openImport = false" class="text-slate-400 hover:text-[#B04025] transition-colors">
                                <i class="fas fa-xmark text-lg"></i>
                            </button>
                        </div>
                        <form action="{{ route('util.import', 'penjualan') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true" class="space-y-4">
                            @csrf
                            <div 
                                class="relative group rounded-xl transition-all duration-500 p-2 bg-slate-100 border border-slate-200"
                                :class="isDragging ? 'bg-[#A98D66]/10 border-slate-200/20 shadow-lg scale-[1.02]' : ''"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; document.getElementById('fileNamePenjualan').textContent = $event.dataTransfer.files[0].name"
                            >
                                <div 
                                    class="border-2 border-dashed rounded-xl p-10 text-center transition-all duration-300 relative overflow-hidden"
                                    :class="isDragging ? 'bg-white/50 border-[#3B8A7F]' : 'border-slate-300 group-hover:border-[#3B8A7F]/50'"
                                >
                                    <input 
                                        type="file" 
                                        name="csv_file" 
                                        x-ref="fileInput"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                        accept=".xlsx,.xls,.csv" 
                                        required 
                                        @change="document.getElementById('fileNamePenjualan').textContent = $event.target.files[0].name"
                                    >
                                    <div class="relative z-0">
                                        <i class="fas fa-cloud-arrow-up text-3xl text-slate-800 mb-3 transition-transform duration-300 group-hover:-translate-y-1"></i>
                                        <p class="text-sm font-semibold text-slate-800">Silakan klik atau seret file Excel ke area ini</p>
                                        <p class="text-xs text-slate-500 mt-1">Format yang didukung: .xlsx, .xls, .csv</p>
                                        <p id="fileNamePenjualan" class="text-xs font-bold text-slate-800 mt-3 truncate"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2">
                                <button type="button" @click="openImport = false" class="w-full sm:w-auto bg-slate-100 text-slate-800 border border-slate-200 font-bold rounded-xl hover:bg-slate-200 transition-all px-5 py-2.5 text-sm">Batal</button>
                                <button type="submit" :disabled="isSubmitting" :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''" class="w-full sm:w-auto bg-[#3B8A7F] text-white font-black rounded-xl shadow-lg shadow-[#3B8A7F]/25 hover:bg-white hover:-translate-y-0.5 active:scale-95 transition-all duration-300 px-5 py-2.5 text-sm flex items-center justify-center group">
                                    <span x-show="!isSubmitting">Impor Saja</span>
                                    <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                                        Memproses... <i class="fas fa-circle-notch fa-spin ml-2"></i>
                                    </span>
                                    <i x-show="!isSubmitting" class="fas fa-arrow-right text-[10px] ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Ekspor Excel -->
            <a href="{{ route('util.export', 'penjualan') }}" class="flex-1 lg:flex-none flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-emerald-600 transition-all" title="Ekspor Data Excel">
                <i class="fas fa-file-export mr-2 text-emerald-500"></i> <span>Ekspor</span>
            </a>
        </div>

        <a href="{{ route('input.penjualan') }}" wire:navigate.hover class="w-full sm:w-auto bg-[#ca5b33] text-white font-black rounded-xl shadow-lg shadow-[#ca5b33]/25 hover:bg-[#B04025] hover:-translate-y-0.5 active:scale-95 transition-all duration-300 px-6 py-3 text-[10px] uppercase tracking-widest flex items-center justify-center">
            <i class="fas fa-cart-shopping mr-2"></i> Tambah Penjualan
        </a>
    </div>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto custom-scrollbar relative rounded-xl border border-slate-100">
 <table id="penjualan-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'Tanggal_Penjualan');
    $currentSortDir = request('sort_dir', 'desc');
 @endphp
 <tr class="bg-white text-[#000000] text-[10px] font-black uppercase tracking-widest whitespace-nowrap border-b-2 border-[#8E734B]">
 @php $newDir = ($currentSortBy === 'Tanggal_Penjualan' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group sticky left-0 bg-white z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] whitespace-nowrap" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Tanggal_Penjualan', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Tanggal
        <i class="fas {{ $currentSortBy === 'Tanggal_Penjualan' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-slate-800' : 'fa-sort-down text-slate-800') : 'fa-sort text-slate-300' }} text-[10px] ml-auto group-hover:text-slate-800 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6 whitespace-nowrap">Informasi Produk</th>
 <th class="py-4 px-6 whitespace-nowrap">Data Pelanggan</th>
 <th class="py-4 px-6 whitespace-nowrap">Metode Pembayaran</th>
 <th class="py-4 px-6 text-center whitespace-nowrap">Kuantitas</th>
 <th class="py-4 px-6 whitespace-nowrap">Admin Pencatat</th>
 <th class="py-4 px-6 text-right whitespace-nowrap">Total Harga</th>
 <th class="py-4 px-6 text-center whitespace-nowrap">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-50">
 @forelse($penjualans as $item)
 <tr class="group bg-white even:bg-white even:text-white hover:bg-[#A98D66]/20 transition-all duration-200">
 <td class="py-4 px-6 text-sm text-slate-800 font-medium sticky left-0 bg-white even:bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0] whitespace-nowrap">{{ $item->Tanggal_Penjualan ? date('d/m/Y', strtotime($item->Tanggal_Penjualan)) : '-' }}</td>
 <td class="py-4 px-6 whitespace-nowrap">
 <div class="flex flex-col min-w-[180px]">
 <p class="text-sm font-bold text-slate-800 max-w-xs truncate" title="{{ $item->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}">{{ $item->dataBarang->Nama_Barang ?? 'Produk Dihapus' }}</p>
 <p class="text-[10px] text-slate-400 font-bold uppercase italic">{{ $item->ID_Barang ?? '-' }}</p>
 </div>
 </td>
 <td class="py-4 px-6 whitespace-nowrap">
    <div class="flex flex-col min-w-[150px]">
        <p class="text-sm text-slate-800 font-semibold max-w-xs truncate" title="{{ $item->pelanggan->Nama_Pelanggan ?? 'Umum' }}">{{ $item->pelanggan->Nama_Pelanggan ?? 'Umum' }}</p>
        <p class="text-[10px] text-slate-800 font-bold uppercase tracking-tighter">{{ $item->ID_Pelanggan ?? '-' }}</p>
    </div>
 </td>
 <td class="py-4 px-6 whitespace-nowrap">
    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200 bg-slate-50 text-slate-500">
        {{ $item->jenis_pembayaran ?? 'Tunai' }}
    </span>
 </td>
 <td class="py-4 px-6 text-center whitespace-nowrap">
 <span class="text-sm font-bold text-[#B04025]">-{{ $item->Kuantitas ?? 0 }}</span>
 </td>
 <td class="py-4 px-6 whitespace-nowrap">
    <div class="flex flex-col min-w-[120px]">
        <span class="text-xs font-bold text-slate-800">{{ $item->user->name ?? 'Sistem' }}</span>
        <span class="text-[10px] text-slate-800 font-mono font-bold">{{ $item->user_id ?? '-' }}</span>
    </div>
 </td>
 <td class="py-4 px-6 text-sm font-bold text-slate-800 text-right whitespace-nowrap">Rp {{ number_format($item->Total_Harga ?? 0, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center whitespace-nowrap">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.penjualan.edit', $item->ID_Penjualan) }}" wire:navigate class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-slate-800 hover:bg-[#3B8A7F] hover:text-white shadow-sm transition-all" title="Ubah Data">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.penjualan.destroy', $item->ID_Penjualan) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-white/10 text-[#B04025] hover:bg-white hover:text-white shadow-sm transition-all" title="Hapus Data">
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
                <i class="fas fa-receipt text-slate-300 text-3xl"></i>
            </div>
            <h3 class="text-slate-800 font-bold text-base">Riwayat Penjualan Kosong</h3>
            <p class="text-slate-400 text-sm mt-1">Belum ada transaksi penjualan yang tercatat hari ini.</p>
        </div>
    </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-slate-50">
 {{ $penjualans->links() }}
 </div>
</div>
@endsection
