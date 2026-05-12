@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Riwayat 50 Aktivitas Terakhir</h2>
            <p class="text-slate-500 text-xs">Daftar transaksi pembelian dan penjualan terbaru dalam sistem</p>
        </div>
        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-clock-rotate-left"></i>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black">
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Tipe</th>
                    <th class="py-4 px-6">Produk</th>
                    <th class="py-4 px-6">Pihak Terkait</th>
                    <th class="py-4 px-6 text-center">Qty</th>
                    <th class="py-4 px-6 text-right">Total Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($activities as $act)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6 text-sm text-slate-500">{{ \Carbon\Carbon::parse($act['tanggal'])->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-{{ $act['color'] }}-50 text-{{ $act['color'] }}-600 border border-{{ $act['color'] }}-100">
                            <i class="fas {{ $act['icon'] }} mr-1.5"></i>
                            {{ $act['tipe'] }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-sm font-bold text-slate-700">{{ $act['produk'] }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $act['entitas'] }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="font-black text-slate-900">{{ $act['qty'] }}</span>
                    </td>
                    <td class="py-4 px-6 text-sm font-black text-slate-900 text-right">
                        Rp {{ number_format($act['nominal'], 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 italic text-sm">Belum ada riwayat aktivitas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
