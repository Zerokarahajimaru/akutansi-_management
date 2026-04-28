@extends('layouts.app')

@section('title', 'Overview')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
    
    
    <div class="bg-green-600 text-white p-6 rounded-lg shadow-md relative overflow-hidden">
            <p class="text-sm">Penjualan Hari Ini</p>
            <p class="text-2xl font-bold mt-2">{{ $stats['penjualan_hari_ini'] }}</p>
            <i class="fas fa-shopping-cart absolute right-4 bottom-4 opacity-20 text-4xl"></i>
        </div>



        <div class="bg-red-500 text-white p-6 rounded-lg shadow-md relative overflow-hidden">
            <p class="text-sm">Pembelian Hari Ini</p>
            <p class="text-2xl font-bold mt-2">{{ $stats['pembelian_hari_ini'] }}</p>
            <i class="fas fa-shopping-cart absolute right-4 bottom-4 opacity-20 text-4xl"></i>
        </div>
        <div class="bg-orange-400 text-white p-6 rounded-lg shadow-md relative overflow-hidden">
            <p class="text-sm">Jumlah Stok</p>
            <p class="text-2xl font-bold mt-2">{{ $stats['total_stok'] }}</p>
            <i class="fas fa-box absolute right-4 bottom-4 opacity-20 text-4xl"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-bold mb-4">Aktivitas Terakhir</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b">
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Tipe</th>
                        <th class="pb-3">Produk</th>
                        <th class="pb-3">Nominal</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($activities as $act)
                    <tr class="border-b last:border-0 hover:bg-gray-50">
                        <td class="py-3">{{ $act['date'] }}</td>
                        <td class="py-3">{{ $act['tipe'] }}</td>
                        <td class="py-3">{{ $act['produk'] }}</td>
                        <td class="py-3 font-semibold text-gray-800">{{ $act['nominal'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-bold mb-4">Stok Kritis</h2>
            <div class="space-y-4">
                @foreach($critical_stocks as $item)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded flex items-center justify-center mr-3">
                            <i class="fas fa-box text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-400">Stok level: {{ $item['level'] }}</p>
                        </div>
                    </div>
                    <span class="text-red-600 font-bold">{{ $item['level'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection