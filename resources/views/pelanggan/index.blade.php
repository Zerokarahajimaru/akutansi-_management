@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="space-y-8">
    <!-- Action Bar Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-[#A98D66] font-black tracking-tightest uppercase text-lg">Kelola Data Pelanggan</h2>
                    <p class="text-slate-500 text-xs font-medium">Daftar pelanggan aktif untuk transaksi penjualan Xyra.id</p>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row justify-between items-center gap-4 w-full">
                <form method="GET" action="" class="w-full sm:w-[320px] lg:w-[400px] flex-shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-magnifying-glass text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/15 focus:border-[#ca5b33] transition-all shadow-sm placeholder:text-slate-400" 
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
                        <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex items-center justify-between w-full sm:min-w-[140px] px-4 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-[#ca5b33] focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/15 transition-all shadow-sm group">
                            <span class="truncate">Tampilkan: <span class="text-[#ca5b33]">{{ request('per_page', 50) === 'all' ? 'Semua' : request('per_page', 50) }}</span></span>
                            <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-[#ca5b33]' : 'text-slate-400 group-hover:text-[#ca5b33]'"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute left-0 mt-2 w-full min-w-[140px] bg-white border border-slate-100 rounded-xl shadow-xl z-[100] py-1 overflow-hidden" style="display: none; top: 100%;">
                            @foreach([5, 10, 25, 50, 'all'] as $size)
                                <a href="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" wire:navigate class="block px-4 py-2 text-sm transition-all duration-200 {{ request('per_page', 50) == $size ? 'bg-slate-50 text-[#ca5b33] font-black border-l-4 border-[#ca5b33]' : 'text-slate-800 hover:bg-slate-50 hover:text-[#ca5b33] border-l-4 border-transparent' }}">
                                    {{ $size === 'all' ? 'Semua Data' : $size . ' Baris' }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Utility Toolbar -->
                    <div class="flex items-center bg-slate-100 border border-slate-200 rounded-xl shadow-sm w-full sm:w-auto divide-x divide-slate-200 overflow-hidden">
                        <a href="{{ route('util.template', 'pelanggan') }}" class="flex-1 lg:flex-none flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-[#ca5b33] transition-all" title="Unduh Template Excel">
                            <i class="fas fa-file-arrow-down mr-2 text-slate-400"></i> <span>Template</span>
                        </a>

                        <div x-data="{ openImport: false, isDragging: false, isSubmitting: false }" class="flex-1 lg:flex-none">
                            <button @click="openImport = true" class="w-full flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-[#ca5b33] transition-all" title="Impor Data Excel">
                                <i class="fas fa-file-import mr-2 text-[#A98D66]"></i> <span>Impor</span>
                            </button>
                            
                            <div x-show="openImport" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" x-transition.opacity>
                                <div @click.outside="openImport = false" class="bg-white rounded-3xl border border-slate-100 shadow-xl w-full max-w-md p-6 transform transition-all" x-transition.scale.95>
                                    <div class="flex justify-between items-center mb-5">
                                        <h3 class="text-lg font-black text-[#000000]">Impor Data Pelanggan</h3>
                                        <button @click="openImport = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                                            <i class="fas fa-xmark text-lg"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('util.import', 'pelanggan') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true" class="space-y-4">
                                        @csrf
                                        <div 
                                            class="relative group rounded-2xl transition-all duration-500 p-2 bg-slate-100 border border-slate-200"
                                            :class="isDragging ? 'bg-[#A98D66]/10 border-[#A98D66]/20 shadow-lg scale-[1.02]' : ''"
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; document.getElementById('fileNamePelanggan').textContent = $event.dataTransfer.files[0].name"
                                        >
                                            <div 
                                                class="border-2 border-dashed rounded-2xl p-10 text-center transition-all duration-300 relative overflow-hidden"
                                                :class="isDragging ? 'bg-white/50 border-[#A98D66]/40' : 'border-slate-300 group-hover:border-[#ca5b33]/30'"
                                            >
                                                <input 
                                                    type="file" 
                                                    name="csv_file" 
                                                    x-ref="fileInput"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                                    accept=".xlsx,.xls,.csv" 
                                                    required 
                                                    @change="document.getElementById('fileNamePelanggan').textContent = $event.target.files[0].name"
                                                >
                                                <div class="relative z-0">
                                                    <i class="fas fa-cloud-arrow-up text-3xl text-slate-800 mb-3 transition-transform duration-300 group-hover:-translate-y-1"></i>
                                                    <p class="text-sm font-bold text-slate-800">Silakan klik atau seret file Excel ke area ini</p>
                                                    <p class="text-[10px] text-slate-500 mt-1 uppercase font-black tracking-widest">Format yang didukung: .xlsx, .xls, .csv</p>
                                                    <p id="fileNamePelanggan" class="text-xs font-black text-[#ca5b33] mt-3 truncate"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2">
                                            <button type="button" @click="openImport = false" class="w-full sm:w-auto bg-slate-100 text-slate-800 border border-slate-200 font-bold rounded-xl hover:bg-slate-200 transition-all px-5 py-2.5 text-sm">Batal</button>
                                            <button type="submit" :disabled="isSubmitting" :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''" class="w-full sm:w-auto bg-[#ca5b33] text-white font-black rounded-2xl shadow-xl shadow-[#ca5b33]/25 hover:bg-[#B04025] hover:-translate-y-1 active:scale-95 transition-all duration-300 px-5 py-2.5 text-sm flex items-center justify-center group uppercase tracking-widest">
                                                <span x-show="!isSubmitting">Impor Saja</span>
                                                <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                                                    Memproses... <i class="fas fa-circle-notch fa-spin ml-2"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Ekspor Excel -->
                        <a href="{{ route('util.export', 'pelanggan') }}" class="flex-1 lg:flex-none flex items-center justify-center px-3 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-white hover:text-[#ca5b33] transition-all" title="Ekspor Data Excel">
                            <i class="fas fa-file-export mr-2 text-slate-400"></i> <span>Ekspor</span>
                        </a>
                    </div>

                    <a href="{{ route('input.pelanggan') }}" wire:navigate.hover class="w-full sm:w-auto bg-[#ca5b33] text-white font-black rounded-2xl shadow-xl shadow-[#ca5b33]/25 hover:bg-[#B04025] hover:-translate-y-1 active:scale-95 transition-all duration-300 px-6 py-3 text-[10px] uppercase tracking-widest flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative">
            <table id="pelanggan-table" class="w-full text-left border-separate border-spacing-0">
                <thead>
                    @php
                        $currentSortBy = request('sort_by', 'Nama_Pelanggan');
                        $currentSortDir = request('sort_dir', 'asc');
                    @endphp
                    <tr class="bg-[#B04025] text-white text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">
                        <th class="py-6 px-8 sticky left-0 bg-[#B04025] z-20 shadow-[4px_0_10px_-3px_rgba(0,0,0,0.2)] whitespace-nowrap">ID Pelanggan</th>
                        @php $newDir = ($currentSortBy === 'Nama_Pelanggan' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
                        <th class="py-6 px-8 cursor-pointer group whitespace-nowrap" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Nama_Pelanggan', 'sort_dir' => $newDir, 'page' => 1]) }}'">
                            <div class="flex items-center">
                                Nama Lengkap
                                <i class="fas {{ $currentSortBy === 'Nama_Pelanggan' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-white' : 'fa-sort-down text-white') : 'fa-sort text-white/30' }} text-[10px] ml-auto group-hover:text-white transition-colors"></i>
                            </div>
                        </th>
                        <th class="py-6 px-8 text-center whitespace-nowrap">Nomor Telepon</th>
                        <th class="py-6 px-8 whitespace-nowrap">Alamat Pelanggan</th>
                        <th class="py-6 px-8 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
 @forelse($pelanggans as $p)
 <tr class="group bg-white hover:bg-[#A98D66]/10 transition-all duration-200">
 <td class="py-5 px-8 text-sm text-[#000000] font-black uppercase sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0] transition-colors whitespace-nowrap">{{ $p->ID_Pelanggan ?? '-' }}</td>
 <td class="py-5 px-8 text-sm font-bold text-slate-800 max-w-xs truncate" title="{{ $p->Nama_Pelanggan ?? '' }}">{{ $p->Nama_Pelanggan ?? '-' }}</td>
 <td class="py-5 px-8 text-sm text-slate-800 text-center italic whitespace-nowrap">{{ $p->NoTelp_Pelanggan ?? '-' }}</td>
 <td class="py-5 px-8 text-sm text-slate-800 leading-relaxed max-w-sm truncate" title="{{ $p->Alamat_Pelanggan ?? '' }}">{{ $p->Alamat_Pelanggan ?? '-' }}</td>
 <td class="py-5 px-8 text-center whitespace-nowrap">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pelanggan.edit', $p->ID_Pelanggan) }}" wire:navigate class="flex items-center justify-center w-8 h-8 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#ca5b33] hover:text-white shadow-sm transition-all" title="Ubah Data">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pelanggan.destroy', $p->ID_Pelanggan) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-xl bg-slate-50 text-[#B04025] hover:bg-[#B04025] hover:text-white shadow-sm transition-all" title="Hapus Data">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="5" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm">
 <i class="fas fa-address-book text-slate-300 text-3xl"></i>
 </div>
 <h3 class="text-slate-800 font-bold text-base">Data Pelanggan Kosong</h3>
 <p class="text-slate-400 text-sm mt-1">Gunakan tombol di atas untuk mendaftarkan pelanggan baru.</p>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-slate-50">
 {{ $pelanggans->links() }}
 </div>
</div>
@endsection
