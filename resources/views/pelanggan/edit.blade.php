@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="p-10 border-b border-slate-50 bg-slate-50/20">
            <h2 class="text-2xl font-black text-[#A98D66] tracking-tightest uppercase">Edit <span class="text-[#3B8A7F]">Pelanggan.</span></h2>
            <p class="text-slate-500 text-xs font-medium mt-1 leading-relaxed">Perbarui informasi mitra pelanggan Xyra.id</p>
        </div>
        <form action="{{ route('data.pelanggan.update', $pelanggan->ID_Pelanggan) }}" method="POST" class="p-10 space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 block">ID Pelanggan (Permanen)</label>
                <input type="text" value="{{ $pelanggan->ID_Pelanggan }}" class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4 text-sm text-slate-400 cursor-not-allowed font-bold" readonly>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 block">Nama Pelanggan <span class="text-[#B04025]">*</span></label>
                <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan', $pelanggan->Nama_Pelanggan) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-2xl px-5 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/15 focus:border-[#ca5b33] transition-all duration-300 @error('Nama_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>
                @error('Nama_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-2 ml-1 flex items-center animate-shake"><i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 block">Nomor HP Aktif <span class="text-[#B04025]">*</span></label>
                <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan', $pelanggan->NoTelp_Pelanggan) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-2xl px-5 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/15 focus:border-[#ca5b33] transition-all duration-300 @error('NoTelp_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>
                @error('NoTelp_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-2 ml-1 flex items-center animate-shake"><i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 block">Alamat Lengkap <span class="text-[#B04025]">*</span></label>
                <textarea name="Alamat_Pelanggan" rows="4" class="w-full bg-slate-50/50 border border-slate-200 rounded-2xl px-5 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/15 focus:border-[#ca5b33] transition-all duration-300 @error('Alamat_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>{{ old('Alamat_Pelanggan', $pelanggan->Alamat_Pelanggan) }}</textarea>
                @error('Alamat_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-2 ml-1 flex items-center animate-shake"><i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 flex items-center justify-end gap-4">
                <a href="{{ route('data.pelanggan') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-2xl px-8 py-4 text-xs uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95">Batal</a>
                <button type="submit" 
                    :disabled="isSubmitting" 
                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed scale-[0.98]' : ''"
                    class="bg-[#ca5b33] text-white font-black rounded-2xl px-12 py-4 text-xs uppercase tracking-widest hover:bg-[#B04025] shadow-xl shadow-[#ca5b33]/30 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    <span x-show="!isSubmitting">Simpan Perubahan</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                        Mohon Tunggu... <i class="fas fa-circle-notch fa-spin ml-3"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
