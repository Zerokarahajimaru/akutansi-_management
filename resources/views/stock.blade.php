@extends('layouts.app')

@section('title', 'Manajemen Stock')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold mb-6">Manajemen Stock</h1>

    <div class="flex flex-wrap gap-4 mb-8 items-end">
        <div class="w-48">
            <input type="date" class="w-full border rounded-md px-3 py-2 text-gray-600 focus:outline-blue-500" placeholder="Filter Tanggal">
        </div>
        <div class="w-48">
            <select class="w-full border rounded-md px-3 py-2 text-gray-600 focus:outline-blue-500">
                <option>Jenis Barang</option>
                <option>Celana</option>
                <option>Baju</option>
            </select>
        </div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> Apply Filter
        </button>
        <button class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 flex items-center">
            <i class="fas fa-sync mr-2"></i> Reset Filter
        </button>
    </div>

    <div class="flex gap-4 mb-6">
        <button class="bg-slate-700 text-white px-4 py-2 rounded flex items-center text-sm">
            <i class="fas fa-file-export mr-2"></i> Export
        </button>
        <button class="bg-slate-700 text-white px-4 py-2 rounded flex items-center text-sm">
            <i class="fas fa-download mr-2"></i> Unduh Template
        </button>
        <button class="bg-slate-700 text-white px-4 py-2 rounded flex items-center text-sm">
            <i class="fas fa-file-import mr-2"></i> Import Data
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 border">Nama Barang</th>
                    <th class="p-3 border">Jenis</th>
                    <th class="p-3 border">Warna</th>
                    <th class="p-3 border">Ukuran</th>
                    <th class="p-3 border">Stok</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $item['nama'] }}</td>
                    <td class="p-3 border">{{ $item['jenis'] }}</td>
                    <td class="p-3 border">{{ $item['warna'] }}</td>
                    <td class="p-3 border">{{ $item['ukuran'] }}</td>
                    <td class="p-3 border">{{ $item['stok'] }}</td>
                    <td class="p-3 border text-center">
                        <button class="bg-orange-400 text-white p-2 rounded mr-1 hover:bg-orange-500">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection