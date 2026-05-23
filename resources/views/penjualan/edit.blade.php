@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Transaksi Penjualan</h2>
 <p class="text-gray-500 text-sm mt-1">Perbarui informasi transaksi stok keluar.</p>
 </div>

 <form action="{{ route('data.penjualan.update', $penjualan->ID_Penjualan) }}" method="POST" class="p-8 space-y-6">
 @csrf
 @method('PUT')
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Barang -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Pilih Barang</label>
 <select name="ID_Barang" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 @foreach($barangs as $barang)
 <option value="{{ $barang->ID_Barang }}" {{ $penjualan->ID_Barang === $barang->ID_Barang ? 'selected' : '' }}>{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})</option>
 @endforeach
 </select>
 </div>

 <!-- Pelanggan -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Pelanggan</label>
 <select name="ID_Pelanggan" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 @foreach($pelanggans as $pelanggan)
 <option value="{{ $pelanggan->ID_Pelanggan }}" {{ $penjualan->ID_Pelanggan === $pelanggan->ID_Pelanggan ? 'selected' : '' }}>{{ $pelanggan->Nama_Pelanggan }}</option>
 @endforeach
 </select>
 </div>

 <!-- Tanggal -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Tanggal Penjualan</label>
 <input type="date" name="Tanggal_Penjualan" value="{{ old('Tanggal_Penjualan', \Carbon\Carbon::parse($penjualan->Tanggal_Penjualan)->format('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Kuantitas -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Kuantitas</label>
 <input type="number" name="Kuantitas" value="{{ old('Kuantitas', $penjualan->Kuantitas) }}" placeholder="0" min="1" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Jenis Pembayaran -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Jenis Pembayaran</label>
 <select name="Jenis_Pembayaran" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 <option value="Tunai" {{ $penjualan->Jenis_Pembayaran === 'Tunai' ? 'selected' : '' }}>Tunai</option>
 <option value="Transfer" {{ $penjualan->Jenis_Pembayaran === 'Transfer' ? 'selected' : '' }}>Transfer</option>
 <option value="Qris" {{ $penjualan->Jenis_Pembayaran === 'Qris' ? 'selected' : '' }}>Qris</option>
 </select>
 </div>

 <!-- Ongkir -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Ongkir (Rp)</label>
 <input type="number" name="Ongkir" value="{{ old('Ongkir', $penjualan->Ongkir) }}" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.penjualan') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Perbarui Penjualan</button>
 </div>
 </form>
 </div>
</div>
@endsection
