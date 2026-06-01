@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="text-xl font-black text-slate-800 tracking-tight">Tambah Pengguna</h2>
 <p class="text-slate-500 text-sm mt-1">Buat akun untuk akses sistem.</p>
 </div>

 <form action="{{ route('input.user') }}" method="POST" class="p-8 space-y-6" autocomplete="off">
 @csrf
 
 @if(session('error'))
 <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="space-y-4">
 <!-- Nama Lengkap -->
 <div class="space-y-2">
 <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nama Lengkap <span class="text-rose-500">*</span></label>
 <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 @error('name') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Nama Lengkap" required autocomplete="off">
 @error('name')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Username <span class="text-rose-500">*</span></label>
 <input type="text" name="username" value="{{ old('username') }}" autocomplete="off" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 @error('username') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="username_login" required>
 @error('username')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Hak Akses (Role) <span class="text-rose-500">*</span></label>
 <input type="hidden" name="role" value="{{ old('role', 'admin') }}">
 <input type="text" value="Admin" class="w-full bg-slate-50 border border-slate-100 text-slate-400 rounded-xl px-4 py-3 text-sm cursor-not-allowed" disabled>
 @error('role')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 </div>

 <!-- Password -->
 <div x-data="{ showPassword: false }" class="space-y-2">
    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Password Akses <span class="text-rose-500">*</span></label>
    <div class="relative">
        <input :type="showPassword ? 'text' : 'password'" name="password" autocomplete="new-password" value="" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 pr-12 @error('password') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Masukkan password baru" required>
        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
        </button>
    </div>
    @error('password')
    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
    @enderror
 </div>

 <!-- No Telp -->
 <div class="space-y-2">
 <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nomor Telepon <span class="text-rose-500">*</span></label>
 <input type="text" name="NoTelp_User" value="{{ old('NoTelp_User') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 @error('NoTelp_User') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="08xxxx" required>
 @error('NoTelp_User')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="bg-slate-50 text-slate-500 border border-slate-200 font-bold rounded-xl px-8 py-3 text-sm hover:bg-slate-100 transition-all">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl px-10 py-3 text-sm hover:bg-teal-700 shadow-lg shadow-teal-500/20 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">Simpan Data</button>
 </div>
 </form>
 </div>
</div>
@endsection
