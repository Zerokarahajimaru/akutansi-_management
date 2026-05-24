@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Tambah Pengguna</h2>
 <p class="text-gray-500 text-sm mt-1">Buat akun untuk akses sistem.</p>
 </div>

 <form action="{{ route('input.user') }}" method="POST" class="p-8 space-y-6" autocomplete="off">
 @csrf
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="space-y-4">
 <!-- Nama Lengkap -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
 <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="Nama Lengkap" required autocomplete="off">
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Username <span class="text-red-500">*</span></label>
 <input type="text" name="username" value="" autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="username_login" required>
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Hak Akses (Role) <span class="text-red-500">*</span></label>
 <input type="hidden" name="role" value="admin">
 <input type="text" value="Admin" class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 cursor-not-allowed" disabled>
 </div>
 </div>

 <!-- Password -->
 <div x-data="{ showPassword: false }" class="space-y-2">
    <label class="text-xs font-semibold text-gray-500 mb-2 block">Password Akses <span class="text-red-500">*</span></label>
    <div class="relative">
        <input :type="showPassword ? 'text' : 'password'" name="password" autocomplete="new-password" value="" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 pr-12" placeholder="Masukkan password baru" required>
        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-teal-600 focus:outline-none transition-colors">
            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
        </button>
    </div>
 </div>

 <!-- No Telp -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
 <input type="text" name="NoTelp_User" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" placeholder="08xxxx" required>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Simpan Data</button>
 </div>
 </form>
 </div>
</div>
@endsection
