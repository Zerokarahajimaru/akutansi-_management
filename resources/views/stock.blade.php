@extends('layouts.app')

@section('title', 'Manajemen Stock')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold mb-6">Manajemen Stock</h1>

    <div class="flex flex-wrap gap-4 mb-8 items-end">
        <div class="w-64 relative">
            <input type="date" class="w-full border rounded-md pl-10 pr-3 py-2 text-gray-600 focus:outline-blue-500" placeholder="Filter Tanggal">
            <i class="fas fa-calendar absolute left-3 top-3 text-gray-400"></i>
        </div>
        <div class="w-64">
            <select class="w-full border rounded-md px-3 py-2 text-gray-600 focus:outline-blue-500 appearance-none bg-white">
                <option>Jenis Barang</option>
                <option>Celana</option>
                <option>Baju</option>
            </select>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 flex items-center transition">
            <i class="fas fa-check-circle mr-2 text-sm"></i> Apply Filter
        </button>
        <button class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 flex items-center transition">
            <i class="fas fa-sync mr-2 text-sm"></i> Reset Filter
        </button>
    </div>

    <div class="flex gap-4 mb-6">
        <button class="bg-slate-700 text-white px-5 py-2.5 rounded shadow-sm hover:bg-slate-800 flex items-center text-sm">
            <i class="fas fa-file-export mr-2"></i> Export
        </button>
        <button class="bg-slate-700 text-white px-5 py-2.5 rounded shadow-sm hover:bg-slate-800 flex items-center text-sm">
            <i class="fas fa-download mr-2"></i> Unduh Template
        </button>
        <button class="bg-slate-700 text-white px-5 py-2.5 rounded shadow-sm hover:bg-slate-800 flex items-center text-sm">
            <i class="fas fa-file-import mr-2"></i> Import Data
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border border-gray-100">
            <thead class="bg-gray-50 text-gray-700 font-semibold">
                <tr>
                    <th class="p-4 border-b">Nama Barang</th>
                    <th class="p-4 border-b">Jenis</th>
                    <th class="p-4 border-b">Warna</th>
                    <th class="p-4 border-b">Ukuran</th>
                    <th class="p-4 border-b">Stok</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach($stocks as $item)
                <tr class="hover:bg-gray-50 transition border-b last:border-0">
                    <td class="p-4">{{ $item['nama'] }}</td>
                    <td class="p-4">{{ $item['jenis'] }}</td>
                    <td class="p-4">{{ $item['warna'] }}</td>
                    <td class="p-4">{{ $item['ukuran'] }}</td>
                    <td class="p-4">{{ $item['stok'] }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="bg-orange-400 text-white p-2 rounded hover:bg-orange-500 shadow-sm">
                                <i class="fas fa-pencil-alt text-xs"></i>
                            </button>
                            <button class="bg-red-600 text-white p-2 rounded hover:bg-red-700 shadow-sm">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection