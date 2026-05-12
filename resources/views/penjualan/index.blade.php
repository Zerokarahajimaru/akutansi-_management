@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Action Bar -->
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Riwayat Penjualan Barang</h2>
            <p class="text-slate-500 text-xs">Daftar semua transaksi stok keluar (Sales)</p>
        </div>
        <div class="flex flex-wrap gap-2" x-data="{ 
            triggerImport() { document.getElementById('import-file').click() },
            submitImport() { document.getElementById('import-form').submit() }
        }">
            <form id="import-form" action="{{ route('util.import', 'penjualan') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" id="import-file" name="file" @change="submitImport()">
            </form>

            <a href="{{ route('util.export', 'penjualan') }}" class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                <i class="fas fa-file-export mr-2"></i> Export
            </a>
            <a href="{{ route('util.template', 'penjualan') }}" class="flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                <i class="fas fa-download mr-2"></i> Unduh Template
            </a>
            <button @click="triggerImport()" class="flex items-center px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-bold hover:bg-amber-100 transition-colors">
                <i class="fas fa-file-import mr-2"></i> Import Data
            </button>
            <a href="{{ route('input.penjualan') }}" class="flex items-center px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 transition-colors shadow-lg shadow-rose-200">
                <i class="fas fa-plus mr-2"></i> Tambah Penjualan
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest font-black">
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Spesifikasi</th>
                    <th class="py-4 px-6">Pelanggan</th>
                    <th class="py-4 px-6 text-center">Kuantitas</th>
                    <th class="py-4 px-6">Harga Barang</th>
                    <th class="py-4 px-6">Ongkir</th>
                    <th class="py-4 px-6 font-bold text-slate-700">Total Harga</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="py-4 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($penjualans as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 text-sm text-slate-500">{{ \Carbon\Carbon::parse($item->Tanggal_Penjualan)->format('d/m/Y') }}</td>
                    <td class="py-4 px-6">
                        <p class="text-sm font-bold text-slate-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">{{ $item->ID_Penjualan }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-wrap gap-1">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Jenis_Barang ?? '-' }}</span>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Warna_Barang ?? '-' }}</span>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-bold rounded uppercase">{{ $item->dataBarang->Ukuran_Barang ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $item->pelanggan->Nama_Pelanggan ?? '-' }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="text-rose-500 font-black text-sm">-{{ $item->Kuantitas }}</span>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600">Rp {{ number_format($item->Total_Harga_Barang, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">Rp {{ number_format($item->Ongkir, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-sm font-black text-indigo-600">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('data.penjualan.edit', $item->ID_Penjualan) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-50 text-orange-500 hover:bg-orange-500 hover:text-white transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('data.penjualan.destroy', $item->ID_Penjualan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'admin' ? 9 : 8 }}" class="py-10 text-center text-slate-400 italic text-sm">Belum ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
