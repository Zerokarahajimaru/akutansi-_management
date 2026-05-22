@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Edit Pengguna</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi akun untuk akses sistem.</p>
        </div>

        <form action="{{ route('data.user.update', $user->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
                {{ session('error') }}
            </div>
            @endif

            <div class="space-y-4">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Nama Lengkap" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hak Akses (Role)</label>
                        <select name="role" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                            <option value="pegawai" {{ $user->role === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••">
                </div>

                <!-- No Telp -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor Telepon</label>
                    <input type="text" name="NoTelp_User" value="{{ old('NoTelp_User', $user->admin->NoTelp_Admin ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="08xxxx">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.user') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
