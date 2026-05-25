@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-500 text-sm mt-1">Berikut ringkasan kinerja toko Anda hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Penjualan Card -->
        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 flex items-center justify-between group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Today's Sales</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ $stats['penjualan_hari_ini'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-teal-50 rounded-[1.5rem] flex items-center justify-center group-hover:bg-teal-500 group-hover:-translate-y-2 transition-all duration-500 shadow-sm">
                <i class="fas fa-hand-holding-dollar text-2xl text-teal-600 group-hover:text-white transition-colors duration-500"></i>
            </div>
        </div>

        <!-- Pembelian Card -->
        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 flex items-center justify-between group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Today's Purchases</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ $stats['pembelian_hari_ini'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-blue-50 rounded-[1.5rem] flex items-center justify-center group-hover:bg-blue-500 group-hover:-translate-y-2 transition-all duration-500 shadow-sm">
                <i class="fas fa-cart-shopping text-2xl text-blue-600 group-hover:text-white transition-colors duration-500"></i>
            </div>
        </div>

        <!-- Stok Card -->
        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 flex items-center justify-between group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Total Stock</p>
                <h3 class="text-3xl font-bold text-slate-900">{{ $stats['total_stok'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-orange-50 rounded-[1.5rem] flex items-center justify-center group-hover:bg-orange-500 group-hover:-translate-y-2 transition-all duration-500 shadow-sm">
                <i class="fas fa-box-open text-2xl text-orange-600 group-hover:text-white transition-colors duration-500"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 flex items-center text-lg">
                    <i class="fas fa-clock-rotate-left mr-3 text-teal-500"></i> Recent Activities
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-sm border-b border-slate-100">
                            <th class="py-5 px-8 font-semibold">Date</th>
                            <th class="py-5 px-8 font-semibold">Type</th>
                            <th class="py-5 px-8 font-semibold">Product</th>
                            <th class="py-5 px-8 font-semibold text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activities as $act)
                        <tr class="hover:bg-slate-50/30 transition-colors duration-300">
                            <td class="py-5 px-8 text-sm text-slate-500">{{ $act['date'] }}</td>
                            <td class="py-5 px-8">
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $act['tipe'] === 'Penjualan' ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                    {{ $act['tipe'] }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-sm font-medium text-slate-800">{{ $act['produk'] }}</td>
                            <td class="py-5 px-8 text-sm font-bold text-slate-900 text-right">{{ $act['nominal'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-sm">No recent activities</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Stocks -->
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(15,23,42,0.04)] border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50">
                <h2 class="font-bold text-slate-800 flex items-center text-lg">
                    <i class="fas fa-triangle-exclamation mr-3 text-orange-500"></i> Critical Stock
                </h2>
            </div>
            <div class="p-8 space-y-6 flex-1">
                @forelse($critical_stocks as $item)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center mr-4 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-boxes-stacked text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $item['name'] }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Stock Level: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg font-bold text-sm border border-rose-100">
                        {{ $item['level'] }}
                    </div>
                </div>
                @empty
                <div class="py-12 flex flex-col items-center justify-center h-full">
                    <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mb-4 shadow-inner">
                        <i class="fas fa-check text-teal-500 text-2xl"></i>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">All stock levels are secure</p>
                </div>
                @endforelse
            </div>
            @if(count($critical_stocks) > 0)
            <div class="px-8 pb-8 mt-auto">
                <a href="{{ route('laporan.stok') }}" class="block w-full text-center py-3.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl text-sm font-semibold hover:bg-slate-950 hover:text-white hover:border-slate-950 transition-all duration-300 shadow-sm">
                    Update Stock Now
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection