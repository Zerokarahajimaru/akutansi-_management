@extends('layouts.app')

@section('title', 'Input Pemasok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Pendaftaran Pemasok Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Tambahkan informasi mitra pemasok barang untuk inventaris Xyra.id.</p>
        </div>
        <form action="{{ route('input.pemasok') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap Pemasok <span class="text-red-500">*</span></label>
                <input type="text" name="Nama_Pemasok" value="{{ old('Nama_Pemasok') }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Nama_Pemasok') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Masukkan nama PT atau CV" required>
                @error('Nama_Pemasok')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">No. HP Pemasok <span class="text-red-500">*</span></label>
                <input type="text" name="NoTelp_Pemasok" value="{{ old('NoTelp_Pemasok') }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('NoTelp_Pemasok') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="08xxxxxxxx" required>
                @error('NoTelp_Pemasok')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Lengkap Pemasok <span class="text-red-500">*</span></label>
                <textarea name="Alamat_Pemasok" rows="3" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Alamat_Pemasok') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" placeholder="Masukkan alamat lengkap kantor/gudang" required>{{ old('Alamat_Pemasok') }}</textarea>
                @error('Alamat_Pemasok')
                    <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.pemasok') }}" class="px-6 py-3 bg-slate-50 text-slate-400 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-100 hover:text-slate-600 transition-all">Batal</a>
                <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 active:scale-95 transition-all">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
