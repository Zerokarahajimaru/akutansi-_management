@extends('layouts.app')

@section('title', 'Input Penjualan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Catat Penjualan Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mencatat transaksi penjualan ke pelanggan.</p>
        </div>

        <form action="{{ route('input.penjualan') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
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
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Barang</label>
                    <div class="relative">
                        <input type="hidden" name="ID_Barang" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-indigo-500 transition-all">
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
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
                                    :class="selected === option.val ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:bg-slate-50'">
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
                    selected: '', 
                    selectedLabel: '-- Pilih Pelanggan --',
                    options: [
                        @foreach($pelanggans as $pelanggan)
                        {val: '{{ $pelanggan->ID_Pelanggan }}', label: '{{ $pelanggan->Nama_Pelanggan }}'},
                        @endforeach
                    ]
                }">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</label>
                    <div class="relative">
                        <input type="hidden" name="ID_Pelanggan" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-indigo-500 transition-all">
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
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
                                    :class="selected === option.val ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:bg-slate-50'">
                                    <span x-text="option.label"></span>
                                    <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Penjualan</label>
                    <input type="date" name="Tanggal_Penjualan" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Kuantitas -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kuantitas</label>
                    <input type="number" name="Kuantitas" placeholder="0" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: 'Tunai',
                    options: ['Tunai', 'Transfer', 'Qris']
                }">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Pembayaran</label>
                    <div class="relative">
                        <input type="hidden" name="Jenis_Pembayaran" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-indigo-500 transition-all">
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
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
                                    :class="selected === option ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:bg-slate-50'">
                                    <span x-text="option"></span>
                                    <i x-show="selected === option" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Ongkir -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ongkir (Rp)</label>
                    <input type="number" name="Ongkir" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.penjualan') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-rose-600 text-white rounded-xl text-sm font-black hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Simpan Penjualan</button>
            </div>
        </form>
    </div>
</div>
@endsection
