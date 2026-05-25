@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100">
 <!-- Action Bar -->
 <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-slate-800 text-lg">Daftar Pengguna Sistem</h2>
 <p class="text-slate-500 text-xs">Kelola akun Admin yang memiliki akses ke aplikasi Xyra.id</p>
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

 <a href="{{ route('util.export', 'user') }}" class="flex items-center px-4 py-2 bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl text-xs hover:bg-slate-200 transition-all">
 <i class="fas fa-file-export mr-2"></i> Ekspor Excel
 </a>
 <a href="{{ route('input.user') }}" wire:navigate class="flex items-center px-4 py-2 bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 text-xs">
 <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table id="user-table" class="w-full text-left">
 <thead>
 @php
    $currentSortBy = request('sort_by', 'name');
    $currentSortDir = request('sort_dir', 'asc');
 @endphp
 <tr class="bg-slate-50/80 backdrop-blur-sm text-slate-500 text-xs font-bold uppercase tracking-wider">
 <th class="py-4 px-6">ID Pengguna</th>
 @php $newDir = ($currentSortBy === 'name' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Nama Lengkap
        <i class="fas {{ $currentSortBy === 'name' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-slate-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'username' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'username', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Username
        <i class="fas {{ $currentSortBy === 'username' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-slate-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6">Nomor Telepon</th>
 <th class="py-4 px-6">Alamat</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-50">
 @forelse($users as $user)
 <tr class="hover:bg-slate-50/50 transition-all">
 <td class="py-4 px-6 text-sm text-teal-600 font-bold uppercase tracking-tighter">{{ $user->id }}</td>
 <td class="py-4 px-6 text-sm font-bold text-slate-800">{{ $user->name }}</td>
 <td class="py-4 px-6 text-sm text-slate-600 font-medium"><span>{{ $user->username }}</span></td>
 <td class="py-4 px-6 text-sm text-slate-600 italic">{{ $user->NoTelp_User ?? '-' }}</td>
 <td class="py-4 px-6 text-sm text-slate-500 leading-relaxed">{{ $user->Alamat_User ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
    <div class="flex justify-center items-center">
        @if(auth()->id() === $user->id)
            <a href="{{ route('data.user.edit', $user->id) }}" wire:navigate class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-teal-600 hover:bg-teal-600 hover:text-white shadow-sm transition-all" title="Ubah Data">
                <i class="fas fa-edit text-xs"></i>
            </a>
        @else
            <span class="text-[10px] text-slate-400 font-medium italic">-</span>
        @endif
    </div>
 </td>
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="6" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm">
 <i class="fas fa-users-gear text-slate-300 text-3xl"></i>
 </div>
 <h3 class="text-slate-800 font-bold text-base">Pengguna Tidak Ditemukan</h3>
 <p class="text-slate-400 text-sm mt-1">Belum ada akun pengguna lain yang terdaftar di sistem.</p>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-slate-50">
 {{ $users->links() }}
 </div>
</div>
@endsection
