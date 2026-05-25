@extends('layouts.app')

@section('title', 'Edit Pemasok')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Edit Data Pemasok</h2>
 </div>
 <form action="{{ route('data.pemasok.update', $pemasok->ID_Pemasok) }}" method="POST" class="p-8 space-y-4">
 @csrf
 @method('PUT')
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">ID Pemasok</label>
 <input type="text" value="{{ $pemasok->ID_Pemasok }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 cursor-not-allowed" readonly>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Pemasok</label>
 <input type="text" name="Nama_Pemasok" value="{{ old('Nama_Pemasok', $pemasok->Nama_Pemasok) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">No. HP Pemasok</label>
 <input type="text" name="NoTelp_Pemasok" value="{{ old('NoTelp_Pemasok', $pemasok->NoTelp_Pemasok) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat Pemasok</label>
 <textarea name="Alamat_Pemasok" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>{{ old('Alamat_Pemasok', $pemasok->Alamat_Pemasok) }}</textarea>
 </div>
 <div class="pt-4 flex justify-end space-x-3">
 <a href="{{ route('data.pemasok') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl hover:bg-slate-200 transition-all px-6 py-3 text-sm">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
