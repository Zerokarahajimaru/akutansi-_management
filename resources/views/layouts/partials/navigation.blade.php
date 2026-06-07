<nav class="mt-4 space-y-1 pb-10 custom-scrollbar overflow-x-hidden">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" wire:navigate @click="if(!isDesktop) sidebarOpen = false" 
        title="Dashboard Analitik"
        class="flex items-center py-3.5 px-6 transition-all duration-300 group {{ Request::is('/') ? 'bg-[#2F5C53] text-white border-r-4 border-slate-200' : 'text-white/80 hover:text-white hover:bg-white/50' }}"
        :class="sidebarOpen ? 'justify-start' : 'justify-center px-0 rounded-xl mx-2 border-r-0'">
        <div class="flex items-center" :class="sidebarOpen ? '' : 'justify-center w-full'">
            <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-[#A98D66]' : 'text-[#A98D66] group-hover:text-white' }}"></i>
            <span x-show="sidebarOpen" x-transition.opacity.duration.300 class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Dashboard</span>
        </div>
    </a>

    <!-- GROUP 1: DATA MASTER -->
    <div x-data="{ open: {{ Request::is('data/user*', 'data/pelanggan*', 'data/pemasok*', 'data/barang*', 'data/stok*') ? 'true' : 'false' }} }" class="space-y-1">
        <p x-show="sidebarOpen" class="text-slate-300 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Data Master</p>
        
        <button @click="if(!sidebarOpen) { sidebarOpen = true; open = true; } else { open = !open; }" 
            class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('data/user*', 'data/pelanggan*', 'data/pemasok*', 'data/barang*', 'data/stok*') ? 'bg-[#2F5C53] text-white border-r-4 border-slate-200' : 'text-white/80 hover:text-white hover:bg-white/50' }}"
            :class="sidebarOpen ? '' : 'justify-center px-0 rounded-xl mx-2 border-r-0'">
            <div class="flex items-center" :class="sidebarOpen ? '' : 'justify-center w-full'">
                <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-[#A98D66]' : 'text-slate-300 group-hover:text-[#A98D66]' }}"></i>
                <span x-show="sidebarOpen" x-transition.opacity.duration.300 class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Kelola Master</span>
            </div>
            <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180 text-[#A98D66]' : 'text-slate-300'"></i>
        </button>

        <template x-if="open && sidebarOpen">
            <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-white/20 pl-3">
                @php
                $masterLinks = [
                    ['route' => 'data.user', 'label' => 'Akun Pengguna', 'icon' => 'fa-users-cog', 'pattern' => 'data/user*'],
                    ['route' => 'data.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-user-tag', 'pattern' => 'data/pelanggan*'],
                    ['route' => 'data.pemasok', 'label' => 'Mitra Pemasok', 'icon' => 'fa-truck-loading', 'pattern' => 'data/pemasok*'],
                    ['route' => 'data.barang.list', 'label' => 'Katalog Produk', 'icon' => 'fa-tags', 'pattern' => 'data/barang*'],
                    ['route' => 'data.stok', 'label' => 'Stok', 'icon' => 'fa-boxes-stacked', 'pattern' => 'data/stok*'],
                ];
                @endphp
                @foreach($masterLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate @click="if(!isDesktop) sidebarOpen = false"
                    class="flex items-center py-2.5 px-3 text-xs font-bold rounded-xl transition-all {{ Request::is($link['pattern']) ? 'bg-[#2F5C53] text-white shadow-md shadow-black/20' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center {{ Request::is($link['pattern']) ? 'text-white' : 'text-[#A98D66]' }}"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
                @endforeach
            </div>
        </template>
    </div>

    <!-- GROUP 2: TRANSAKSI -->
    <div x-data="{ open: {{ Request::is('data/penjualan*', 'data/pembelian*') ? 'true' : 'false' }} }" class="space-y-1">
        <p x-show="sidebarOpen" class="text-slate-300 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Transaksi</p>
        
        <button @click="if(!sidebarOpen) { sidebarOpen = true; open = true; } else { open = !open; }" 
            class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('data/penjualan*', 'data/pembelian*') ? 'bg-[#2F5C53] text-white border-r-4 border-slate-200' : 'text-white/80 hover:text-white hover:bg-white/50' }}"
            :class="sidebarOpen ? '' : 'justify-center px-0 rounded-xl mx-2 border-r-0'">
            <div class="flex items-center" :class="sidebarOpen ? '' : 'justify-center w-full'">
                <i class="fas fa-exchange-alt w-5 text-center transition-colors {{ Request::is('data/penjualan*', 'data/pembelian*') ? 'text-[#A98D66]' : 'text-slate-300 group-hover:text-[#A98D66]' }}"></i>
                <span x-show="sidebarOpen" x-transition.opacity.duration.300 class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Riwayat Transaksi</span>
            </div>
            <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180 text-[#A98D66]' : 'text-slate-300'"></i>
        </button>

        <template x-if="open && sidebarOpen">
            <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-white/20 pl-3">
                @php
                $transaksiLinks = [
                    ['route' => 'data.penjualan', 'label' => 'Riwayat Penjualan', 'icon' => 'fa-shopping-bag', 'pattern' => 'data/penjualan*'],
                    ['route' => 'data.pembelian', 'label' => 'Riwayat Pembelian', 'icon' => 'fa-cart-plus', 'pattern' => 'data/pembelian*'],
                ];
                @endphp
                @foreach($transaksiLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate @click="if(!isDesktop) sidebarOpen = false"
                    class="flex items-center py-2.5 px-3 text-xs font-bold rounded-xl transition-all {{ Request::is($link['pattern']) ? 'bg-[#2F5C53] text-white shadow-md shadow-black/20' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center {{ Request::is($link['pattern']) ? 'text-white' : 'text-[#A98D66]' }}"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
                @endforeach
            </div>
        </template>
    </div>

    <!-- GROUP 3: ANALISIS & LAPORAN -->
    <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
        <p x-show="sidebarOpen" class="text-slate-300 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Analisis & Laporan</p>
        
        <button @click="if(!sidebarOpen) { sidebarOpen = true; open = true; } else { open = !open; }" 
            class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('laporan/*') ? 'bg-[#2F5C53] text-white border-r-4 border-slate-200' : 'text-white/80 hover:text-white hover:bg-white/50' }}"
            :class="sidebarOpen ? '' : 'justify-center px-0 rounded-xl mx-2 border-r-0'">
            <div class="flex items-center" :class="sidebarOpen ? '' : 'justify-center w-full'">
                <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-[#A98D66]' : 'text-slate-300 group-hover:text-[#A98D66]' }}"></i>
                <span x-show="sidebarOpen" x-transition.opacity.duration.300 class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Laporan</span>
            </div>
            <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180 text-[#A98D66]' : 'text-slate-300'"></i>
        </button>

        <template x-if="open && sidebarOpen">
            <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-white/20 pl-3">
                @php
                $laporanLinks = [
                    ['route' => 'laporan.pembelian', 'label' => 'Laporan Pembelian', 'icon' => 'fa-file-invoice-dollar', 'pattern' => 'laporan/pembelian*'],
                    ['route' => 'laporan.penjualan', 'label' => 'Laporan Penjualan', 'icon' => 'fa-receipt', 'pattern' => 'laporan/penjualan*'],
                    ['route' => 'laporan.stok', 'label' => 'Ketersediaan Stok', 'icon' => 'fa-cubes-stacked', 'pattern' => 'laporan/stok*'],
                ];
                @endphp
                @foreach($laporanLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate @click="if(!isDesktop) sidebarOpen = false"
                    class="flex items-center py-2.5 px-3 text-xs font-bold rounded-xl transition-all {{ Request::is($link['pattern']) ? 'bg-[#2F5C53] text-white shadow-md shadow-black/20' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center {{ Request::is($link['pattern']) ? 'text-white' : 'text-[#A98D66]' }}"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
                @endforeach
            </div>
        </template>
    </div>
</nav>