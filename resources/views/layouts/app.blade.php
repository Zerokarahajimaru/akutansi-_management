<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Management - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Professional Thin Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155; /* slate-700 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569; /* slate-600 */
        }
        
        /* Navigation Transitions */
        .nav-item-transition {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-slate-900 shadow-2xl flex-shrink-0 flex flex-col z-20 transition-all duration-300 ease-in-out relative">
            
            <!-- Toggle Button Inside Sidebar -->
            <button @click="sidebarOpen = !sidebarOpen" 
                class="absolute -right-3 top-20 bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-lg z-30 hover:bg-indigo-700 transition-colors focus:outline-none">
                <i class="fas text-[10px] transition-transform duration-300" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
            </button>

            <!-- Brand Logo -->
            <div class="p-6 flex items-center border-b border-slate-800/50 overflow-hidden">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex-shrink-0 flex items-center justify-center shadow-lg shadow-indigo-900/20 mr-3">
                    <i class="fas fa-vest-patches text-white text-xl"></i>
                </div>
                <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h2 class="text-white font-black text-lg leading-tight tracking-tight whitespace-nowrap">xyraid.id</h2>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-4 flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar px-4 space-y-1.5 pb-10">
                <p x-show="sidebarOpen" class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] px-4 mb-2 mt-4 whitespace-nowrap">Menu Utama</p>
                <div x-show="!sidebarOpen" class="h-8"></div>
                
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-4 rounded-xl nav-item-transition group {{ Request::is('/') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                    <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}"></i> 
                    <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Dashboard</span>
                </a>

                <p x-show="sidebarOpen" class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] px-4 mb-2 mt-6 whitespace-nowrap">Manajemen</p>

                <!-- Data Dropdown -->
                <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-3 px-4 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-database w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
                            <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Lihat Data</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 ml-4 border-l border-slate-800/50 pl-4">
                        @php
                            $dataLinks = [
                                ['route' => 'data.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-users'],
                                ['route' => 'data.pemasok', 'label' => 'Pemasok', 'icon' => 'fa-truck'],
                                ['route' => 'data.barang.list', 'label' => 'Barang', 'icon' => 'fa-box'],
                                ['route' => 'data.pembelian', 'label' => 'Pembelian', 'icon' => 'fa-cart-arrow-down'],
                                ['route' => 'data.penjualan', 'label' => 'Penjualan', 'icon' => 'fa-cash-register'],
                            ];
                        @endphp
                        @foreach($dataLinks as $link)
                            <a href="{{ route($link['route']) }}" class="flex items-center py-2 px-4 text-[13px] font-semibold rounded-lg {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-white' }}">
                                <i class="fas {{ $link['icon'] }} mr-2 w-4 text-center opacity-70"></i>
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Input Dropdown -->
                <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-3 px-4 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-plus-circle w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
                            <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Tambah Barang</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 ml-4 border-l border-slate-800/50 pl-4">
                        @php
                            $inputLinks = [
                                ['route' => 'input.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-user-plus'],
                                ['route' => 'input.pemasok', 'label' => 'Pemasok', 'icon' => 'fa-truck-ramp-box'],
                                ['route' => 'input.barang', 'label' => 'Barang', 'icon' => 'fa-box-open'],
                                ['route' => 'input.pembelian', 'label' => 'Pembelian', 'icon' => 'fa-basket-shopping'],
                                ['route' => 'input.penjualan', 'label' => 'Penjualan', 'icon' => 'fa-wallet'],
                            ];
                        @endphp
                        @foreach($inputLinks as $link)
                            <a href="{{ route($link['route']) }}" class="flex items-center py-2 px-4 text-[13px] font-semibold rounded-lg {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-white' }}">
                                <i class="fas {{ $link['icon'] }} mr-2 w-4 text-center opacity-70"></i>
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <p x-show="sidebarOpen" class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] px-4 mb-2 mt-6 whitespace-nowrap">Analisa & Laporan</p>

                <!-- Laporan Dropdown -->
                <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-3 px-4 rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-chart-pie w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
                            <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Laporan</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 ml-4 border-l border-slate-800/50 pl-4">
                        <a href="{{ route('laporan.pembelian') }}" class="flex items-center py-2 px-4 text-[13px] font-semibold rounded-lg {{ Request::is('laporan/pembelian') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-white' }}">
                            <i class="fas fa-file-invoice-dollar mr-2 w-4 text-center opacity-70"></i>
                            Pembelian
                        </a>
                        <a href="{{ route('laporan.penjualan') }}" class="flex items-center py-2 px-4 text-[13px] font-semibold rounded-lg {{ Request::is('laporan/penjualan') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-white' }}">
                            <i class="fas fa-receipt mr-2 w-4 text-center opacity-70"></i>
                            Penjualan
                        </a>
                        <a href="{{ route('laporan.stok') }}" class="flex items-center py-2 px-4 text-[13px] font-semibold rounded-lg {{ Request::is('laporan/stok') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-white' }}">
                            <i class="fas fa-boxes-stacked mr-2 w-4 text-center opacity-70"></i>
                            Stok Barang
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 bg-slate-800/30 border-t border-slate-800/50 overflow-hidden">
                <div class="flex items-center px-2 mb-4">
                    <!-- <img class="h-9 w-9 flex-shrink-0 rounded-xl bg-indigo-100 border-2 border-slate-700" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=6366f1&background=e0e7ff&bold=true" alt=""> -->
                    <div x-show="sidebarOpen" class="ml-3 overflow-hidden">
                        <p class="text-xs font-black text-white truncate uppercase tracking-tighter">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-rose-500/10 text-rose-500 text-xs font-black hover:bg-rose-500 hover:text-white transition-all shadow-lg hover:shadow-rose-900/20 group">
                        <i class="fas fa-power-off flex-shrink-0 group-hover:rotate-12 transition-transform"></i> 
                        <span x-show="sidebarOpen" class="ml-2 whitespace-nowrap">KELUAR SISTEM</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-10 flex-shrink-0 z-10 shadow-sm">
                <div class="flex items-center text-slate-400 text-sm font-bold">
                    <span class="text-indigo-600">Home</span>
                    <i class="fas fa-chevron-right text-[10px] mx-3 opacity-50"></i>
                    <span class="text-slate-800">@yield('title', 'Dashboard')</span>
                </div>
            </header>

            <main class="flex-1 p-8 overflow-y-auto bg-slate-50 custom-scrollbar">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
