@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Daftar Pengguna Sistem</h2>
 <p class="text-gray-500 text-xs">Kelola akun Admin dan Pegawai yang memiliki akses ke aplikasi</p>
 </div>
 <div class="flex flex-wrap items-center gap-2">
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
 <a href="{{ route('util.export', 'user') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 @if(Auth::user()->role === 'admin')
 <a href="{{ route('input.user') }}" wire:navigate.hover class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
 </a>
 @endif
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
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 @php $newDir = ($currentSortBy === 'name' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Nama Pengguna
        <i class="fas {{ $currentSortBy === 'name' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'username' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'username', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Username
        <i class="fas {{ $currentSortBy === 'username' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 @php $newDir = ($currentSortBy === 'role' && $currentSortDir === 'asc') ? 'desc' : 'asc'; @endphp
 <th class="py-4 px-6 cursor-pointer group" onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort_by' => 'role', 'sort_dir' => $newDir, 'page' => 1]) }}'">
    <div class="flex items-center">
        Role
        <i class="fas {{ $currentSortBy === 'role' ? ($currentSortDir === 'asc' ? 'fa-sort-up text-teal-600' : 'fa-sort-down text-teal-600') : 'fa-sort text-gray-300' }} text-[10px] ml-auto group-hover:text-teal-500 transition-colors"></i>
    </div>
 </th>
 <th class="py-4 px-6">
    <div class="flex items-center text-gray-400">
        No. Telepon
    </div>
 </th>
 @if(Auth::user()->role === 'admin')
 <th class="py-4 px-6 text-center">Aksi</th>
 @endif
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($users as $user)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6">
 <div class="flex items-center">
 <img class="h-8 w-8 rounded-lg mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=6366f1&background=e0e7ff&bold=true" alt="">
 <div>
 <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
 <p class="text-xs text-gray-400 font-medium italic">Role: {{ ucfirst($user->role) }}</p>
 </div>
 </div>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ $user->username }}</td>
 <td class="py-4 px-6">
 <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-teal-50 text-teal-600 border border-teal-100' : 'bg-gray-50 text-gray-600 border border-gray-100' }}">
 {{ $user->role }}
 </span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ $user->admin->NoTelp_Admin ?? '-' }}</td>
 @if(Auth::user()->role === 'admin' || Auth::user()->id === $user->id)
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.user.edit', $user->id) }}" wire:navigate.hover class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 @if(Auth::user()->role === 'admin' && Auth::user()->id !== $user->id)
 <form action="{{ route('data.user.destroy', $user->id) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 @endif
 </div>
 </td>
 @else
 <td class="py-4 px-6 text-center text-gray-300 italic text-xs">Locked</td>
 @endif
 </tr>
 @empty
 <tr class="empty-state">
 <td colspan="5" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
 <i class="fas fa-users-gear text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Pengguna Tidak Ditemukan</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Belum ada akun pengguna lain yang terdaftar di sistem.</p>
 @if(Auth::user()->role === 'admin')
 <a href="{{ route('input.user') }}" wire:navigate.hover class="mt-4 text-teal-600 text-xs font-bold hover:underline">Buat Akun Baru</a>
 @endif
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 <div class="px-6 py-4 border-t border-gray-50">
 {{ $users->links() }}
 </div>
</div>
@endsection
