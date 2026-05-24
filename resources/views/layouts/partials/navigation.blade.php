<nav class="mt-2 flex-1 overflow-y-auto overflow-x-hidden px-4 space-y-1 pb-10">
 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-6">Main Menu</p>
 <div x-show="!sidebarOpen" class="h-8"></div>
 
 <!-- Dashboard -->
 <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('/') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Dashboard</span>
 </a>

 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-8">Management</p>

 <!-- Data Dropdown -->
 <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('data/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">View Data</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('data/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
    @php
    $dataLinks = [
    ['route' => 'data.user', 'label' => 'Users', 'icon' => 'fa-users'],
    ['route' => 'data.pelanggan', 'label' => 'Customers', 'icon' => 'fa-address-book'],
    ['route' => 'data.pemasok', 'label' => 'Suppliers', 'icon' => 'fa-truck'],
    ['route' => 'data.barang.list', 'label' => 'Products', 'icon' => 'fa-boxes-stacked'],
    ['route' => 'data.pembelian', 'label' => 'Purchases', 'icon' => 'fa-cart-shopping'],
    ['route' => 'data.penjualan', 'label' => 'Sales', 'icon' => 'fa-file-invoice-dollar'],
    ];
    @endphp
    @foreach($dataLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
    <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-teal-600' : 'text-gray-400' }}"></i>
    {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <!-- Input Dropdown -->
 <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('input/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-circle-plus w-5 text-center transition-colors {{ Request::is('input/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Add Data</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('input/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
    @php
    $inputLinks = [];
    if (auth()->user()->role === 'admin') {
    $inputLinks[] = ['route' => 'input.user', 'label' => 'New User', 'icon' => 'fa-user-plus'];
    }
    $inputLinks = array_merge($inputLinks, [
    ['route' => 'input.pelanggan', 'label' => 'Customer', 'icon' => 'fa-address-card'],
    ['route' => 'input.pemasok', 'label' => 'Supplier', 'icon' => 'fa-truck-fast'],
    ['route' => 'input.barang', 'label' => 'Product', 'icon' => 'fa-box-open'],
    ['route' => 'input.pembelian', 'label' => 'Purchase', 'icon' => 'fa-cart-plus'],
    ['route' => 'input.penjualan', 'label' => 'Sale', 'icon' => 'fa-file-circle-plus'],
    ]);
    @endphp
    @foreach($inputLinks as $link)
    <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
    <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-teal-600' : 'text-gray-400' }}"></i>
    {{ $link['label'] }}
    </a>
    @endforeach
    </div>
 </template>
 </div>

 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-8">Analysis & Reports</p>

 <!-- Laporan Dropdown -->
 <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? (open = !open) : (sidebarOpen = true, open = true)" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('laporan/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Reports</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('laporan/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 
 <template x-if="open && sidebarOpen">
    <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
    <a href="{{ route('laporan.pembelian') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/pembelian') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
    <i class="fas fa-file-invoice-dollar mr-2.5 w-4 text-center {{ Request::is('laporan/pembelian') ? 'text-teal-600' : 'text-gray-400' }}"></i>
    Purchases
    </a>
    <a href="{{ route('laporan.penjualan') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/penjualan') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
    <i class="fas fa-receipt mr-2.5 w-4 text-center {{ Request::is('laporan/penjualan') ? 'text-teal-600' : 'text-gray-400' }}"></i>
    Sales
    </a>
    <a href="{{ route('laporan.stok') }}" wire:navigate class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/stok') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
    <i class="fas fa-cubes-stacked mr-2.5 w-4 text-center {{ Request::is('laporan/stok') ? 'text-teal-600' : 'text-gray-400' }}"></i>
    Stock
    </a>
    </div>
 </template>
 </div>
