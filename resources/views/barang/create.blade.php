@extends('layouts.app')

@section('title', 'Katalog Produk & Stok')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_20px_50px_rgba(59,138,127,0.05)] overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="text-xl font-black text-[#ca5b33] tracking-tight">Tambah Produk Ke Katalog</h2>
            <p class="text-slate-500 text-sm mt-1">Lengkapi informasi detail produk untuk ditambahkan ke sistem inventaris Xyra.id.</p>
        </div>

        <form action="{{ route('input.barang') }}" method="POST" class="p-8 space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            
            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nama Lengkap Produk <span class="text-[#B04025]">*</span></label>
                    <input type="text" name="Nama_Barang" value="{{ old('Nama_Barang') }}" placeholder="Contoh: Gamis Chino Premium" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Nama_Barang') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Nama_Barang')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('Jenis_Barang', 'Baju') }}',
                    options: ['Baju', 'Celana', 'Gamis', 'Aksesoris']
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Jenis / Kategori <span class="text-[#B04025]">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="Jenis_Barang" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 flex items-center justify-between @error('Jenis_Barang') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
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
                    @error('Jenis_Barang')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ukuran -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('Ukuran_Barang', 'M') }}',
                    options: [
                        {val: 'S', label: 'S (Small)'},
                        {val: 'M', label: 'M (Medium)'},
                        {val: 'L', label: 'L (Large)'},
                        {val: 'XL', label: 'XL (Extra Large)'},
                        {val: 'XXL', label: 'XXL (Double XL)'},
                        {val: 'All Size', label: 'All Size'}
                    ]
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Ukuran Produk <span class="text-[#B04025]">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="Ukuran_Barang" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 flex items-center justify-between @error('Ukuran_Barang') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                            <span x-text="options.find(o => o.val === selected).label" class="font-medium"></span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
                            <template x-for="option in options" :key="option.val">
                                <div @click="selected = option.val; open = false" 
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-[#A98D66]/10 hover:text-[#2F5C53] text-slate-800"
                                    :class="selected === option.val ? 'text-slate-800 font-bold' : ''">
                                    <span x-text="option.label"></span>
                                    <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('Ukuran_Barang')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemasok Utama -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('ID_Pemasok') }}', 
                    selectedLabel: '{{ old('ID_Pemasok') ? ($pemasoks->firstWhere('ID_Pemasok', old('ID_Pemasok'))->Nama_Pemasok ?? '-- Pilih Pemasok --') : '-- Pilih Pemasok --' }}',
                    options: [
                        @foreach($pemasoks as $pemasok)
                            {val: '{{ $pemasok->ID_Pemasok }}', label: '{{ $pemasok->Nama_Pemasok }}'},
                        @endforeach
                    ]
                }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Pemasok Utama <span class="text-[#B04025]">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="ID_Pemasok" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 flex items-center justify-between @error('ID_Pemasok') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
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
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Varian Warna <span class="text-[#B04025]">*</span></label>
                    <input type="text" name="Warna_Barang" value="{{ old('Warna_Barang') }}" placeholder="Contoh: Kuning, Navy, Hitam" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Warna_Barang') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Warna_Barang')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Beli -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Harga Beli Dasar (Rp) <span class="text-[#B04025]">*</span></label>
                    <input type="number" name="Harga_Beli" value="{{ old('Harga_Beli') }}" placeholder="0" min="0" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Harga_Beli') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Harga_Beli')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Jual -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Harga Jual Konsumen (Rp) <span class="text-[#B04025]">*</span></label>
                    <input type="number" name="Harga_Jual" value="{{ old('Harga_Jual') }}" placeholder="0" min="0" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Harga_Jual') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Harga_Jual')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok Awal -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Saldo Awal Stok <span class="text-[#B04025]">*</span></label>
                    <input type="number" name="Stok_Awal" value="{{ old('Stok_Awal', '0') }}" min="0" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all duration-300 @error('Stok_Awal') border-[#B04025]/40 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Stok_Awal')
                        <p class="text-[#B04025] text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1 italic">Kuantitas ini akan langsung tercatat sebagai stok tersedia di sistem.</p>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.barang.list') }}" class="bg-slate-50 text-slate-500 border border-slate-200 font-bold rounded-xl px-8 py-3 text-sm hover:bg-slate-100 transition-all">Batal</a>
                <button type="submit" 
                    :disabled="isSubmitting" 
                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed scale-[0.98]' : ''"
                    class="bg-[#ca5b33] text-white font-black rounded-xl px-10 py-3 text-sm hover:bg-[#B04025] shadow-lg shadow-[#ca5b33]/20 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
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
