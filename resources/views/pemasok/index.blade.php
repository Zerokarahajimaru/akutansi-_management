@extends('layouts.app')

@section('title', 'Data Pemasok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Daftar Pemasok</h2>
 <p class="text-gray-500 text-xs">Kelola data mitra penyuplai barang</p>
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
 <form id="import-form" action="{{ route('util.import', 'pemasok') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'pemasok') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'pemasok') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.pemasok') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-truck-field mr-2"></i> Tambah Pemasok
 </a>
 </div>
 </div>
 <div class="overflow-x-auto">
 <table id="pemasok-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'Nama_Pemasok');
    $currentSortDir = request('sort_dir', 'asc');
 @endphp
 <tr class="bg-gray-50/50 text-gray-500 text-sm border-b border-gray-100">
 @php $newDir = ($currentSortBy === 'Nama_Pemasok' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Nama_Pemasok', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Nama
        <i class="fas {{ $currentSortBy === 'Nama_Pemasok' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'Alamat_Pemasok' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'Alamat_Pemasok', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Alamat
        <i class="fas {{ $currentSortBy === 'Alamat_Pemasok' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'NoTelp_Pemasok' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'NoTelp_Pemasok', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        No. HP
        <i class="fas {{ $currentSortBy === 'NoTelp_Pemasok' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($pemasoks as $p)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm font-bold">{{ $p->Nama_Pemasok }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $p->Alamat_Pemasok }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $p->NoTelp_Pemasok }}</td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pemasok.edit', $p->ID_Pemasok) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pemasok.destroy', $p->ID_Pemasok) }}" method="POST">
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
 <td colspan="4" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
 <i class="fas fa-truck-field text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Belum Ada Pemasok</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Daftar mitra pemasok Anda akan muncul di sini.</p>
 <a href="{{ route('input.pemasok') }}" wire:navigate.hover class="mt-4 text-teal-600 text-xs font-bold hover:underline">Tambah Pemasok Baru</a>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-gray-50">
 {{ $pemasoks->links() }}
 </div>
</div>
@endsection
