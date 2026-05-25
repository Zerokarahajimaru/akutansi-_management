<nav class="mt-4 space-y-1.5 pb-10">
 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 uppercase tracking-[0.2em]">Menu Utama</p>
 <div x-show="!sidebarOpen" class="h-8"></div>
 
 <!-- Dashboard -->
 <a href="{{ route('dashboard') }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false" 
    class="flex items-center py-3.5 px-6 transition-all duration-300 group {{ Request::is('/') ? 'text-white bg-teal-600 shadow-md shadow-teal-600/20 rounded-xl' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-100/50 rounded-xl mx-2' }}">
    <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-white' : 'text-teal-300 group-hover:text-teal-500' }}"></i>
    <span x-show="sidebarOpen" class="text-sm font-bold ml-3 whitespace-nowrap">Dashboard</span>
 </a>

 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Data Master</p>

 <!-- Data Dropdown -->
 <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1 px-2">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3.5 px-4 transition-all duration-300 group {{ Request::is('data/*') ? 'text-teal-900 bg-teal-100/50 rounded-xl' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-100/50 rounded-xl' }}">
    <div class="flex items-center">
        <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-teal-600' : 'text-teal-300 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-3 text-left whitespace-nowrap">Daftar Data</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('data/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    @php
    $dataLinks = [
    ['route' => 'data.user', 'label' => 'Akun Pengguna', 'icon' => 'fa-users'],
    ['route' => 'data.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-address-book'],
    ['route' => 'data.pemasok', 'label' => 'Mitra Pemasok', 'icon' => 'fa-truck'],
    ['route' => 'data.barang.list', 'label' => 'Katalog Produk', 'icon' => 'fa-box'],
    ['route' => 'data.pembelian', 'label' => 'Pembelian', 'icon' => 'fa-cart-shopping'],
    ['route' => 'data.penjualan', 'label' => 'Penjualan', 'icon' => 'fa-file-invoice-dollar'],
    ];
    @endphp
    @foreach($dataLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-white bg-teal-600 shadow-sm' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center opacity-60"></i>
        {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <!-- Input Dropdown -->
 <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1 px-2">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3.5 px-4 transition-all duration-300 group {{ Request::is('input/*') ? 'text-teal-900 bg-teal-100/50 rounded-xl' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-100/50 rounded-xl' }}">
    <div class="flex items-center">
        <i class="fas fa-circle-plus w-5 text-center transition-colors {{ Request::is('input/*') ? 'text-teal-600' : 'text-teal-300 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-3 text-left whitespace-nowrap">Input Transaksi</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('input/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    @php
    $inputLinks = [];
    if (auth()->user()->role === 'admin') {
    $inputLinks[] = ['route' => 'input.user', 'label' => 'Pengguna Baru', 'icon' => 'fa-user-plus'];
    }
    $inputLinks = array_merge($inputLinks, [
    ['route' => 'input.pelanggan', 'label' => 'Pelanggan Baru', 'icon' => 'fa-address-card'],
    ['route' => 'input.pemasok', 'label' => 'Pemasok Baru', 'icon' => 'fa-truck-fast'],
    ['route' => 'input.barang', 'label' => 'Produk Baru', 'icon' => 'fa-box-open'],
    ['route' => 'input.pembelian', 'label' => 'Entri Pembelian', 'icon' => 'fa-cart-plus'],
    ['route' => 'input.penjualan', 'label' => 'Entri Penjualan', 'icon' => 'fa-file-circle-plus'],
    ]);
    @endphp
    @foreach($inputLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-white bg-teal-600 shadow-sm' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas {{ $link['icon'] }} mr-3 w-4 text-center opacity-60"></i>
        {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <p x-show="sidebarOpen" class="text-slate-400 text-[10px] font-black px-6 mb-2 mt-8 uppercase tracking-[0.2em]">Analisis & Laporan</p>

 <!-- Laporan Dropdown -->
 <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1 px-2">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" 
    class="flex items-center justify-between w-full py-3.5 px-4 transition-all duration-300 group {{ Request::is('laporan/*') ? 'text-teal-900 bg-teal-100/50 rounded-xl' : 'text-slate-600 hover:text-teal-700 hover:bg-teal-100/50 rounded-xl' }}">
    <div class="flex items-center">
        <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-teal-300 group-hover:text-teal-500' }}"></i>
        <span x-show="sidebarOpen" class="text-sm font-bold ml-3 text-left whitespace-nowrap">Laporan</span>
    </div>
    <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-slate-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 mt-1 ml-4 border-l border-teal-200/50 pl-3">
    <a href="{{ route('laporan.pembelian') }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/pembelian') ? 'text-white bg-teal-600 shadow-sm' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-file-invoice-dollar mr-3 w-4 text-center opacity-60"></i>
        Pembelian
    </a>
    <a href="{{ route('laporan.penjualan') }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/penjualan') ? 'text-white bg-teal-600 shadow-sm' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-receipt mr-3 w-4 text-center opacity-60"></i>
        Penjualan
    </a>
    <a href="{{ route('laporan.stok') }}" wire:navigate @click="if(window.innerWidth < 1024) sidebarOpen = false"
        class="flex items-center py-2.5 px-3 text-xs font-bold rounded-lg transition-all {{ Request::is('laporan/stok') ? 'text-white bg-teal-600 shadow-sm' : 'text-slate-500 hover:text-teal-600 hover:bg-teal-50' }}">
        <i class="fas fa-cubes-stacked mr-3 w-4 text-center opacity-60"></i>
        Ketersediaan Stok
    </a>
    </div>
 </template>
 </div>
</nav>
