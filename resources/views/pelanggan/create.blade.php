@extends('layouts.app')

@section('title', 'Input Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Daftar Pelanggan Baru</h2>
        </div>
        <form action="{{ route('input.pelanggan') }}" method="POST" class="p-8 space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
                <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan') }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Nama_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                @error('Nama_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">No. HP Pelanggan <span class="text-red-500">*</span></label>
                <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan') }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('NoTelp_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                @error('NoTelp_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Pelanggan <span class="text-red-500">*</span></label>
                <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Alamat_Pelanggan') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>{{ old('Alamat_Pelanggan') }}</textarea>
                @error('Alamat_Pelanggan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('data.pelanggan') }}" class="px-6 py-3 bg-slate-50 text-slate-400 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-100 hover:text-slate-600 transition-all">Batal</a>
                <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 active:scale-95 transition-all">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
