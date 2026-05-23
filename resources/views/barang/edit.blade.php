@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Produk</h2>
 <p class="text-gray-500 text-sm mt-1">Perbarui informasi detail produk.</p>
 </div>

 <form action="{{ route('data.barang.update', $barang->ID_Barang) }}" method="POST" class="p-8 space-y-6">
 @csrf
 @method('PUT')
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Nama Barang -->
 <div class="md:col-span-2 space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nama Lengkap Produk</label>
 <input type="text" name="Nama_Barang" value="{{ old('Nama_Barang', $barang->Nama_Barang) }}" placeholder="Contoh: Gamis Chino Premium" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Jenis -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Jenis / Kategori</label>
 <select name="Jenis_Barang" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 <option value="Baju" {{ $barang->Jenis_Barang === 'Baju' ? 'selected' : '' }}>Baju</option>
 <option value="Celana" {{ $barang->Jenis_Barang === 'Celana' ? 'selected' : '' }}>Celana</option>
 <option value="Gamis" {{ $barang->Jenis_Barang === 'Gamis' ? 'selected' : '' }}>Gamis</option>
 <option value="Aksesoris" {{ $barang->Jenis_Barang === 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
 </select>
 </div>

 <!-- Warna -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Warna</label>
 <input type="text" name="Warna_Barang" value="{{ old('Warna_Barang', $barang->Warna_Barang) }}" placeholder="Contoh: Kuning, Navy, Hitam" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Ukuran -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Ukuran</label>
 <select name="Ukuran_Barang" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 <option value="S" {{ $barang->Ukuran_Barang === 'S' ? 'selected' : '' }}>S (Small)</option>
 <option value="M" {{ $barang->Ukuran_Barang === 'M' ? 'selected' : '' }}>M (Medium)</option>
 <option value="L" {{ $barang->Ukuran_Barang === 'L' ? 'selected' : '' }}>L (Large)</option>
 <option value="XL" {{ $barang->Ukuran_Barang === 'XL' ? 'selected' : '' }}>XL (Extra Large)</option>
 <option value="XXL" {{ $barang->Ukuran_Barang === 'XXL' ? 'selected' : '' }}>XXL (Double XL)</option>
 <option value="All Size" {{ $barang->Ukuran_Barang === 'All Size' ? 'selected' : '' }}>All Size</option>
 </select>
 </div>

 <!-- Pemasok -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Pemasok Utama</label>
 <select name="ID_Pemasok" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 @foreach($pemasoks as $pemasok)
 <option value="{{ $pemasok->ID_Pemasok }}" {{ $barang->ID_Pemasok === $pemasok->ID_Pemasok ? 'selected' : '' }}>{{ $pemasok->Nama_Pemasok }}</option>
 @endforeach
 </select>
 </div>

 <!-- Harga Beli -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Harga Beli (Rp)</label>
 <input type="number" name="Harga_Beli" value="{{ old('Harga_Beli', $barang->Harga_Beli) }}" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Harga Jual -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Harga Jual (Rp)</label>
 <input type="number" name="Harga_Jual" value="{{ old('Harga_Jual', $barang->Harga_Jual) }}" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.barang.list') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Perbarui Barang</button>
 </div>
 </form>
 </div>
</div>
@endsection
