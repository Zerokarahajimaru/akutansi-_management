@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Tambah Pengguna</h2>
 <p class="text-slate-500 text-sm mt-1">Buat akun untuk akses sistem.</p>
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
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
 <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="Nama Lengkap" required autocomplete="off">
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Username <span class="text-red-500">*</span></label>
 <input type="text" name="username" value="" autocomplete="off" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="username_login" required>
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Hak Akses (Role) <span class="text-red-500">*</span></label>
 <input type="hidden" name="role" value="admin">
 <input type="text" value="Admin" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 cursor-not-allowed" disabled>
 </div>
 </div>

 <!-- Password -->
 <div x-data="{ showPassword: false }" class="space-y-2">
    <label class="text-xs font-semibold text-slate-500 mb-2 block">Password Akses <span class="text-red-500">*</span></label>
    <div class="relative">
        <input :type="showPassword ? 'text' : 'password'" name="password" autocomplete="new-password" value="" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 pr-12" placeholder="Masukkan password baru" required>
        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
        </button>
    </div>
 </div>

 <!-- No Telp -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
 <input type="text" name="NoTelp_User" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="08xxxx" required>
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl px-6 py-3 text-sm hover:bg-slate-200 transition-all">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Data</button>
 </div>
 </form>
 </div>
</div>
@endsection
