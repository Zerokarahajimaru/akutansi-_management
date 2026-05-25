<nav class="mt-2 flex-1 overflow-y-auto overflow-x-hidden px-4 space-y-1 pb-10">
 <p x-show="sidebarOpen" class="text-slate-500 text-xs font-semibold px-4 mb-2 mt-6 uppercase tracking-wider">Menu Utama</p>
 <div x-show="!sidebarOpen" class="h-8"></div>
 
 <!-- Dashboard -->
 <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center py-2.5 px-4 transition-all duration-200 group {{ Request::is('/') ? 'text-white bg-teal-500/20 border-l-4 border-teal-500' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5 rounded-xl' }}">
 <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-teal-400' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Dashboard Analitik</span>
 </a>

 <p x-show="sidebarOpen" class="text-slate-500 text-xs font-semibold px-4 mb-2 mt-8 uppercase tracking-wider">Manajemen Sistem</p>

 <!-- Data Dropdown -->
 <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 transition-all duration-200 group {{ Request::is('data/*') ? 'text-white bg-teal-500/20 border-l-4 border-teal-500' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5 rounded-xl' }}">
 <div class="flex items-center">
 <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-teal-400' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Daftar Data</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('data/*') ? 'text-teal-400' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-white/5 pl-3">
    @php
    $dataLinks = [
    ['route' => 'data.user', 'label' => 'Akun Pengguna', 'icon' => 'fa-users'],
    ['route' => 'data.pelanggan', 'label' => 'Daftar Pelanggan', 'icon' => 'fa-address-book'],
    ['route' => 'data.pemasok', 'label' => 'Mitra Pemasok', 'icon' => 'fa-truck'],
    ['route' => 'data.barang.list', 'label' => 'Katalog Produk', 'icon' => 'fa-boxes-stacked'],
    ['route' => 'data.pembelian', 'label' => 'Riwayat Pembelian', 'icon' => 'fa-cart-shopping'],
    ['route' => 'data.penjualan', 'label' => 'Riwayat Penjualan', 'icon' => 'fa-file-invoice-dollar'],
    ];
    @endphp
    @foreach($dataLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-white bg-teal-500/10 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
    <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-teal-400' : 'text-slate-500' }}"></i>
    {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <!-- Input Dropdown -->
 <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 transition-all duration-200 group {{ Request::is('input/*') ? 'text-white bg-teal-500/20 border-l-4 border-teal-500' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5 rounded-xl' }}">
 <div class="flex items-center">
 <i class="fas fa-circle-plus w-5 text-center transition-colors {{ Request::is('input/*') ? 'text-teal-400' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Input Data Baru</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('input/*') ? 'text-teal-400' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-white/5 pl-3">
    @php
    $inputLinks = [];
    if (auth()->user()->role === 'admin') {
    $inputLinks[] = ['route' => 'input.user', 'label' => 'Pengguna Baru', 'icon' => 'fa-user-plus'];
    }
    $inputLinks = array_merge($inputLinks, [
    ['route' => 'input.pelanggan', 'label' => 'Pelanggan Baru', 'icon' => 'fa-address-card'],
    ['route' => 'input.pemasok', 'label' => 'Pemasok Baru', 'icon' => 'fa-truck-fast'],
    ['route' => 'input.barang', 'label' => 'Produk Baru', 'icon' => 'fa-box-open'],
    ['route' => 'input.pembelian', 'label' => 'Transaksi Pembelian', 'icon' => 'fa-cart-plus'],
    ['route' => 'input.penjualan', 'label' => 'Transaksi Penjualan', 'icon' => 'fa-file-circle-plus'],
    ]);
    @endphp
    @foreach($inputLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-white bg-teal-500/10 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
    <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-teal-400' : 'text-slate-500' }}"></i>
    {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <p x-show="sidebarOpen" class="text-slate-500 text-xs font-semibold px-4 mb-2 mt-8 uppercase tracking-wider">Analisis & Laporan</p>

 <!-- Laporan Dropdown -->
 <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 transition-all duration-200 group {{ Request::is('laporan/*') ? 'text-white bg-teal-500/20 border-l-4 border-teal-500' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5 rounded-xl' }}">
 <div class="flex items-center">
 <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-teal-400' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Buku Besar</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('laporan/*') ? 'text-teal-400' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-white/5 pl-3">
    <a href="{{ route('laporan.pembelian') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/pembelian') ? 'text-white bg-teal-500/10 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
    <i class="fas fa-file-invoice-dollar mr-2.5 w-4 text-center {{ Request::is('laporan/pembelian') ? 'text-teal-400' : 'text-slate-500' }}"></i>
    Laporan Pembelian
    </a>
    <a href="{{ route('laporan.penjualan') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/penjualan') ? 'text-white bg-teal-500/10 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
    <i class="fas fa-receipt mr-2.5 w-4 text-center {{ Request::is('laporan/penjualan') ? 'text-teal-400' : 'text-slate-500' }}"></i>
    Laporan Penjualan
    </a>
    <a href="{{ route('laporan.stok') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/stok') ? 'text-white bg-teal-500/10 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}">
    <i class="fas fa-cubes-stacked mr-2.5 w-4 text-center {{ Request::is('laporan/stok') ? 'text-teal-400' : 'text-slate-500' }}"></i>
    Ketersediaan Stok
    </a>
    </div>
 </template>
 </div>
</nav>
