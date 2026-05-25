@extends('layouts.app')

@section('title', 'Input Pemasok')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Pendaftaran Pemasok Baru</h2>
 <p class="text-slate-500 text-sm mt-1">Tambahkan informasi mitra pemasok barang untuk inventaris Xyra.id.</p>
 </div>
 <form action="{{ route('input.pemasok') }}" method="POST" class="p-8 space-y-6">
 @csrf
 
 <div class="space-y-2">
    <label class="block text-xs font-semibold text-slate-500">Nama Lengkap Pemasok <span class="text-red-500">*</span></label>
    <input type="text" name="Nama_Pemasok" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="Masukkan nama PT atau CV" required>
 </div>

 <div class="space-y-2">
    <label class="block text-xs font-semibold text-slate-500">No. HP Pemasok <span class="text-red-500">*</span></label>
    <input type="text" name="NoTelp_Pemasok" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="08xxxxxxxx" required>
 </div>

 <div class="space-y-2">
    <label class="block text-xs font-semibold text-slate-500">Alamat Lengkap Pemasok <span class="text-red-500">*</span></label>
    <textarea name="Alamat_Pemasok" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" placeholder="Masukkan alamat lengkap kantor/gudang" required></textarea>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
    <a href="{{ route('data.pemasok') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl hover:bg-slate-200 transition-all px-6 py-3 text-sm">Batal</a>
    <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Data</button>
 </div>
 </form>
 </div>
</div>
@endsection
