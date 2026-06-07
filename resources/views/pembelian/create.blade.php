@extends('layouts.app')

@section('title', 'Input Pembelian')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(59,138,127,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="text-xl font-black text-[#ca5b33] tracking-tight">Catat Pembelian Baru</h2>
            <p class="text-slate-500 text-sm mt-1 font-medium">Gunakan formulir ini untuk menambah stok barang dari pemasok.</p>
        </div>

        <form action="{{ route('input.pembelian') }}" method="POST" class="p-8 space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
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
                    selected: '{{ old('ID_Barang') }}', 
                    selectedLabel: '{{ $barangs->firstWhere('ID_Barang', old('ID_Barang'))->Nama_Barang ?? '' }}{{ $barangs->firstWhere('ID_Barang', old('ID_Barang')) ? ' ('.$barangs->firstWhere('ID_Barang', old('ID_Barang'))->Ukuran_Barang.')' : '-- Pilih Produk --' }}',
                    options: [
                        @foreach($barangs as $barang)
                            {val: '{{ $barang->ID_Barang }}', label: '{{ $barang->Nama_Barang }} ({{ $barang->Ukuran_Barang }})'},
                        @endforeach
                    ]
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Pilih Produk <span class="text-[#B04025]">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="ID_Barang" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 flex items-center justify-between @error('ID_Barang') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                            <span x-text="selectedLabel" :class="selected === '' ? 'text-slate-400' : 'font-medium'"></span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
                            <template x-for="option in options" :key="option.val">
                                <div @click="selected = option.val; selectedLabel = option.label; open = false" 
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-[#A98D66]/10 hover:text-[#2F5C53] text-slate-800"
                                    :class="selected === option.val ? 'text-slate-800 font-bold' : ''">
                                    <span x-text="option.label"></span>
                                    <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('ID_Barang')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemasok -->
                <div class="space-y-2" x-init="$watch('selected', value => { window.dispatchEvent(new CustomEvent('pemasok-changed', { detail: value })) })" x-data="{ 
                    open: false, 
                    selected: '{{ old('ID_Pemasok') }}', 
                    selectedLabel: '{{ $pemasoks->firstWhere('ID_Pemasok', old('ID_Pemasok'))->Nama_Pemasok ?? '-- Pilih Pemasok --' }}',
                    options: [
                        @foreach($pemasoks as $pemasok)
                            {val: '{{ $pemasok->ID_Pemasok }}', label: '{{ $pemasok->Nama_Pemasok }}'},
                        @endforeach
                    ]
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Pemasok <span class="text-[#B04025]">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="ID_Pemasok" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 flex items-center justify-between @error('ID_Pemasok') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                            <span x-text="selectedLabel" :class="selected === '' ? 'text-slate-400' : 'font-medium'"></span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
                            <template x-for="option in options" :key="option.val">
                                <div @click="selected = option.val; selectedLabel = option.label; open = false" 
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-[#A98D66]/10 hover:text-[#2F5C53] text-slate-800"
                                    :class="selected === option.val ? 'text-slate-800 font-bold' : ''">
                                    <span x-text="option.label"></span>
                                    <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('ID_Pemasok')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Tanggal Pembelian <span class="text-[#B04025]">*</span></label>
                    <input type="date" name="Tgl_Pembelian" value="{{ old('Tgl_Pembelian', date('Y-m-d')) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('Tgl_Pembelian') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Tgl_Pembelian')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kuantitas -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Kuantitas Pembelian <span class="text-[#B04025]">*</span></label>
                    <input type="number" name="Kuantitas" value="{{ old('Kuantitas') }}" placeholder="0" min="1" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('Kuantitas') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Kuantitas')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Pembayaran -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('Jenis_Pembayaran', 'Tunai') }}',
                    options: ['Tunai', 'Transfer', 'Qris']
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Jenis Pembayaran</label>
                    <div class="relative">
                        <input type="hidden" name="Jenis_Pembayaran" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 flex items-center justify-between @error('Jenis_Pembayaran') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                            <span x-text="selected" class="font-medium"></span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
                            <template x-for="option in options" :key="option">
                                <div @click="selected = option; open = false" 
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-[#A98D66]/10 hover:text-[#2F5C53] text-slate-800"
                                    :class="selected === option ? 'text-slate-800 font-bold' : ''">
                                    <span x-text="option"></span>
                                    <i x-show="selected === option" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('Jenis_Pembayaran')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ongkir -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Ongkos Kirim (Rp) <span class="text-[#B04025]">*</span></label>
                    <input type="number" name="Ongkir" value="{{ old('Ongkir', '0') }}" min="0" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#3B8A7F]/10 focus:border-[#3B8A7F] transition-all duration-300 @error('Ongkir') border-rose-300 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Ongkir')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.pembelian') }}" class="bg-slate-50 text-slate-500 border border-slate-200 font-bold rounded-xl px-8 py-3 text-sm hover:bg-slate-100 transition-all">Batal</a>
                <button type="submit" 
                    :disabled="isSubmitting" 
                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed scale-[0.98]' : ''"
                    class="bg-[#ca5b33] text-white font-black rounded-xl px-10 py-3 text-sm hover:bg-[#B04025] shadow-lg shadow-[#ca5b33]/25 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 uppercase tracking-widest">
                    <span x-show="!isSubmitting">Simpan Data</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center justify-center">
                        Mohon Tunggu... <i class="fas fa-circle-notch fa-spin ml-2"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
