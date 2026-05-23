@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Pengguna</h2>
 <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun untuk akses sistem.</p>
 </div>

 <form action="{{ route('data.user.update', $user->id) }}" method="POST" class="p-8 space-y-6">
 @csrf
 @method('PUT')
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="space-y-4">
 <!-- Nama Lengkap -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nama Lengkap</label>
 <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="Nama Lengkap" required>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Username</label>
 <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Hak Akses (Role)</label>
 <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 <option value="pegawai" {{ $user->role === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
 <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
 </select>
 </div>
 </div>

 <!-- Password -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
 <input type="password" name="password" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="••••••••">
 </div>

 <!-- No Telp -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nomor Telepon</label>
 <input type="text" name="NoTelp_User" value="{{ old('NoTelp_User', $user->admin->NoTelp_Admin ?? '') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="08xxxx">
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Perbarui Akun</button>
 </div>
 </form>
 </div>
</div>
@endsection
