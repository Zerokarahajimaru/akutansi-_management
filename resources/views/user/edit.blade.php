@extends('layouts.app')

@section('title', 'Ubah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Ubah Pengguna</h2>
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
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
 <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('name') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Nama Lengkap" required>
 @error('name')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <!-- Username -->
 <div class="space-y-2">
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Username (Permanen)</label>
 <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full bg-slate-50 border border-slate-100 text-slate-400 rounded-xl px-4 py-3 text-sm cursor-not-allowed" readonly title="Username tidak dapat diubah">
 @error('username')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <!-- Role -->
 <div class="space-y-2">
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Hak Akses (Role)</label>
 <input type="hidden" name="role" value="{{ old('role', 'admin') }}">
 <input type="text" value="Admin" class="w-full bg-slate-50 border border-slate-100 text-slate-400 rounded-xl px-4 py-3 text-sm cursor-not-allowed" disabled>
 @error('role')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 </div>

 <!-- Password -->
 <div x-data="{ showPassword: false }" class="space-y-2">
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
 <div class="relative">
 <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all pr-12 @error('password') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="••••••••">
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
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor Telepon</label>
 <input type="text" name="NoTelp_User" value="{{ old('NoTelp_User', $user->NoTelp_User) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('NoTelp_User') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="08xxxx">
 @error('NoTelp_User')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <!-- Alamat -->
 <div class="space-y-2">
 <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Alamat Lengkap</label>
 <textarea name="Alamat_User" rows="3" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Alamat_User') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Alamat lengkap...">{{ old('Alamat_User', $user->Alamat_User) }}</textarea>
 @error('Alamat_User')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.user') }}" class="px-8 py-3 bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black hover:bg-teal-700 shadow-lg shadow-teal-500/20 active:scale-95 transition-all rounded-xl text-xs uppercase tracking-widest">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
