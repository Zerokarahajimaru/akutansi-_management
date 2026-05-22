<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Management - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar for Dropdowns */
        .select-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .select-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .select-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .select-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        /* Standard Select Styling (Fallback) */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding-right: 2.5rem !important;
        }
    ...
        select:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236366f1' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Dropdown Options Styling (Browser Support Limited, but better than nothing) */
        select option {
            padding: 1rem;
            background-color: white;
            color: #1e293b;
        }

        /* SweetAlert2 Professional Styling */
        .swal2-popup {
            padding: 2.5rem !important;
            border-radius: 2rem !important;
            border: 1px solid #f1f5f9 !important;
        }
        .swal2-title {
            color: #0f172a !important; /* slate-900 */
            font-weight: 800 !important;
            letter-spacing: -0.025em;
        }
        .swal2-html-container {
            color: #64748b !important; /* slate-500 */
            font-size: 0.95rem !important;
            line-height: 1.5 !important;
        }
        .swal2-confirm {
            background-color: #4f46e5 !important; /* indigo-600 */
            border-radius: 1rem !important;
            padding: 0.8rem 2.5rem !important;
            font-weight: 800 !important;
            font-size: 0.875rem !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3) !important;
        }
        .swal2-cancel {
            background-color: #f8fafc !important; /* slate-50 */
            color: #64748b !important; /* slate-500 */
            border-radius: 1rem !important;
            padding: 0.8rem 2.5rem !important;
            font-weight: 800 !important;
            font-size: 0.875rem !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
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
        <!-- Global SweetAlert Handler -->
        @if(session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const type = "{{ session('success') ? 'success' : 'error' }}";
                const message = "{{ session('success') ?? session('error') }}";
                
                window.Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'BERHASIL' : 'OOPS...',
                    text: message,
                    confirmButtonText: 'Tutup',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'swal2-confirm',
                        cancelButton: 'swal2-cancel'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            });
        </script>
        @endif
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
                            <i class="fas fa-layer-group w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
                            <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Lihat Data</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 ml-4 border-l border-slate-800/50 pl-4">
                        @php
                            $dataLinks = [
                                ['route' => 'data.user', 'label' => 'Data User', 'icon' => 'fa-users-gear'],
                                ['route' => 'data.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-address-book'],
                                ['route' => 'data.pemasok', 'label' => 'Pemasok', 'icon' => 'fa-truck-field'],
                                ['route' => 'data.barang.list', 'label' => 'Barang', 'icon' => 'fa-tags'],
                                ['route' => 'data.pembelian', 'label' => 'Pembelian', 'icon' => 'fa-file-invoice'],
                                ['route' => 'data.penjualan', 'label' => 'Penjualan', 'icon' => 'fa-file-signature'],
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
                            <i class="fas fa-circle-plus w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
                            <span x-show="sidebarOpen" class="font-bold text-sm ml-3 whitespace-nowrap">Tambah Data</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-1 ml-4 border-l border-slate-800/50 pl-4">
                        @php
                            $inputLinks = [];
                            
                            // Only admin can add new user (Admin/Pegawai)
                            if (auth()->user()->role === 'admin') {
                                $inputLinks[] = ['route' => 'input.user', 'label' => 'Tambah User', 'icon' => 'fa-user-plus'];
                            }

                            $inputLinks = array_merge($inputLinks, [
                                ['route' => 'input.pelanggan', 'label' => 'Pelanggan', 'icon' => 'fa-user-tag'],
                                ['route' => 'input.pemasok', 'label' => 'Pemasok', 'icon' => 'fa-truck-moving'],
                                ['route' => 'input.barang', 'label' => 'Barang', 'icon' => 'fa-boxes-packing'],
                                ['route' => 'input.pembelian', 'label' => 'Pembelian', 'icon' => 'fa-cart-plus'],
                                ['route' => 'input.penjualan', 'label' => 'Penjualan', 'icon' => 'fa-bag-shopping'],
                            ]);
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
                            <i class="fas fa-chart-simple w-5 text-center group-hover:text-indigo-400 transition-colors"></i>
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
                            <i class="fas fa-cubes-stacked mr-2 w-4 text-center opacity-70"></i>
                            Stok Barang
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 bg-slate-800/30 border-t border-slate-800/50 overflow-hidden">
                <div class="flex items-center justify-between px-2 mb-4">
                    <div x-show="sidebarOpen" class="flex flex-col overflow-hidden">
                        <p class="text-xs font-black text-white truncate uppercase tracking-tighter">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ Auth::user()->role }}</p>
                    </div>
                    <!-- Settings Gear Icon -->
                    <a x-show="sidebarOpen" href="{{ route('data.user.edit', Auth::user()->id) }}" 
                        class="transition-all duration-300 p-2 rounded-xl flex items-center justify-center group/settings {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'bg-indigo-600 text-white shadow-[0_0_15px_rgba(79,70,229,0.4)]' : 'text-slate-500 hover:text-white hover:bg-slate-700/50' }}">
                        <i class="fas fa-gear text-sm {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'fa-spin' : 'group-hover/settings:rotate-90 transition-transform duration-500' }}"></i>
                    </a>
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
