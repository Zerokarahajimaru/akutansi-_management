@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Data Pelanggan</h2>
 </div>
 <form action="{{ route('data.pelanggan.update', $pelanggan->ID_Pelanggan) }}" method="POST" class="p-8 space-y-4">
 @csrf
 @method('PUT')
 <div>
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Nama Pelanggan</label>
 <input type="text" name="Nama_Pelanggan" value="{{ old('Nama_Pelanggan', $pelanggan->Nama_Pelanggan) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300" required>
 </div>
 <div>
 <label class="text-sm font-semibold text-gray-700 mb-1.5">No. HP</label>
 <input type="text" name="NoTelp_Pelanggan" value="{{ old('NoTelp_Pelanggan', $pelanggan->NoTelp_Pelanggan) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300" required>
 </div>
 <div>
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
 <textarea name="Alamat_Pelanggan" rows="3" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300" required>{{ old('Alamat_Pelanggan', $pelanggan->Alamat_Pelanggan) }}</textarea>
 </div>
 <div class="pt-4 flex justify-end space-x-3">
 <a href="{{ route('data.pelanggan') }}" class="px-6 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">Batal</a>
 <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-xl text-sm font-semibold shadow-md shadow-teal-600/20 hover:bg-teal-700 hover:-translate-y-0.5 transition-all duration-300">Perbarui</button>
 </div>
 </form>
 </div>
</div>
@endsection
