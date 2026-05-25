@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Edit Data Pelanggan</h2>
 </div>
 <form action="{{ route('data.pelanggan.update', $pelanggan->ID_Pelanggan) }}" method="POST" class="p-8 space-y-4">
 @csrf
 @method('PUT')
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">ID Pelanggan</label>
 <input type="text" value="{{ $pelanggan->ID_Pelanggan }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 cursor-not-allowed" readonly>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
 <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan', $pelanggan->Nama_Pelanggan) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">No. HP Pelanggan <span class="text-red-500">*</span></label>
 <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan', $pelanggan->NoTelp_Pelanggan) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-slate-500 mb-2">Alamat Pelanggan <span class="text-red-500">*</span></label>
 <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>{{ old('Alamat_Pelanggan', $pelanggan->Alamat_Pelanggan) }}</textarea>
 </div>
 <div class="pt-4 flex justify-end space-x-3">
 <a href="{{ route('data.pelanggan') }}" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-200 border border-slate-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black rounded-xl text-sm hover:bg-teal-700 shadow-lg shadow-teal-500/30 transition-all hover:-translate-y-0.5">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
