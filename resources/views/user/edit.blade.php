@extends('layouts.app')

@section('title', 'Ubah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Ubah Pengguna</h2>
 <p class="text-slate-500 text-sm mt-1">Perbarui informasi akun untuk akses sistem.</p>
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
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Lengkap</label>
 <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('name') border-red-500 @enderror" placeholder="Nama Lengkap" required>
 @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Username (Permanen)</label>
 <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-400 cursor-not-allowed" readonly title="Username tidak dapat diubah">
 @error('username') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Hak Akses (Role)</label>
 <input type="hidden" name="role" value="admin">
 <input type="text" value="Admin" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 cursor-not-allowed" disabled>
 </div>
 </div>

 <!-- Password -->
 <div x-data="{ showPassword: false }" class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
 <div class="relative">
 <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 pr-12 @error('password') border-red-500 @enderror" placeholder="••••••••">
 <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
 <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
 </button>
 </div>
 @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
 </div>

 <!-- No Telp -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nomor Telepon</label>
 <input type="text" name="NoTelp_User" value="{{ old('NoTelp_User', $user->NoTelp_User) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('NoTelp_User') border-red-500 @enderror" placeholder="08xxxx">
 @error('NoTelp_User') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
 </div>

 <!-- Alamat -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat Lengkap</label>
 <textarea name="Alamat_User" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('Alamat_User') border-red-500 @enderror" placeholder="Alamat lengkap...">{{ old('Alamat_User', $user->Alamat_User) }}</textarea>
 @error('Alamat_User') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-200 border border-slate-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black rounded-xl text-sm hover:bg-teal-700 shadow-lg shadow-teal-500/30 transition-all hover:-translate-y-0.5">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
