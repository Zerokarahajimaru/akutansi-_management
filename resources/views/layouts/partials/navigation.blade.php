<nav class="mt-4 space-y-1 pb-10">
 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 uppercase tracking-[0.2em]">Menu Utama</p>
 <div x-show="!sidebarOpen" class="h-8"></div>
 
 <!-- Dashboard -->
 <a href="{{ route('dashboard') }}" wire:navigate @click="sidebarOpen = false" 
    class="flex items-center py-3 px-6 transition-all duration-300 group {{ Request::is('/') ? 'bg-teal-100/80 text-teal-900 border-r-4 border-teal-600' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-50' }}">
    <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-500' }}"></i>
    <span x-show="sidebarOpen" class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Dashboard Analitik</span>
 </a>

 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Manajemen Sistem</p>

 <!-- Data Dropdown -->
 <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('data/*') ? 'bg-teal-50 text-teal-900 border-r-4 border-teal-600' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-50' }}">
    <div class="flex items-center">
        <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Daftar Master Data</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('data/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    @php
    $dataLinks = [
    ['route' => 'data.user', 'label' => 'Akun Pengguna', 'icon' => 'fa-users', 'pattern' => 'data/user*'],
    ['route' => 'data.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-address-book', 'pattern' => 'data/pelanggan*'],
    ['route' => 'data.pemasok', 'label' => 'Mitra Pemasok', 'icon' => 'fa-truck', 'pattern' => 'data/pemasok*'],
    ['route' => 'data.barang.list', 'label' => 'Katalog Produk', 'icon' => 'fa-box', 'pattern' => 'data/barang*'],
    ['route' => 'data.pembelian', 'label' => 'Riwayat Pembelian', 'icon' => 'fa-cart-shopping', 'pattern' => 'data/pembelian*'],
    ['route' => 'data.penjualan', 'label' => 'Riwayat Penjualan', 'icon' => 'fa-file-invoice-dollar', 'pattern' => 'data/penjualan*'],
    ];
    @endphp
    @foreach($dataLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate @click="sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-xl transition-all {{ Request::is($link['pattern']) ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center {{ Request::is($link['pattern']) ? 'text-white' : 'opacity-60' }}"></i>
        {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <!-- Input Dropdown -->
 <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('input/*') ? 'bg-teal-50 text-teal-900 border-r-4 border-teal-600' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-50' }}">
    <div class="flex items-center">
        <i class="fas fa-circle-plus w-5 text-center transition-colors {{ Request::is('input/*') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-4 whitespace-nowrap tracking-tight">Input Transaksi</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('input/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    @php
    $inputLinks = [];
    if (auth()->user()->role === 'admin') {
    $inputLinks[] = ['route' => 'input.user', 'label' => 'Pengguna Baru', 'icon' => 'fa-user-plus', 'pattern' => 'input/user*'];
    }
    $inputLinks = array_merge($inputLinks, [
    ['route' => 'input.pelanggan', 'label' => 'Pelanggan Baru', 'icon' => 'fa-address-card', 'pattern' => 'input/pelanggan*'],
    ['route' => 'input.pemasok', 'label' => 'Pemasok Baru', 'icon' => 'fa-truck-fast', 'pattern' => 'input/pemasok*'],
    ['route' => 'input.barang', 'label' => 'Produk Baru', 'icon' => 'fa-box-open', 'pattern' => 'input/barang*'],
    ['route' => 'input.pembelian', 'label' => 'Entri Pembelian', 'icon' => 'fa-cart-plus', 'pattern' => 'input/pembelian*'],
    ['route' => 'input.penjualan', 'label' => 'Entri Penjualan', 'icon' => 'fa-file-circle-plus', 'pattern' => 'input/penjualan*'],
    ]);
    @endphp
    @foreach($inputLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate @click="sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-xl transition-all {{ Request::is($link['pattern']) ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center {{ Request::is($link['pattern']) ? 'text-white' : 'opacity-60' }}"></i>
        {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Analisis & Laporan</p>

 <!-- Laporan Dropdown -->
 <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3 px-6 transition-all duration-300 group {{ Request::is('laporan/*') ? 'bg-teal-50 text-teal-900 border-r-4 border-teal-600' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-50' }}">
    <div class="flex items-center">
        <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-4 text-left whitespace-nowrap tracking-tight">Buku Besar</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    <a href="{{ route('laporan.pembelian') }}" wire:navigate @click="sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/pembelian') ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-file-invoice-dollar mr-3 w-4 text-center {{ Request::is('laporan/pembelian') ? 'text-white' : 'opacity-60' }}"></i>
        Pembelian
    </a>
    <a href="{{ route('laporan.penjualan') }}" wire:navigate @click="sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/penjualan') ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-receipt mr-3 w-4 text-center {{ Request::is('laporan/penjualan') ? 'text-white' : 'opacity-60' }}"></i>
        Penjualan
    </a>
    <a href="{{ route('laporan.stok') }}" wire:navigate @click="sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/stok') ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-cubes-stacked mr-3 w-4 text-center {{ Request::is('laporan/stok') ? 'text-white' : 'opacity-60' }}"></i>
        Ketersediaan Stok
    </a>
    </div>
 </template>
 </div>
</nav>
