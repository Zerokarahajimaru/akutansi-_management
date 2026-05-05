@extends('layouts.app')

@section('title', 'Data Pemasok')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
        <h2 class="font-bold text-slate-800">Daftar Pemasok</h2>
        <a href="{{ route('input.pemasok') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-colors">Tambah Pemasok</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black">
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6">No. HP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pemasoks as $p)
                <tr>
                    <td class="py-4 px-6 text-xs text-slate-400 font-mono">{{ $p->ID_Pemasok }}</td>
                    <td class="py-4 px-6 text-sm font-bold">{{ $p->Nama_Pemasok }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $p->Alamat }}</td>
                    <td class="py-4 px-6 text-sm text-slate-600">{{ $p->No_HP }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
