<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>@yield('title') | Xyra.id</title>
 <link rel="icon" type="image/png" href="{{ asset('Resource/xyra_logo.png') }}">
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 <style>
 [x-cloak] { display: none !important; }

 /* Global Professional UI Scrollbar (Modern Standard) */
 ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
 }
 ::-webkit-scrollbar-track {
    background: transparent; 
 }
 ::-webkit-scrollbar-thumb {
    background: #d1d5db; /* Tailwind gray-300 */
    border-radius: 10px;
 }
 ::-webkit-scrollbar-thumb:hover {
    background: #9ca3af; /* Tailwind gray-400 */
 }
 ::-webkit-scrollbar-button {
    display: none !important; /* Strictly force hide up/down arrows */
 }

 /* Firefox scrollbar support */
 * {
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
 }

 /* Standard Select Styling (Fallback) */
 select {
 appearance: none;
 background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
 background-repeat: no-repeat;
 background-position: right 1rem center;
 background-size: 1rem;
 transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
 padding-right: 2.5rem !important;
 }
 select:focus {
 background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%230d9488' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
 box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
 }

 select option {
 padding: 1rem;
 background-color: white;
 color: #1f2937;
 }
 </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans" x-data="{ sidebarOpen: true }">
 <div class="flex h-screen overflow-hidden">
 <!-- Global SweetAlert Handler -->
 @if(session('success') || session('error'))
 <script>
document.addEventListener('DOMContentLoaded', function() {
    const isSuccess = "{{ session('success') ? 'true' : 'false' }}" === 'true';
    const message = "{{ session('success') ?? session('error') }}";
    const titleText = isSuccess ? 'Berhasil' : 'Gagal';
    const iconClass = isSuccess ? 'fa-check text-teal-600' : 'fa-triangle-exclamation text-rose-500';
    const bgClass = isSuccess ? 'bg-teal-50' : 'bg-rose-50';

    window.Swal.fire({
        html: `
            <div class="text-left">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full ${bgClass} flex items-center justify-center flex-shrink-0">
                        <i class="fas ${iconClass} text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 m-0">${titleText}</h3>
                </div>
                <p class="text-sm text-gray-500 m-0 pl-11">${message}</p>
            </div>
        `,
        width: '24rem',
        padding: '1.25rem',
        showCloseButton: false,
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        buttonsStyling: false,
        customClass: {
            popup: '!rounded-2xl !border !border-gray-100 !shadow-xl !bg-white !m-0',
            htmlContainer: '!m-0 !p-0 !text-left',
            actions: '!mt-5 !w-full !flex !justify-end !p-0',
            confirmButton: '!px-5 !py-2 !bg-gray-100 hover:!bg-gray-200 !text-gray-700 !text-sm !font-semibold !rounded-xl !transition-colors !m-0'
        }
    });
});
</script>
@endif

<script>
document.addEventListener('submit', function(e) {
    const form = e.target;
    const methodInput = form.querySelector('input[name="_method"]');

    // Check if it's a DELETE form
    if (methodInput && methodInput.value.toUpperCase() === 'DELETE') {
        e.preventDefault();

        window.Swal.fire({
            html: `
                <div class="text-left">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-triangle-exclamation text-rose-500 text-sm"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 m-0">Konfirmasi Hapus</h3>
                    </div>
                    <p class="text-sm text-gray-500 m-0 pl-11">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            `,
            width: '24rem',
            padding: '1.25rem',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: '!rounded-2xl !border !border-gray-100 !shadow-xl !bg-white !m-0',
                htmlContainer: '!m-0 !p-0 !text-left',
                actions: '!mt-6 !w-full !flex !justify-end !gap-3 !p-0',
                confirmButton: '!px-4 !py-2 !bg-rose-600 hover:!bg-rose-700 !text-white !text-sm !font-semibold !rounded-xl !transition-colors !m-0 !shadow-sm',
                cancelButton: '!px-4 !py-2 !bg-gray-100 hover:!bg-gray-200 !text-gray-700 !text-sm !font-semibold !rounded-xl !transition-colors !m-0'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
});
</script> <!-- Sidebar -->
 <aside 
 :class="sidebarOpen ? 'w-64' : 'w-20'"
 class="bg-white border-r border-gray-100 flex-shrink-0 flex flex-col z-20 transition-all duration-300 ease-in-out relative shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
 
 <!-- Brand Logo & Toggle Header -->
 <div class="h-20 relative flex items-center border-b border-gray-50 overflow-hidden w-full flex-shrink-0">
 <!-- Expanded State -->
 <div x-show="sidebarOpen" 
 x-transition:enter="transition opacity-100 duration-300 delay-100" 
 x-transition:enter-start="opacity-0" 
 x-transition:enter-end="opacity-100" 
 x-transition:leave="transition opacity-0 duration-100" 
 x-transition:leave-start="opacity-100" 
 x-transition:leave-end="opacity-0" 
 class="absolute inset-0 flex items-center justify-between px-6 w-64">
 <div class="flex items-center gap-3">
 <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-auto h-11 drop-shadow-sm">
 <span class="text-xl font-black tracking-tighter text-gray-900">Xyra.id</span>
 </div>
 <button @click="sidebarOpen = false" title="Collapse Sidebar" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors focus:outline-none">
 <i class="fas fa-chevron-left text-sm"></i>
 </button>
 </div>

 <!-- Collapsed State -->
 <div x-show="!sidebarOpen" x-cloak 
 x-transition:enter="transition opacity-100 duration-300 delay-100" 
 x-transition:enter-start="opacity-0" 
 x-transition:enter-end="opacity-100" 
 x-transition:leave="transition opacity-0 duration-100" 
 x-transition:leave-start="opacity-100" 
 x-transition:leave-end="opacity-0" 
 class="absolute inset-0 flex items-center justify-center w-20">
 <img @click="sidebarOpen = true" title="Expand Sidebar" src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-12 h-12 object-contain cursor-pointer hover:scale-110 hover:opacity-80 transition-all duration-300 drop-shadow-sm">
 </div>
 </div> 
 <!-- Navigation -->
 <nav class="mt-2 flex-1 overflow-y-auto overflow-x-hidden px-4 space-y-1 pb-10">
 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-6">Main Menu</p>
 <div x-show="!sidebarOpen" class="h-8"></div>
 
 <!-- Dashboard -->
 <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('/') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <i class="fas fa-chart-line w-5 text-center transition-transform group-hover:scale-110 {{ Request::is('/') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Dashboard</span>
 </a>

 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-8">Management</p>

 <!-- Data Dropdown -->
 <div x-data="{ open: {{ Request::is('data/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('data/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-layer-group w-5 text-center transition-colors {{ Request::is('data/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">View Data</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('data/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
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
 <a href="{{ route($link['route']) }}" class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
 <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('data/'.str_replace('data.', '', str_replace('.list', '', $link['route']))) ? 'text-teal-600' : 'text-gray-400' }}"></i>
 {{ $link['label'] }}
 </a>
 @endforeach
 </div>
 </div>

 <!-- Input Dropdown -->
 <div x-data="{ open: {{ Request::is('input/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('input/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-circle-plus w-5 text-center transition-colors {{ Request::is('input/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Add Data</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('input/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
 @php
 $inputLinks = [];
 
 // Only admin can add new user
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
 <a href="{{ route($link['route']) }}" class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
 <i class="fas {{ $link['icon'] }} mr-2.5 w-4 text-center {{ Request::is('input/'.str_replace('input.', '', $link['route'])) ? 'text-teal-600' : 'text-gray-400' }}"></i>
 {{ $link['label'] }}
 </a>
 @endforeach
 </div>
 </div>

 <p x-show="sidebarOpen" class="text-gray-400 text-xs font-semibold px-4 mb-2 mt-8">Analysis & Reports</p>

 <!-- Laporan Dropdown -->
 <div x-data="{ open: {{ Request::is('laporan/*') ? 'true' : 'false' }} }" class="space-y-1">
 <button @click="sidebarOpen ? open = !open : sidebarOpen = true" class="flex items-center justify-between w-full py-2.5 px-4 rounded-xl transition-all duration-200 group {{ Request::is('laporan/*') ? 'bg-teal-50 text-teal-700 font-bold shadow-sm ring-1 ring-teal-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
 <div class="flex items-center">
 <i class="fas fa-chart-simple w-5 text-center transition-colors {{ Request::is('laporan/*') ? 'text-teal-600' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
 <span x-show="sidebarOpen" class="text-sm ml-3 whitespace-nowrap">Reports</span>
 </div>
 <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs transition-transform duration-300 {{ Request::is('laporan/*') ? 'text-teal-500' : 'text-gray-400' }}" :class="open ? 'rotate-180' : ''"></i>
 </button>
 <div x-show="open && sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ml-4 border-l border-gray-100 pl-3">
 <a href="{{ route('laporan.pembelian') }}" class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/pembelian') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
 <i class="fas fa-file-invoice-dollar mr-2.5 w-4 text-center {{ Request::is('laporan/pembelian') ? 'text-teal-600' : 'text-gray-400' }}"></i>
 Purchases
 </a>
 <a href="{{ route('laporan.penjualan') }}" class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/penjualan') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
 <i class="fas fa-receipt mr-2.5 w-4 text-center {{ Request::is('laporan/penjualan') ? 'text-teal-600' : 'text-gray-400' }}"></i>
 Sales
 </a>
 <a href="{{ route('laporan.stok') }}" class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors {{ Request::is('laporan/stok') ? 'text-teal-700 bg-teal-50/50 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
 <i class="fas fa-cubes-stacked mr-2.5 w-4 text-center {{ Request::is('laporan/stok') ? 'text-teal-600' : 'text-gray-400' }}"></i>
 Stock
 </a>
 </div>
 </div>
 </nav>

 <!-- User Info & Logout -->
 <div class="p-4 border-t border-gray-50 bg-white">
 <div class="flex items-center justify-between px-2 mb-4">
 <div x-show="sidebarOpen" class="flex flex-col overflow-hidden">
 <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
 <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
 </div>
 <!-- Settings Gear Icon -->
 <a x-show="sidebarOpen" href="{{ route('data.user.edit', Auth::user()->id) }}" 
 class="transition-all duration-300 p-2 rounded-xl flex items-center justify-center group/settings {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'bg-teal-50 text-teal-600' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-50' }}">
 <i class="fas fa-gear text-sm {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'fa-spin' : 'group-hover/settings:rotate-90 transition-transform duration-500' }}"></i>
 </a>
 </div>
 <form action="{{ route('logout') }}" method="POST">
 @csrf
 <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-bold hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-300 group shadow-sm shadow-red-100/50">
 <i class="fas fa-arrow-right-from-bracket flex-shrink-0 group-hover:translate-x-0.5 transition-transform"></i> 
 <span x-show="sidebarOpen" class="ml-2 whitespace-nowrap">Sign Out</span>
 </button>
 </form>
 </div>
 </aside>

 <!-- Main Content -->
 <div class="flex-1 flex flex-col overflow-hidden bg-gray-50/50">
 <!-- Top Header -->
 <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-8 sm:px-10 flex-shrink-0 z-10 sticky top-0">
 <div class="flex items-center text-sm">
 <span class="text-teal-600 font-medium">Home</span>
 <i class="fas fa-chevron-right text-xs mx-3 text-gray-400"></i>
 <span class="text-gray-800 font-medium">@yield('title', 'Dashboard')</span>
 </div>
 </header>

 <main class="flex-1 p-8 sm:p-10 overflow-y-auto custom-scrollbar">
 <div class="max-w-7xl mx-auto">
 @yield('content')
 </div>
 </main>
 </div>
 </div>
</body>
</html>