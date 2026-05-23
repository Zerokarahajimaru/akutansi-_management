@extends('layouts.app')

@section('title', 'Edit Pembelian')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Edit Transaksi Pembelian</h2>
 <p class="text-gray-500 text-sm mt-1">Perbarui informasi transaksi stok masuk.</p>
 </div>

 <form action="{{ route('data.pembelian.update', $pembelian->ID_Pembelian) }}" method="POST" class="p-8 space-y-6">
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
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Pilih Barang</label>
 <select name="ID_Barang" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 @foreach($barangs as $barang)
 <option value="{{ $barang->ID_Barang }}" {{ $pembelian->ID_Barang === $barang->ID_Barang ? 'selected' : '' }}>{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})</option>
 @endforeach
 </select>
 </div>

 <!-- Pemasok -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Pemasok</label>
 <select name="ID_Pemasok" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 @foreach($pemasoks as $pemasok)
 <option value="{{ $pemasok->ID_Pemasok }}" {{ $pembelian->ID_Pemasok === $pemasok->ID_Pemasok ? 'selected' : '' }}>{{ $pemasok->Nama_Pemasok }}</option>
 @endforeach
 </select>
 </div>

 <!-- Tanggal -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Tanggal Pembelian</label>
 <input type="date" name="Tgl_Pembelian" value="{{ old('Tgl_Pembelian', \Carbon\Carbon::parse($pembelian->Tgl_Pembelian)->format('Y-m-d')) }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>

 <!-- Kuantitas -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Kuantitas</label>
 <input type="number" name="Kuantitas" value="{{ old('Kuantitas', $pembelian->Kuantitas) }}" placeholder="0" min="1" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>

 <!-- Jenis Pembayaran -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Jenis Pembayaran</label>
 <select name="Jenis_Pembayaran" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 <option value="Tunai" {{ $pembelian->Jenis_Pembayaran === 'Tunai' ? 'selected' : '' }}>Tunai</option>
 <option value="Transfer" {{ $pembelian->Jenis_Pembayaran === 'Transfer' ? 'selected' : '' }}>Transfer</option>
 <option value="Kredit" {{ $pembelian->Jenis_Pembayaran === 'Kredit' ? 'selected' : '' }}>Kredit</option>
 </select>
 </div>

 <!-- Ongkir -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Ongkir (Rp)</label>
 <input type="number" name="Ongkir" value="{{ old('Ongkir', $pembelian->Ongkir) }}" min="0" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.pembelian') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-200">Perbarui Transaksi</button>
 </div>
 </form>
 </div>
</div>
@endsection
