@extends('layouts.app')

@section('title', 'Penyesuaian Stok')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_60px_rgba(169,141,102,0.12)] overflow-hidden">
        <div class="p-8 sm:p-12">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center gap-2 bg-[#3B8A7F]/5 border border-[#3B8A7F]/10 px-4 py-1.5 rounded-full mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#3B8A7F] animate-pulse"></span>
                    <span class="text-[10px] font-black text-[#3B8A7F] uppercase tracking-widest">Stock Adjustment Mode</span>
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-2 tracking-tighter">Penyesuaian Manual.</h2>
                <p class="text-slate-400 text-sm font-medium">Perbarui saldo stok barang dengan alasan operasional khusus.</p>
            </div>

            <form action="{{ route('data.barang.update', $stok->ID_Stok) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- 1. Product Identity (Locked/Read-Only) -->
                <div class="bg-slate-50/80 rounded-[2rem] p-6 border border-slate-200/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Informasi Produk (Terkunci)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Nama Produk</span>
                            <p class="text-sm font-black text-slate-800">{{ $stok->dataBarang->Nama_Barang }}</p>
                        </div>
                        <div class="space-y-1 md:text-right">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase">Varian & Ukuran</span>
                            <p class="text-sm font-black text-slate-600">{{ $stok->dataBarang->Warna_Barang }} / {{ $stok->dataBarang->Ukuran_Barang }}</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Adjustment Type -->
                <div class="space-y-3" x-data="{ type: 'Masuk' }">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2 text-center">Tipe Penyesuaian</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="Tipe" value="Masuk" x-model="type" class="sr-only peer" checked>
                            <div class="w-full py-4 text-center rounded-2xl border-2 border-slate-100 bg-white transition-all duration-300 peer-checked:border-[#3B8A7F] peer-checked:bg-[#3B8A7F]/5 group-hover:bg-slate-50">
                                <i class="fas fa-arrow-up-long text-[#3B8A7F] mb-2 block text-lg"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 peer-checked:text-[#3B8A7F]">Stok Masuk (+)</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="Tipe" value="Keluar" x-model="type" class="sr-only peer">
                            <div class="w-full py-4 text-center rounded-2xl border-2 border-slate-100 bg-white transition-all duration-300 peer-checked:border-[#B04025] peer-checked:bg-[#B04025]/5 group-hover:bg-slate-50">
                                <i class="fas fa-arrow-down-long text-[#B04025] mb-2 block text-lg"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 peer-checked:text-[#B04025]">Stok Keluar (-)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 3. Quantity & Notes -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1 space-y-2">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2">Jumlah Qty</label>
                        <input type="number" name="Kuantitas" min="1" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-center text-xl font-black text-slate-800 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2">Keterangan / Alasan</label>
                        <input type="text" name="Keterangan" required maxlength="255"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all"
                            placeholder="Misal: Barang rusak di gudang, Retur pelanggan...">
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="pt-4 border-t border-slate-50 flex items-center justify-center gap-3">
                    <i class="fas fa-user-shield text-slate-300 text-sm"></i>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Otorisasi oleh: {{ auth()->user()->name }}</p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse sm:flex-row items-center gap-4 pt-4">
                    <a href="{{ route('data.stok') }}" class="w-full sm:w-auto flex-1 text-center py-4 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto flex-[2] bg-[#ca5b33] text-white font-black py-4.5 rounded-2xl shadow-xl shadow-[#ca5b33]/25 hover:bg-[#B04025] hover:-translate-y-1 active:scale-95 transition-all duration-300 text-xs uppercase tracking-[0.2em] flex items-center justify-center">
                        Simpan Penyesuaian <i class="fas fa-check-double ml-3 opacity-70"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
