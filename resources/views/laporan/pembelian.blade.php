@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Filter Bar -->
    <div class="p-6 border-b border-slate-50">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Laporan Pembelian Stok</h2>
                <p class="text-slate-500 text-xs">Analisa riwayat pengadaan barang dari pemasok</p>
            </div>
            <form action="{{ route('laporan.pembelian') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    <i class="fas fa-calendar text-slate-400 mr-2 text-xs"></i>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-slate-700">
                    <span class="mx-2 text-slate-300">-</span>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="bg-transparent text-xs font-bold focus:outline-none text-slate-700">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                    FILTER
                </button>
                <a href="{{ route('util.export', 'pembelian') }}" class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-emerald-100 transition-all flex items-center">
                    <i class="fas fa-file-excel mr-1"></i> EXPORT
                </a>
            </form>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 border-b border-slate-50">
        <div class="p-6 border-r border-slate-50">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Transaksi</p>
            <h3 class="text-xl font-black text-slate-800">{{ $pembelians->count() }}</h3>
        </div>
        <div class="p-6 border-r border-slate-50">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kuantitas</p>
            <h3 class="text-xl font-black text-emerald-600">+{{ $pembelians->sum('Kuantitas') }} <span class="text-xs text-slate-400 font-medium">Unit</span></h3>
        </div>
        <div class="p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pengeluaran</p>
            <h3 class="text-xl font-black text-indigo-600">Rp {{ number_format($pembelians->sum('Total_Harga'), 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-widest font-black">
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Pemasok</th>
                    <th class="py-4 px-6 text-center">Qty</th>
                    <th class="py-4 px-6 text-right">Total Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pembelians as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->Tgl_Pembelian)->format('d/m/Y') }}</td>
                    <td class="py-4 px-6">
                        <p class="text-sm font-bold text-slate-800">{{ $item->dataBarang->Nama_Barang ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase">{{ $item->dataBarang->Ukuran_Barang }} | {{ $item->dataBarang->Warna_Barang }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $item->pemasok->Nama_Pemasok ?? '-' }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[11px] font-black rounded-lg">+{{ $item->Kuantitas }}</span>
                    </td>
                    <td class="py-4 px-6 text-sm font-black text-slate-900 text-right">Rp {{ number_format($item->Total_Harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400 italic text-sm font-medium">Tidak ada data pembelian pada periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
