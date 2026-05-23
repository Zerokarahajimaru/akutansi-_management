@extends('layouts.app')

@section('title', 'Input Barang Baru')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Tambah Produk Ke Katalog</h2>
 <p class="text-gray-500 text-sm mt-1">Lengkapi informasi detail produk untuk ditambahkan ke sistem inventaris.</p>
 </div>

 <form action="{{ route('input.barang') }}" method="POST" class="p-8 space-y-6">
 @csrf
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Nama Barang -->
 <div class="md:col-span-2 space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Nama Lengkap Produk</label>
 <input type="text" name="Nama_Barang" placeholder="Contoh: Gamis Chino Premium" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Jenis -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: 'Baju',
 options: ['Baju', 'Celana', 'Gamis', 'Aksesoris']
 }">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Jenis / Kategori</label>
 <div class="relative">
 <input type="hidden" name="Jenis_Barang" :value="selected">
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300 flex items-center justify-between">
 <span x-text="selected" class="text-gray-700 font-medium"></span>
 <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option">
 <div @click="selected = option; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"
 :class="selected === option ? 'text-teal-600 font-bold' : ''">
 <span x-text="option"></span>
 <i x-show="selected === option" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Warna -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Warna</label>
 <input type="text" name="Warna_Barang" placeholder="Contoh: Kuning, Navy, Hitam" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Ukuran -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: 'M',
 options: [
 {val: 'S', label: 'S (Small)'},
 {val: 'M', label: 'M (Medium)'},
 {val: 'L', label: 'L (Large)'},
 {val: 'XL', label: 'XL (Extra Large)'},
 {val: 'XXL', label: 'XXL (Double XL)'},
 {val: 'All Size', label: 'All Size'}
 ]
 }">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Ukuran</label>
 <div class="relative">
 <input type="hidden" name="Ukuran_Barang" :value="selected">
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300 flex items-center justify-between">
 <span x-text="options.find(o => o.val === selected).label" class="text-gray-700 font-medium"></span>
 <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option.val">
 <div @click="selected = option.val; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"
 :class="selected === option.val ? 'text-teal-600 font-bold' : ''">
 <span x-text="option.label"></span>
 <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Pemasok -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '', 
 selectedLabel: '-- Pilih Pemasok --',
 options: [
 @foreach($pemasoks as $pemasok)
 {val: '{{ $pemasok->ID_Pemasok }}', label: '{{ $pemasok->Nama_Pemasok }}'},
 @endforeach
 ]
 }">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Pemasok Utama</label>
 <div class="relative">
 <input type="hidden" name="ID_Pemasok" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300 flex items-center justify-between">
 <span x-text="selectedLabel" :class="selected === '' ? 'text-gray-400' : 'text-gray-700 font-medium'"></span>
 <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option.val">
 <div @click="selected = option.val; selectedLabel = option.label; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"
 :class="selected === option.val ? 'text-teal-600 font-bold' : ''">
 <span x-text="option.label"></span>
 <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Harga Beli -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Harga Beli (Rp)</label>
 <input type="number" name="Harga_Beli" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Harga Jual -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Harga Jual (Rp)</label>
 <input type="number" name="Harga_Jual" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 </div>

 <!-- Stok Awal -->
 <div class="md:col-span-2 space-y-2">
 <label class="block text-xs font-semibold text-gray-500 mb-2">Stok Awal Inventaris</label>
 <input type="number" name="Stok_Awal" value="0" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300" required>
 <p class="text-xs text-gray-400">Stok ini akan dicatat sebagai saldo awal di tabel stok.</p>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.barang.list') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">Daftarkan Barang</button>
 </div>
 </form>
 </div>
</div>
@endsection
