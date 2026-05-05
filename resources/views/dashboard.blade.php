@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-500 text-sm mt-1">Berikut adalah ringkasan performa toko Anda hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Penjualan Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Penjualan Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $stats['penjualan_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-hand-holding-dollar text-2xl text-emerald-500 group-hover:text-white"></i>
            </div>
        </div>

        <!-- Pembelian Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pembelian Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $stats['pembelian_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-cart-shopping text-2xl text-indigo-500 group-hover:text-white"></i>
            </div>
        </div>

        <!-- Stok Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Stok</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $stats['total_stok'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-box-open text-2xl text-amber-500 group-hover:text-white"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 flex items-center">
                    <i class="fas fa-clock-rotate-left mr-2 text-indigo-500"></i> Aktivitas Terakhir
                </h2>
                <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest">
                            <th class="py-4 px-6 font-bold">Tanggal</th>
                            <th class="py-4 px-6 font-bold">Tipe</th>
                            <th class="py-4 px-6 font-bold">Produk</th>
                            <th class="py-4 px-6 font-bold text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activities as $act)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-500">{{ $act['date'] }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $act['tipe'] === 'Penjualan' ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600' }}">
                                    {{ $act['tipe'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm font-semibold text-slate-700">{{ $act['produk'] }}</td>
                            <td class="py-4 px-6 text-sm font-black text-slate-900 text-right">{{ $act['nominal'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-400 italic text-sm">Tidak ada aktivitas terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Stocks -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50">
                <h2 class="font-bold text-slate-800 flex items-center">
                    <i class="fas fa-triangle-exclamation mr-2 text-amber-500"></i> Stok Kritis
                </h2>
            </div>
            <div class="p-6 space-y-5">
                @forelse($critical_stocks as $item)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center mr-3 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                            <i class="fas fa-boxes-stacked text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700">{{ $item['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter">Level: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-slate-50 rounded-lg text-rose-600 font-black text-sm">
                        {{ $item['level'] }}
                    </div>
                </div>
                @empty
                <div class="py-10 text-center">
                    <i class="fas fa-check-circle text-emerald-400 text-4xl mb-3"></i>
                    <p class="text-slate-400 text-sm italic">Semua stok aman</p>
                </div>
                @endforelse
            </div>
            @if(count($critical_stocks) > 0)
            <div class="px-6 pb-6">
                <a href="{{ route('laporan.stok') }}" class="block w-full text-center py-3 bg-slate-50 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-100 transition-colors">
                    Perbarui Stok Sekarang
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection