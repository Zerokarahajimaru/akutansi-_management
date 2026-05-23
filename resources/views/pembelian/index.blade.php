@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <!-- Action Bar -->
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Riwayat Pembelian Barang</h2>
 <p class="text-gray-500 text-xs">Daftar semua transaksi stok masuk (Purchase)</p>
 </div>
 <div class="flex flex-wrap gap-2" x-data="{ 
 triggerImport() { document.getElementById('import-file').click() },
 submitImport() { document.getElementById('import-form').submit() }
 }">
 <form id="import-form" action="{{ route('util.import', 'pembelian') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'pembelian') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'pembelian') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.pembelian') }}" class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-plus mr-2"></i> Tambah Transaksi
 </a>
 </div>
 </div>

 <!-- Table -->
 <div class="overflow-x-auto">
 <table class="w-full text-left">
 <thead>
 <tr class="bg-gray-50/50 text-gray-400 text-xs font-bold">
 <th class="py-4 px-6">Tanggal</th>
 <th class="py-4 px-6">Produk</th>
 <th class="py-4 px-6">Spesifikasi</th>
 <th class="py-4 px-6">Pemasok</th>
 <th class="py-4 px-6 text-center">Kuantitas</th>
 <th class="py-4 px-6">Harga Barang</th>
 <th class="py-4 px-6">Ongkir</th>
 <th class="py-4 px-6 font-bold text-gray-700">Total Harga</th>
 @if(Auth::user()->role === 'admin')
 <th class="py-4 px-6 text-center">Aksi</th>
 @endif
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($pembelians as $item)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->Tgl_Pembelian)->format('d/m/Y') }}</td>
 <td class="py-4 px-6">
 <p class="text-sm font-bold text-gray-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
 <p class="text-xs text-gray-400 font-medium">{{ $item->ID_Pembelian }}</p>
 </td>
 <td class="py-4 px-6">
 <div class="flex flex-wrap gap-1">
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Jenis_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Warna_Barang ?? '-' }}</span>
 <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Ukuran_Barang ?? '-' }}</span>
 </div>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $item->pemasok->Nama_Pemasok ?? '-' }}</td>
 <td class="py-4 px-6 text-center">
 <span class="text-teal-500 font-bold text-sm">+{{ $item->Kuantitas }}</span>
 </td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Total_Harga_Barang, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">Rp {{ number_format($item->Ongkir, 0, ',', '.') }}</td>
 <td class="py-4 px-6 text-sm font-bold text-teal-600">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
 @if(Auth::user()->role === 'admin')
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pembelian.edit', $item->ID_Pembelian) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pembelian.destroy', $item->ID_Pembelian) }}" method="POST">
 @csrf
 @method('DELETE')
 <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">
 <i class="fas fa-trash text-xs"></i>
 </button>
 </form>
 </div>
 </td>
 @endif
 </tr>
 @empty
 <tr>
 <td colspan="{{ Auth::user()->role === 'admin' ? 9 : 8 }}" class="py-10 text-center text-gray-400 italic text-sm">Belum ada data pembelian</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
