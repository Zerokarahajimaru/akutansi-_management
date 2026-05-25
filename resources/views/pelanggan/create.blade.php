@extends('layouts.app')

@section('title', 'Input Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Daftar Pelanggan Baru</h2>
 </div>
 <form action="{{ route('input.pelanggan') }}" method="POST" class="p-8 space-y-4">
 @csrf
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
 <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('Nama_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
 @error('Nama_Pelanggan')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">No. HP Pelanggan <span class="text-red-500">*</span></label>
 <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('NoTelp_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
 @error('NoTelp_Pelanggan')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat Pelanggan <span class="text-red-500">*</span></label>
 <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 @error('Alamat_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>{{ old('Alamat_Pelanggan') }}</textarea>
 @error('Alamat_Pelanggan')
 <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>
 <div class="pt-4 flex justify-end space-x-3">
 <a href="{{ route('data.pelanggan') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl hover:bg-slate-200 transition-all px-6 py-3 text-sm">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Data</button>
 </div>
 </form>
 </div>
</div>
@endsection
