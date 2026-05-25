@extends('layouts.app')

@section('title', 'Ubah Data Produk')

@section('content')
<div class="max-w-4xl mx-auto">
 <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
 <div class="p-8 border-b border-slate-50 flex justify-between items-center">
    <div>
        <h2 class="font-bold text-slate-800 text-xl">Edit Informasi Produk</h2>
        <p class="text-slate-500 text-sm mt-1">Perbarui detail teknis dan harga produk katalog.</p>
    </div>
    <div class="text-right">
        <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400">ID Barang</span>
        <span class="text-sm font-mono font-bold text-teal-600">{{ $barang->ID_Barang }}</span>
    </div>
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
 <label class="block text-xs font-semibold text-slate-500 mb-2">Nama Lengkap Produk <span class="text-red-500">*</span></label>
 <input type="text" name="Nama_Barang" value="{{ old('Nama_Barang', $barang->Nama_Barang) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>

 <!-- Jenis -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '{{ $barang->Jenis_Barang }}',
 options: ['Baju', 'Celana', 'Gamis', 'Aksesoris']
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Jenis / Kategori <span class="text-red-500">*</span></label>
 <div class="relative">
 <input type="hidden" name="Jenis_Barang" :value="selected">
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

 <!-- Ukuran -->
 <div class="space-y-2" x-data="{ 
 open: false, 
 selected: '{{ $barang->Ukuran_Barang }}',
 options: [
 {val: 'S', label: 'S (Small)'},
 {val: 'M', label: 'M (Medium)'},
 {val: 'L', label: 'L (Large)'},
 {val: 'XL', label: 'XL (Extra Large)'},
 {val: 'XXL', label: 'XXL (Double XL)'},
 {val: 'All Size', label: 'All Size'}
 ]
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Ukuran <span class="text-red-500">*</span></label>
 <div class="relative">
 <input type="hidden" name="Ukuran_Barang" :value="selected">
 <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 flex items-center justify-between">
 <span x-text="options.find(o => o.val === selected).label" class="text-slate-700 font-medium"></span>
 <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <div x-show="open" @click.away="open = false" x-cloak 
 x-transition:enter="transition ease-out duration-100"
 x-transition:enter-start="opacity-0 scale-95"
 x-transition:enter-end="opacity-100 scale-100"
 class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
 <template x-for="option in options" :key="option.val">
 <div @click="selected = option.val; open = false" 
 class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
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
 selected: '{{ $barang->ID_Pemasok }}', 
 selectedLabel: '{{ $barang->pemasok->Nama_Pemasok ?? '-- Pilih Pemasok --' }}',
 options: [
 @foreach($pemasoks as $pemasok)
 {val: '{{ $pemasok->ID_Pemasok }}', label: '{{ $pemasok->Nama_Pemasok }}'},
 @endforeach
 ]
 }">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Pemasok Terkait <span class="text-red-500">*</span></label>
 <div class="relative">
 <input type="hidden" name="ID_Pemasok" :value="selected" required>
 <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300 flex items-center justify-between">
 <span x-text="selectedLabel" class="text-slate-700 font-medium"></span>
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

 <!-- Warna -->
 <div class="space-y-2">
    <label class="block text-xs font-semibold text-slate-500 mb-2">Varian Warna <span class="text-red-500">*</span></label>
    <input type="text" name="Warna_Barang" value="{{ old('Warna_Barang', $barang->Warna_Barang) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>

 <!-- Harga Beli -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Harga Beli Dasar (Rp) <span class="text-red-500">*</span></label>
 <input type="number" name="Harga_Beli" value="{{ old('Harga_Beli', $barang->Harga_Beli) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>

 <!-- Harga Jual -->
 <div class="space-y-2">
 <label class="block text-xs font-semibold text-slate-500 mb-2">Harga Jual Konsumen (Rp) <span class="text-red-500">*</span></label>
 <input type="number" name="Harga_Jual" value="{{ old('Harga_Jual', $barang->Harga_Jual) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-slate-300" required>
 </div>
 </div>

 <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
 <a href="{{ route('data.barang.list') }}" class="bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-xl px-6 py-3 text-sm hover:bg-slate-200 transition-all">Batal</a>
 <button type="submit" class="bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 px-10 py-3 text-sm">Simpan Perubahan</button>
 </div>
 </form>
 </div>
</div>
@endsection
