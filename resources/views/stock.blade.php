@extends('layouts.app')

@section('title', 'Data Barang & Stok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Master Data Barang</h2>
 <p class="text-gray-500 text-xs">Kelola informasi produk dan pantau ketersediaan stok</p>
 </div>
 <div class="flex flex-wrap gap-2" x-data="{ 
 triggerImport() { document.getElementById('import-file').click() },
 submitImport() { document.getElementById('import-form').submit() }
 }">
 <form id="import-form" action="{{ route('util.import', 'barang') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'barang') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'barang') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.barang') }}" class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-box-archive mr-2"></i> Tambah Barang
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table class="w-full text-left">
 <thead>
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 <th class="py-4 px-6">Nama Produk</th>
 <th class="py-4 px-6">Jenis</th>
 <th class="py-4 px-6">Warna</th>
 <th class="py-4 px-6">Ukuran</th>
 <th class="py-4 px-6">Harga Beli</th>
 <th class="py-4 px-6">Harga Jual</th>
 <th class="py-4 px-6 text-center">Stok Akhir</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($stocks as $barang)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm font-bold text-gray-800">{{ $barang->Nama_Barang }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $barang->Jenis_Barang }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $barang->Warna_Barang }}</td>
 <td class="py-4 px-6">
 <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg uppercase">{{ $barang->Ukuran_Barang }}</span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-500 italic">Rp {{ number_format($barang->Harga_Beli, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm font-bold text-teal-600">Rp {{ number_format($barang->Harga_Jual, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-center">
 @php
 $stok_akhir = $barang->stokBarangs->sum('Stok_Akhir');
 @endphp
 <span class="px-3 py-1 rounded-full text-xs font-bold {{ $stok_akhir < 10 ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-teal-600' }}">
 {{ $stok_akhir }}
 </span>
 </td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.barang.edit', $barang->ID_Barang) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.barang.destroy', $barang->ID_Barang) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="9" class="py-10 text-center text-gray-400 italic text-sm">Belum ada data barang</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
