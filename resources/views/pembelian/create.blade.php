@extends('layouts.app')

@section('title', 'Input Pembelian')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-8 border-b border-gray-50">
 <h2 class="font-bold text-gray-800 text-xl">Catat Pembelian Baru</h2>
 <p class="text-gray-500 text-sm mt-1">Gunakan formulir ini untuk menambah stok barang dari pemasok.</p>
 </div>

 <form action="{{ route('input.pembelian') }}" method="POST" class="p-8 space-y-6">
 @csrf
 
 @if(session('error'))
 <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
 {{ session('error') }}
 </div>
 @endif

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <!-- Barang -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '', 
 selectedLabel: '-- Pilih Produk --',
 options: [
 @foreach($barangs as $barang)
 {val: '{{ $barang->ID_Barang }}', label: '{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})'},
 @endforeach
 ]
 }">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Pilih Barang</label>
 <div class="relative">
 <input type="hidden" name="ID_Barang" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-teal-500 transition-all">
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
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
 :class="selected === option.val ? 'bg-teal-50 text-teal-600 font-bold' : 'text-gray-600 hover:bg-gray-50'">
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
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Pemasok</label>
 <div class="relative">
 <input type="hidden" name="ID_Pemasok" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-teal-500 transition-all">
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
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
 :class="selected === option.val ? 'bg-teal-50 text-teal-600 font-bold' : 'text-gray-600 hover:bg-gray-50'">
 <span x-text="option.label"></span>
 <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Tanggal -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Tanggal Pembelian</label>
 <input type="date" name="Tgl_Pembelian" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>

 <!-- Kuantitas -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Kuantitas</label>
 <input type="number" name="Kuantitas" placeholder="0" min="1" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>

 <!-- Jenis Pembayaran -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: 'Tunai',
 options: ['Tunai', 'Transfer', 'Kredit']
 }">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Jenis Pembayaran</label>
 <div class="relative">
 <input type="hidden" name="Jenis_Pembayaran" :value="selected">
 <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-teal-500 transition-all">
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
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
 :class="selected === option ? 'bg-teal-50 text-teal-600 font-bold' : 'text-gray-600 hover:bg-gray-50'">
 <span x-text="option"></span>
 <i x-show="selected === option" class="fas fa-check text-xs"></i>
 </div>
 </template>
 </div>
 </div>
 </div>

 <!-- Ongkir -->
 <div class="space-y-2">
 <label class="text-sm font-semibold text-gray-700 mb-1.5">Ongkir (Rp)</label>
 <input type="number" name="Ongkir" value="0" min="0" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 transition-all" required>
 </div>
 </div>

 <div class="pt-6 border-t border-gray-50 flex justify-end space-x-3">
 <a href="{{ route('data.pembelian') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm hover:bg-gray-200 transition-colors">Batal</a>
 <button type="submit" class="px-10 py-3 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-200">Simpan Transaksi</button>
 </div>
 </form>
 </div>
</div>
@endsection
