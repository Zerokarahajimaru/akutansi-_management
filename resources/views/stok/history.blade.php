@extends('layouts.app')

@section('title', 'Riwayat Perubahan Stok')

@section('content')
<div class="space-y-8">
    <!-- Action Bar Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 shadow-sm">
                        <i class="fas fa-history text-[#3B8A7F] text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-[#A98D66] font-black tracking-tightest uppercase text-lg">Kartu Riwayat Stok</h2>
                        <p class="text-slate-500 text-xs font-medium">{{ $stok->dataBarang->Nama_Barang }} ({{ $stok->ID_Stok }})</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Export Options -->
                    <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm mr-2">
                        <a href="{{ route('util.export', array_merge(request()->query(), ['type' => 'stok_history', 'stok_id' => $stok->ID_Stok])) }}" class="px-4 py-2 bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2" title="Ekspor ke Excel">
                            <i class="fas fa-file-excel text-emerald-500"></i> Excel
                        </a>
                    </div>

                    <form method="GET" action="" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#ca5b33]">
                            <i class="fas fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/10 focus:border-[#ca5b33] transition-all w-full sm:w-[240px]" 
                            placeholder="Cari keterangan...">
                    </form>
                    <a href="{{ route('data.stok') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 hover:bg-slate-200 transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgba(169,141,102,0.08)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar relative">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#B04025] text-white text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">
                        <th class="py-6 px-8 sticky left-0 bg-[#B04025] z-20 shadow-[4px_0_10px_-3px_rgba(0,0,0,0.2)]">Waktu</th>
                        <th class="py-6 px-8">Tipe</th>
                        <th class="py-6 px-8 text-center">Perubahan</th>
                        <th class="py-6 px-8">Keterangan</th>
                        <th class="py-6 px-8">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($history as $item)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="py-5 px-8 text-xs font-bold text-slate-500 whitespace-nowrap sticky left-0 bg-white z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] group-hover:bg-[#F6F4F0] transition-colors">
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-5 px-8">
                                <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $item->Tipe === 'Masuk' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    Stok {{ $item->Tipe }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <span class="text-sm font-black {{ $item->Tipe === 'Masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $item->Tipe === 'Masuk' ? '+' : '-' }}{{ $item->Kuantitas }}
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                <p class="text-sm text-slate-600 font-medium italic">"{{ $item->Keterangan }}"</p>
                            </td>
                            <td class="py-5 px-8 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-800">{{ $item->user->name ?? 'Sistem' }}</span>
                                    <span class="text-[9px] text-slate-400 font-mono">{{ $item->user_id }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <i class="fas fa-clock-rotate-left text-5xl mb-4"></i>
                                    <p class="text-xs font-black uppercase tracking-[0.2em]">Belum Ada Riwayat Perubahan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
            {{ $history->links() }}
        </div>
    </div>
</div>
@endsection
