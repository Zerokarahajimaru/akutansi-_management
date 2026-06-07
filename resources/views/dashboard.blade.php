@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-[#A98D66] tracking-tightest whitespace-nowrap uppercase">Ringkasan <span class="text-[#3B8A7F]">Sistem.</span></h1>
        <p class="text-slate-500 text-xs font-medium mt-2 leading-relaxed max-w-2xl">Selamat datang kembali, {{ Auth::user()->name }}. Berikut adalah visualisasi performa operasional harian Xyra.id hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Penjualan Card -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#3B8A7F]/30 transition-all duration-500">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 leading-none">Total Penjualan</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $stats['penjualan_hari_ini'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-[#3B8A7F]/10 rounded-2xl flex items-center justify-center transition-all duration-500 border border-[#3B8A7F]/5 group-hover:scale-110">
                <i class="fas fa-money-bill-trend-up text-2xl text-[#3B8A7F]"></i>
            </div>
        </div>

        <!-- Pembelian Card -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#ca5b33]/30 transition-all duration-500">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 leading-none">Total Pembelian</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $stats['pembelian_hari_ini'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-[#ca5b33]/10 rounded-2xl flex items-center justify-center transition-all duration-500 border border-[#ca5b33]/5 group-hover:scale-110">
                <i class="fas fa-cart-flatbed text-2xl text-[#ca5b33]"></i>
            </div>
        </div>

        <!-- Stok Card -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 flex items-center justify-between group hover:border-[#A98D66]/30 transition-all duration-500">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 leading-none">Aset Stok Gudang</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_stok'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-[#A98D66]/10 rounded-2xl flex items-center justify-center transition-all duration-500 border border-[#A98D66]/5 group-hover:scale-110">
                <i class="fas fa-warehouse text-2xl text-[#A98D66]"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h2 class="text-[#A98D66] font-black tracking-tightest uppercase text-[11px] flex items-center">
                    <i class="fas fa-history mr-2 text-[#A98D66]"></i> Transaksi Terkini
                </h2>
            </div>
            <div class="overflow-x-auto custom-scrollbar relative">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white text-[#A98D66] text-[10px] font-black uppercase tracking-widest whitespace-nowrap border-b-2 border-[#B04025]">
                            <th class="py-5 px-8 sticky left-0 bg-white z-20 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Tanggal</th>
                            <th class="py-5 px-8">Tipe</th>
                            <th class="py-5 px-8">Produk</th>
                            <th class="py-5 px-8 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activities as $act)
                        <tr class="bg-white hover:bg-[#A98D66]/10 transition-all group">
                            <td class="py-5 px-8 text-xs text-slate-500 font-medium whitespace-nowrap sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0] transition-colors">{{ $act['date'] }}</td>
                            <td class="py-5 px-8 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $act['tipe'] === 'Penjualan' ? 'bg-[#ca5b33]/10 text-slate-800' : 'bg-[#A98D66]/10 text-[#A98D66]' }}">
                                    {{ $act['tipe'] }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-xs font-bold text-slate-800 whitespace-nowrap">{{ $act['produk'] }}</td>
                            <td class="py-5 px-8 text-xs font-black text-slate-800 text-right whitespace-nowrap">{{ $act['nominal'] }}</td>
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
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(169,141,102,0.08)] border border-slate-100 overflow-hidden flex flex-col self-start">
            <div class="p-6 border-b border-slate-50 bg-slate-50/30">
                <h2 class="text-[#A98D66] font-black tracking-tightest uppercase text-[11px] flex items-center">
                    <i class="fas fa-triangle-exclamation mr-2 text-[#A98D66]"></i> Stok Kritis
                </h2>
            </div>
            <div class="p-6 space-y-4">
                @forelse($critical_stocks as $item)
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-[#A98D66]/5 transition-colors border border-transparent hover:border-slate-200/20 group">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 bg-[#B04025]/5 text-[#B04025] rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-[#B04025] group-hover:text-white transition-all duration-300">
                            <i class="fas fa-box-archive text-sm"></i>
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-black text-[#000000] truncate uppercase tracking-tighter">{{ $item['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 leading-none">Sisa: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <div class="ml-4 px-2.5 py-1 bg-[#B04025]/10 text-[#B04025] rounded-lg font-black text-[10px] uppercase shadow-sm">
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
                <a href="{{ route('laporan.stok') }}" class="block w-full text-center py-3 bg-[#ca5b33] border border-[#ca5b33] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-[#ca5b33] transition-all duration-300 shadow-lg shadow-[#ca5b33]/20">
                    Periksa Gudang
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection
