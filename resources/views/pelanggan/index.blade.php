@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
 <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
 <div>
 <h2 class="font-bold text-gray-800 text-lg">Daftar Pelanggan</h2>
 <p class="text-gray-500 text-xs">Kelola data pelanggan tetap toko Anda</p>
 </div>
 <div class="flex flex-wrap gap-2" x-data="{ 
 triggerImport() { document.getElementById('import-file').click() },
 submitImport() { document.getElementById('import-form').submit() }
 }">
 <form id="import-form" action="{{ route('util.import', 'pelanggan') }}" method="POST" enctype="multipart/form-data" class="hidden">
 @csrf
 <input type="file" id="import-file" name="file" @change="submitImport()">
 </form>

 <a href="{{ route('util.export', 'pelanggan') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-file-export mr-2"></i> Export
 </a>
 <a href="{{ route('util.template', 'pelanggan') }}" class="flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 transition-colors">
 <i class="fas fa-download mr-2"></i> Unduh Template
 </a>
 <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-xs font-bold hover:bg-orange-100 transition-colors">
 <i class="fas fa-file-import mr-2"></i> Import Data
 </button>
 <a href="{{ route('input.pelanggan') }}" class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 transition-colors shadow-lg shadow-teal-200">
 <i class="fas fa-user-plus mr-2"></i> Tambah Pelanggan
 </a>
 </div>
 </div>
 <div class="overflow-x-auto">
 <table class="w-full text-left">
 <thead>
 <tr class="bg-gray-50/50 text-gray-500 text-sm border-b border-gray-100">
 <th class="py-4 px-6">Nama</th>
 <th class="py-4 px-6">Alamat</th>
 <th class="py-4 px-6">No. HP</th>
 <th class="py-4 px-6 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-50">
 @forelse($pelanggans as $p)
 <tr class="hover:bg-gray-50/50 transition-colors">
 <td class="py-4 px-6 text-sm font-bold">{{ $p->Nama_Pelanggan }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $p->Alamat_Pelanggan }}</td>
 <td class="py-4 px-6 text-sm text-gray-600">{{ $p->NoTelp_Pelanggan }}</td>
 <td class="py-4 px-6 text-center">
 <div class="flex justify-center space-x-2">
 <a href="{{ route('data.pelanggan.edit', $p->ID_Pelanggan) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
 <i class="fas fa-edit text-xs"></i>
 </a>
 <form action="{{ route('data.pelanggan.destroy', $p->ID_Pelanggan) }}" method="POST">
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
 <td colspan="4" class="py-16 text-center">
 <div class="flex flex-col items-center justify-center">
 <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
 <i class="fas fa-address-book text-gray-300 text-2xl"></i>
 </div>
 <h3 class="text-gray-800 font-bold text-base">Belum Ada Pelanggan</h3>
 <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Daftar pelanggan Anda akan muncul di sini setelah ditambahkan.</p>
 <a href="{{ route('input.pelanggan') }}" class="mt-4 text-teal-600 text-xs font-bold hover:underline">Tambah Pelanggan Sekarang</a>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
