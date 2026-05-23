@extends('layouts.app')

@section('title', 'Edit Pemasok')

@section('content')
<div class="max-w-2xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Data Pemasok</h2>
 </div>
 <form action="{{ route('data.pemasok.update', $pemasok->ID_Pemasok) }}" method="POST" class="p-8 space-y-4">
 @csrf
 @method('PUT')
 <div>
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nama Pemasok</label>
 <input type="text" name="Nama_Pemasok" value="{{ old('Nama_Pemasok', $pemasok->Nama_Pemasok) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-gray-500 mb-2">No. HP</label>
 <input type="text" name="NoTelp_Pemasok" value="{{ old('NoTelp_Pemasok', $pemasok->NoTelp_Pemasok) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>
 <div>
 <label class="block text-xs font-semibold text-gray-500 mb-2">Alamat</label>
 <textarea name="Alamat_Pemasok" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>{{ old('Alamat_Pemasok', $pemasok->Alamat_Pemasok) }}</textarea>
 </div>
 <div class="pt-4 flex justify-end space-x-3">
 <a href="{{ route('data.pemasok') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Perbarui</button>
 </div>
 </form>
 </div>
</div>
@endsection
