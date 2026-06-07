@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(202,91,51,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="text-xl font-black text-[#000000] tracking-tight">Edit Data Pelanggan</h2>
        </div>
        <form action="{{ route('data.pelanggan.update', $pelanggan->ID_Pelanggan) }}" method="POST" class="p-8 space-y-4" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @method('PUT')
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">ID Pelanggan</label>
                <input type="text" value="{{ $pelanggan->ID_Pelanggan }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm text-slate-400 cursor-not-allowed font-bold" readonly>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nama Pelanggan <span class="text-[#B04025]">*</span></label>
                <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan', $pelanggan->Nama_Pelanggan) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Nama_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>
                @error('Nama_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">No. HP Pelanggan <span class="text-[#B04025]">*</span></label>
                <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan', $pelanggan->NoTelp_Pelanggan) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('NoTelp_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>
                @error('NoTelp_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Alamat Pelanggan <span class="text-[#B04025]">*</span></label>
                <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Alamat_Pelanggan') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" required>{{ old('Alamat_Pelanggan', $pelanggan->Alamat_Pelanggan) }}</textarea>
                @error('Alamat_Pelanggan')
                    <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('data.pelanggan') }}" class="bg-slate-50 text-slate-500 border border-slate-200 font-bold rounded-xl px-8 py-3 text-sm hover:bg-slate-100 transition-all">Batal</a>
                <button type="submit" 
                    :disabled="isSubmitting" 
                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed scale-[0.98]' : ''"
                    class="bg-[#ca5b33] text-white font-black rounded-xl px-10 py-3 text-sm hover:bg-[#B04025] shadow-lg shadow-[#ca5b33]/25 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 uppercase tracking-widest">
                    <span x-show="!isSubmitting">Simpan Perubahan</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                        Mohon Tunggu... <i class="fas fa-circle-notch fa-spin ml-2"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
