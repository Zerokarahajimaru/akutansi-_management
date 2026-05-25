@extends('layouts.app')

@section('title', 'Ubah Data Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_50px_rgba(13,148,136,0.05)] overflow-hidden">
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
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="Nama_Barang" value="{{ old('Nama_Barang', $barang->Nama_Barang) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Nama_Barang') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Nama_Barang')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('Jenis_Barang', $barang->Jenis_Barang) }}',
                    options: ['Baju', 'Celana', 'Gamis', 'Aksesoris']
                }">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jenis / Kategori <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="Jenis_Barang" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all flex items-center justify-between @error('Jenis_Barang') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
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
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
                                    :class="selected === option ? 'text-teal-600 font-bold' : ''">
                                    <span x-text="option"></span>
                                    <i x-show="selected === option" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('Jenis_Barang')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ukuran -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('Ukuran_Barang', $barang->Ukuran_Barang) }}',
                    options: [
                        {val: 'S', label: 'S (Small)'},
                        {val: 'M', label: 'M (Medium)'},
                        {val: 'L', label: 'L (Large)'},
                        {val: 'XL', label: 'XL (Extra Large)'},
                        {val: 'XXL', label: 'XXL (Double XL)'},
                        {val: 'All Size', label: 'All Size'}
                    ]
                }">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Ukuran <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="Ukuran_Barang" :value="selected">
                        <button @click="open = !open" type="button" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all flex items-center justify-between @error('Ukuran_Barang') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
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
                                    class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-slate-600"
                                    :class="selected === option.val ? 'text-teal-600 font-bold' : ''">
                                    <span x-text="option.label"></span>
                                    <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('Ukuran_Barang')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemasok -->
                <div class="space-y-2" x-data="{ 
                    open: false, 
                    selected: '{{ old('ID_Pemasok', $barang->ID_Pemasok) }}', 
                    selectedLabel: '{{ old('ID_Pemasok') ? ($pemasoks->firstWhere('ID_Pemasok', old('ID_Pemasok'))->Nama_Pemasok ?? '-- Pilih Pemasok --') : ($barang->pemasok->Nama_Pemasok ?? '-- Pilih Pemasok --') }}',
                    options: [
                        @foreach($pemasoks as $pemasok)
                            {val: '{{ $pemasok->ID_Pemasok }}', label: '{{ $pemasok->Nama_Pemasok }}'},
                        @endforeach
                    ]
                }">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Pemasok Terkait <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="hidden" name="ID_Pemasok" :value="selected" required>
                        <button @click="open = !open" type="button" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all flex items-center justify-between @error('ID_Pemasok') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                            <span x-text="selectedLabel" class="font-medium"></span>
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
                    @error('ID_Pemasok')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Varian Warna <span class="text-red-500">*</span></label>
                    <input type="text" name="Warna_Barang" value="{{ old('Warna_Barang', $barang->Warna_Barang) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Warna_Barang') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Warna_Barang')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Beli -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Harga Beli Dasar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="Harga_Beli" value="{{ old('Harga_Beli', $barang->Harga_Beli) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Harga_Beli') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Harga_Beli')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Jual -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Harga Jual Konsumen (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="Harga_Jual" value="{{ old('Harga_Jual', $barang->Harga_Jual) }}" class="w-full bg-white border-teal-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all @error('Harga_Jual') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" required>
                    @error('Harga_Jual')
                        <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.barang.list') }}" class="px-6 py-3 bg-slate-50 text-slate-400 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-100 hover:text-slate-600 transition-all">Batal</a>
                <button type="submit" class="px-10 py-3 bg-teal-600 text-white font-black rounded-xl shadow-lg shadow-teal-500/20 hover:bg-teal-700 active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
