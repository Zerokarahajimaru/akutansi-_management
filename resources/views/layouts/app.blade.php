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
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 shadow-xl flex-shrink-0 flex flex-col">
            <div class="p-6 text-xl font-bold text-indigo-500 flex items-center border-b border-slate-800">
                <i class="fas fa-vest-patches mr-3 text-2xl"></i> Cloth management
            </div>
            
            <nav class="mt-4 flex-1 overflow-y-auto px-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-4 rounded-lg transition-colors {{ Request::is('/') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-chart-pie mr-3 w-5 text-center"></i> 
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <!-- Data Dropdown -->
                <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full py-3 px-4 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-folder-open mr-3 w-5 text-center group-hover:text-indigo-400"></i>
                            <span class="font-medium text-sm">Manajemen Data</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak x-transition class="mt-1 space-y-1 ml-4 border-l border-slate-800 pl-4">
                        @php
                            $dataLinks = [
                                ['route' => 'data.admin', 'label' => 'Admin', 'adminOnly' => true],
                                ['route' => 'data.pelanggan', 'label' => 'Pelanggan'],
                                ['route' => 'data.pemasok', 'label' => 'Pemasok'],
                                ['route' => 'data.barang.list', 'label' => 'Barang'],
                                ['route' => 'data.pembelian', 'label' => 'Pembelian'],
                                ['route' => 'data.penjualan', 'label' => 'Penjualan'],
                            ];
                        @endphp
                        @foreach($dataLinks as $link)
                            @if(!isset($link['adminOnly']) || Auth::user()->role === 'admin')
                                <a href="{{ route($link['route']) }}" class="block py-2 px-4 text-xs font-medium rounded-md {{ Request::is('data/'.str_replace('data.', '', $link['route'])) ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">
                                    {{ $link['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Input Dropdown -->
                <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full py-3 px-4 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-plus-circle mr-3 w-5 text-center group-hover:text-indigo-400"></i>
                            <span class="font-medium text-sm">Input Transaksi</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak x-transition class="mt-1 space-y-1 ml-4 border-l border-slate-800 pl-4">
                        @php
                            $inputLinks = [
                                ['route' => 'input.admin', 'label' => 'Admin', 'adminOnly' => true],
                                ['route' => 'input.pelanggan', 'label' => 'Pelanggan'],
                                ['route' => 'input.pemasok', 'label' => 'Pemasok'],
                                ['route' => 'input.barang', 'label' => 'Barang'],
                                ['route' => 'input.pembelian', 'label' => 'Pembelian'],
                                ['route' => 'input.penjualan', 'label' => 'Penjualan'],
                            ];
                        @endphp
                        @foreach($inputLinks as $link)
                            @if(isset($link['adminOnly']) && Auth::user()->role !== 'admin')
                                <span class="block py-2 px-4 text-xs font-medium text-slate-600 opacity-50 cursor-not-allowed pointer-events-none">
                                    {{ $link['label'] }}
                                </span>
                            @else
                                <a href="{{ route($link['route']) }}" class="block py-2 px-4 text-xs font-medium rounded-md {{ Request::is('input/*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">
                                    {{ $link['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Laporan Dropdown -->
                <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full py-3 px-4 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                        <div class="flex items-center">
                            <i class="fas fa-file-contract mr-3 w-5 text-center group-hover:text-indigo-400"></i>
                            <span class="font-medium text-sm">Laporan</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak x-transition class="mt-1 space-y-1 ml-4 border-l border-slate-800 pl-4">
                        <a href="{{ route('laporan.pembelian') }}" class="block py-2 px-4 text-xs font-medium rounded-md text-slate-500 hover:text-white hover:bg-slate-800">Pembelian</a>
                        <a href="{{ route('laporan.penjualan') }}" class="block py-2 px-4 text-xs font-medium rounded-md text-slate-500 hover:text-white hover:bg-slate-800">Penjualan</a>
                        <a href="{{ route('laporan.stok') }}" class="block py-2 px-4 text-xs font-medium rounded-md text-slate-500 hover:text-white hover:bg-slate-800">Stok</a>
                    </div>
                </div>
            </nav>

            <!-- Logout Button in Sidebar -->
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full py-3 px-4 rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-500 transition-colors group">
                        <i class="fas fa-sign-out-alt mr-3 w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium text-sm">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-10 flex-shrink-0">
                <h1 class="text-lg font-semibold text-slate-800">@yield('title', 'Overview')</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right mr-4">
                        <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <img class="h-8 w-8 rounded-full bg-slate-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=6366f1&background=e0e7ff" alt="">
                </div>
            </header>

            <main class="flex-1 p-10 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>