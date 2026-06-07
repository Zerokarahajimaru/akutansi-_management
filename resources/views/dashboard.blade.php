@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 tracking-tightest whitespace-nowrap">Selamat Datang, <span class="text-[#3B8A7F]">{{ Auth::user()->name }}!</span></h1>
        <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-1 leading-relaxed">Ringkasan operasional harian Xyra.id</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Penjualan Card -->
        <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Penjualan Hari Ini</p>
                <h3 class="text-3xl font-black text-[#000000]">{{ $stats['penjualan_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-[#A98D66]/10 rounded-xl flex items-center justify-center transition-all duration-300 border border-slate-200/20">
                <i class="fas fa-hand-holding-dollar text-xl text-slate-800"></i>
            </div>
        </div>

        <!-- Pembelian Card -->
        <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Pembelian Hari Ini</p>
                <h3 class="text-3xl font-black text-[#000000]">{{ $stats['pembelian_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-[#A98D66]/10 rounded-xl flex items-center justify-center transition-all duration-300 border border-slate-200/20">
                <i class="fas fa-cart-shopping text-xl text-slate-800"></i>
            </div>
        </div>

        <!-- Stok Card -->
        <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Total Stok Gudang</p>
                <h3 class="text-3xl font-black text-[#000000]">{{ $stats['total_stok'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-[#A98D66]/10 rounded-xl flex items-center justify-center transition-all duration-300 border border-slate-200/20">
                <i class="fas fa-box-open text-xl text-slate-800"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h2 class="font-black text-slate-800 text-[11px] uppercase tracking-widest flex items-center">
                    <i class="fas fa-history mr-2 text-[#3B8A7F]"></i> Transaksi Terkini
                </h2>
            </div>
            <div class="overflow-x-auto custom-scrollbar relative">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white text-[#000000] text-[10px] font-black uppercase tracking-widest whitespace-nowrap border-b-2 border-[#8E734B]">
                            <th class="py-4 px-8 sticky left-0 bg-inherit z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Tanggal</th>
                            <th class="py-4 px-8">Tipe</th>
                            <th class="py-4 px-8">Produk</th>
                            <th class="py-4 px-8 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activities as $act)
                        <tr class="bg-white even:bg-white even:text-white hover:bg-[#A98D66]/20 transition-all group">
                            <td class="py-4 px-8 text-xs text-slate-500 font-medium whitespace-nowrap sticky left-0 bg-white even:bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#A98D66]/10 transition-colors">{{ $act['date'] }}</td>
                            <td class="py-4 px-8 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $act['tipe'] === 'Penjualan' ? 'bg-[#3B8A7F]/10 text-slate-800' : 'bg-[#8E734B]/10 text-[#8E734B]' }}">
                                    {{ $act['tipe'] }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-xs font-bold text-slate-800 whitespace-nowrap">{{ $act['produk'] }}</td>
                            <td class="py-4 px-8 text-xs font-black text-slate-800 text-right whitespace-nowrap">{{ $act['nominal'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px]">Belum ada aktivitas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Stocks -->
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(13,148,136,0.05)] border border-slate-100 overflow-hidden flex flex-col self-start">
            <div class="p-6 border-b border-slate-50 bg-slate-50/30">
                <h2 class="font-black text-slate-800 text-[11px] uppercase tracking-widest flex items-center">
                    <i class="fas fa-triangle-exclamation mr-2 text-[#CA5B33]"></i> Stok Kritis
                </h2>
            </div>
            <div class="p-6 space-y-4">
                @forelse($critical_stocks as $item)
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-[#A98D66]/5 transition-colors border border-transparent hover:border-slate-200/20 group">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 bg-[#3B8A7F]/10 text-[#CA5B33] rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-[#3B8A7F] group-hover:text-white transition-all duration-300">
                            <i class="fas fa-box-archive text-sm"></i>
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-black text-slate-800 truncate uppercase tracking-tighter">{{ $item['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 leading-none">Sisa: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <div class="ml-4 px-2.5 py-1 bg-[#3B8A7F]/20 text-[#CA5B33] rounded-lg font-black text-[10px] uppercase shadow-sm">
                        Kritis
                    </div>
                </div>
                @empty
                <div class="py-12 flex flex-col items-center justify-center">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-3 shadow-inner border border-emerald-100">
                        <i class="fas fa-check text-emerald-500 text-xl"></i>
                    </div>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Stok Aman Terkendali</p>
                </div>
                @endforelse
            </div>
            @if(count($critical_stocks) > 0)
            <div class="px-6 pb-6 mt-auto">
                <a href="{{ route('laporan.stok') }}" class="block w-full text-center py-3 bg-[#3B8A7F] border border-[#3B8A7F] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:border-[#2F5C53] transition-all duration-300">
                    Periksa Gudang
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection
