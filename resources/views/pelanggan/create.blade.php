@extends('layouts.app')

@section('title', 'Input Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Daftar Pelanggan Baru</h2>
        </div>
        <form action="{{ route('input.pelanggan') }}" method="POST" class="p-8 space-y-4" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nama Pelanggan <span class="text-[#B04025]">*</span></label>
                <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('Nama_Pelanggan') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                @error('Nama_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">No. HP Pelanggan <span class="text-[#B04025]">*</span></label>
                <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('NoTelp_Pelanggan') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                @error('NoTelp_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Alamat Pelanggan <span class="text-[#B04025]">*</span></label>
                <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('Alamat_Pelanggan') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>{{ old('Alamat_Pelanggan') }}</textarea>
                @error('Alamat_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('data.pelanggan') }}" class="bg-slate-50 text-slate-500 border border-slate-200 font-bold rounded-xl px-8 py-3 text-sm hover:bg-slate-100 transition-all">Batal</a>
                <button type="submit" 
                    :disabled="isSubmitting" 
                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed scale-[0.98]' : ''"
                    class="bg-[#3B8A7F] text-white font-black rounded-xl px-10 py-3 text-sm hover:bg-white shadow-lg shadow-[#3B8A7F]/25 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    <span x-show="!isSubmitting">Simpan Data</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                        Mohon Tunggu... <i class="fas fa-circle-notch fa-spin ml-2"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
