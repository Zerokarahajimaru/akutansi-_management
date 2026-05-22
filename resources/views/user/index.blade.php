@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Action Bar -->
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Daftar Pengguna Sistem</h2>
            <p class="text-slate-500 text-xs">Kelola akun Admin dan Pegawai yang memiliki akses ke aplikasi</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('util.export', 'user') }}" class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                <i class="fas fa-file-export mr-2"></i> Export
            </a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('input.user') }}" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
            </a>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest font-black">
                    <th class="py-4 px-6">Nama Pengguna</th>
                    <th class="py-4 px-6">Username</th>
                    <th class="py-4 px-6">Role</th>
                    <th class="py-4 px-6">No. Telepon</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="py-4 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-lg mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=6366f1&background=e0e7ff&bold=true" alt="">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium italic">Role: {{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $user->username }}</td>
                    <td class="py-4 px-6">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-50 text-slate-600 border border-slate-100' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $user->admin->NoTelp_Admin ?? '-' }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('data.user.edit', $user->id) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-50 text-orange-500 hover:bg-orange-500 hover:text-white transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('data.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-slate-400 italic text-sm">Belum ada data pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
