@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Daftar Pelanggan</h2>
            <p class="text-slate-500 text-xs">Kelola data pelanggan tetap toko Anda</p>
        </div>
        <div class="flex flex-wrap gap-2" x-data="{ 
            triggerImport() { document.getElementById('import-file').click() },
            submitImport() { document.getElementById('import-form').submit() }
        }">
            <form id="import-form" action="{{ route('util.import', 'pelanggan') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" id="import-file" name="file" @change="submitImport()">
            </form>

            <a href="{{ route('util.export', 'pelanggan') }}" class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                <i class="fas fa-file-export mr-2"></i> Export
            </a>
            <a href="{{ route('util.template', 'pelanggan') }}" class="flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                <i class="fas fa-download mr-2"></i> Unduh Template
            </a>
            <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors">
                <i class="fas fa-file-import mr-2"></i> Import Data
            </button>
            <a href="{{ route('input.pelanggan') }}" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                <i class="fas fa-plus mr-2"></i> Tambah Pelanggan
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black">
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6">No. HP</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pelanggans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 text-sm font-bold">{{ $p->Nama_Pelanggan }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $p->Alamat_Pelanggan }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $p->NoTelp_Pelanggan }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('data.pelanggan.edit', $p->ID_Pelanggan) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-50 text-orange-500 hover:bg-orange-500 hover:text-white transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('data.pelanggan.destroy', $p->ID_Pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-10 text-center text-slate-400 italic text-sm">Belum ada data pelanggan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
