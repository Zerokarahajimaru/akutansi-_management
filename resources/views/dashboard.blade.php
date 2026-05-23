@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-500 text-sm mt-1">Here is a summary of your store's performance today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Penjualan Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-shadow duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Today's Sales</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['penjualan_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center group-hover:bg-teal-500 group-hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-hand-holding-dollar text-2xl text-teal-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
        </div>

        <!-- Pembelian Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-shadow duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Today's Purchases</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['pembelian_hari_ini'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-500 group-hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-cart-shopping text-2xl text-blue-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
        </div>

        <!-- Stok Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-shadow duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Stock</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_stok'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center group-hover:bg-orange-500 group-hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-box-open text-2xl text-orange-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clock-rotate-left mr-2.5 text-teal-500"></i> Recent Activities
                </h2>
                <a href="#" class="text-sm font-medium text-teal-600 hover:text-teal-700 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 text-sm border-b border-gray-100">
                            <th class="py-4 px-6 font-semibold">Date</th>
                            <th class="py-4 px-6 font-semibold">Type</th>
                            <th class="py-4 px-6 font-semibold">Product</th>
                            <th class="py-4 px-6 font-semibold text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($activities as $act)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                            <td class="py-4 px-6 text-sm text-gray-500">{{ $act['date'] }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-md text-xs font-semibold {{ $act['tipe'] === 'Penjualan' ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                    {{ $act['tipe'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $act['produk'] }}</td>
                            <td class="py-4 px-6 text-sm font-bold text-gray-900 text-right">{{ $act['nominal'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 text-sm">No recent activities</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Stocks -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-50">
                <h2 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-triangle-exclamation mr-2.5 text-orange-500"></i> Critical Stock
                </h2>
            </div>
            <div class="p-6 space-y-5 flex-1">
                @forelse($critical_stocks as $item)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mr-3 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-boxes-stacked text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Stock Level: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-red-50 text-red-600 rounded-md font-bold text-sm border border-red-100">
                        {{ $item['level'] }}
                    </div>
                </div>
                @empty
                <div class="py-10 flex flex-col items-center justify-center h-full">
                    <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-check text-teal-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">All stock levels are secure</p>
                </div>
                @endforelse
            </div>
            @if(count($critical_stocks) > 0)
            <div class="px-6 pb-6 mt-auto">
                <a href="{{ route('laporan.stok') }}" class="block w-full text-center py-2.5 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 shadow-sm">
                    Update Stock Now
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection