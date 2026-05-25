@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50">
 <h2 class="font-bold text-slate-800 text-xl">Edit Transaksi Penjualan</h2>
 <p class="text-slate-500 text-sm mt-1">Perbarui informasi transaksi stok keluar.</p>
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
 <!-- ID Penjualan -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">ID Penjualan</label>
 <input type="text" value="{{ $penjualan->ID_Penjualan }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 cursor-not-allowed" readonly>
 </div>

 <!-- Barang -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '{{ old('ID_Barang', $penjualan->ID_Barang) }}', 
 selectedLabel: '{{ $barangs->firstWhere('ID_Barang', old('ID_Barang', $penjualan->ID_Barang))->Nama_Barang ?? '-- Pilih Produk --' }} ({{ $barangs->firstWhere('ID_Barang', old('ID_Barang', $penjualan->ID_Barang))->Ukuran_Barang ?? '' }})',
 options: [
 @foreach($barangs as $barang)
 {val: '{{ $barang->ID_Barang }}', label: '{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})'},
 @endforeach
 ]
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Pilih Produk</label>
 <div class="relative">
 <input type="hidden" name="ID_Barang" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 flex items-center justify-between">
 <span x-text="selectedLabel" :class="selected === '' ? 'text-slate-400' : 'text-slate-700 font-medium'"></span>
 <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option.val">
 <div @click="selected = option.val; selectedLabel = option.label; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
 :class="selected === option.val ? 'text-teal-600 font-bold' : ''">
 <span x-text="option.label"></span>
 <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Pelanggan -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '{{ old('ID_Pelanggan', $penjualan->ID_Pelanggan) }}', 
 selectedLabel: '{{ $pelanggans->firstWhere('ID_Pelanggan', old('ID_Pelanggan', $penjualan->ID_Pelanggan))->Nama_Pelanggan ?? '-- Pilih Pelanggan --' }}',
 options: [
 @foreach($pelanggans as $pelanggan)
 {val: '{{ $pelanggan->ID_Pelanggan }}', label: '{{ $pelanggan->Nama_Pelanggan }}'},
 @endforeach
 ]
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Pelanggan</label>
 <div class="relative">
 <input type="hidden" name="ID_Pelanggan" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 flex items-center justify-between">
 <span x-text="selectedLabel" :class="selected === '' ? 'text-slate-400' : 'text-slate-700 font-medium'"></span>
 <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option.val">
 <div @click="selected = option.val; selectedLabel = option.label; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
 :class="selected === option.val ? 'text-teal-600 font-bold' : ''">
 <span x-text="option.label"></span>
 <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Tanggal -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Tanggal Penjualan</label>
 <input type="date" name="Tanggal_Penjualan" value="{{ old('Tanggal_Penjualan', \Carbon\Carbon::parse($penjualan->Tanggal_Penjualan)->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>

 <!-- Kuantitas -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Kuantitas Penjualan</label>
 <input type="number" name="Kuantitas" value="{{ old('Kuantitas', $penjualan->Kuantitas) }}" placeholder="0" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>

 <!-- Jenis Pembayaran -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '{{ old('Jenis_Pembayaran', $penjualan->Jenis_Pembayaran) }}',
 options: ['Tunai', 'Transfer', 'Qris']
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Jenis Pembayaran</label>
 <div class="relative">
 <input type="hidden" name="Jenis_Pembayaran" :value="selected">
 <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 flex items-center justify-between">
 <span x-text="selected" class="text-slate-700 font-medium"></span>
 <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option">
 <div @click="selected = option; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
 :class="selected === option ? 'text-teal-600 font-bold' : ''">
 <span x-text="option"></span>
 <i x-show="selected === option" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Ongkir -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Ongkos Kirim (Rp)</label>
 <input type="number" name="Ongkir" value="{{ old('Ongkir', $penjualan->Ongkir) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.penjualan') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl px-6 py-3 text-sm hover:bg-slate-200 transition-all">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
