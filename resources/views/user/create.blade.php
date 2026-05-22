@extends('layouts.app')

@section('title', 'Daftarkan Akun')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-bold text-slate-800 text-xl">Daftarkan Pengguna Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Buat akun untuk akses sistem Admin atau Pegawai.</p>
        </div>

        <form action="{{ route('input.user') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 p-4 rounded-xl text-sm font-medium border border-rose-100">
                {{ session('error') }}
            </div>
            @endif

            <div class="space-y-4">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Nama Lengkap" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Username -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Username</label>
                        <input type="text" name="username" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="username_login" required>
                    </div>

                    <!-- Role -->
                    <div class="space-y-2" x-data="{ 
                        open: false, 
                        selected: 'pegawai',
                        options: [
                            {val: 'pegawai', label: 'Pegawai'},
                            {val: 'admin', label: 'Admin'}
                        ]
                    }">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hak Akses (Role)</label>
                        <div class="relative">
                            <input type="hidden" name="role" :value="selected">
                            <button @click="open = !open" type="button" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-indigo-500 transition-all">
                                <span x-text="options.find(o => o.val === selected).label" class="text-slate-700 font-medium"></span>
                                <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-cloak 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 max-h-60 overflow-y-auto select-scrollbar">
                                <template x-for="option in options" :key="option.val">
                                    <div @click="selected = option.val; open = false" 
                                        class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"
                                        :class="selected === option.val ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:bg-slate-50'">
                                        <span x-text="option.label"></span>
                                        <i x-show="selected === option.val" class="fas fa-check text-xs"></i>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password Baru</label>
                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••" required>
                </div>

                <!-- No Telp -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor Telepon</label>
                    <input type="text" name="NoTelp_User" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="08xxxx" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end space-x-3">
                <a href="{{ route('data.user') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Daftarkan Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
