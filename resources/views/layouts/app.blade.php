<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>@yield('title') | Xyra.id</title>
 <link rel="icon" type="image/png" href="{{ asset('Resource/xyra_logo.png') }}">
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 @livewireStyles
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
    display: none !important;
    width: 0 !important;
    height: 0 !important;
 }

 /* Hide Number Input Spinners */
 input::-webkit-outer-spin-button,
 input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
 }
 input[type=number] {
    -moz-appearance: textfield !important;
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
 <!-- SPA Progress Bar -->
 <div class="fixed top-0 left-0 right-0 z-[100] pointer-events-none">
    <div 
        x-data="{ show: false, progress: 0 }"
        x-on:livewire:navigate.start="show = true; progress = 0; $nextTick(() => progress = 30)"
        x-on:livewire:navigate.end="progress = 100; setTimeout(() => { show = false; progress = 0 }, 300)"
        x-show="show"
        x-transition:leave="transition opacity-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="h-1 bg-teal-600 shadow-[0_0_10px_rgba(13,148,136,0.5)] transition-all duration-500 ease-out"
        :style="`width: ${progress}%`"
    ></div>
 </div>

 <div class="flex h-screen overflow-hidden">
 <!-- Global SweetAlert Handler -->
 @if(session('success') || session('error'))
 <script>
    function triggerFlashMessage() {
        const message = "{{ session('success') ?? session('error') }}";
        
        // 1. Immediately exit if there's no actual message (prevents JS logic errors)
        if (!message || message.trim() === '') return;

        // 2. SPA Guard: Exit if we already showed a message in this DOM lifecycle
        if (window.hasShownFlashMessage) return;

        // 3. Lock the guard synchronously BEFORE firing the alert
        window.hasShownFlashMessage = true;

        const isSuccess = "{{ session('success') ? 'true' : 'false' }}" === 'true';
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
    }

    // Attach to both events, but the guard will stop duplicates
    document.addEventListener('DOMContentLoaded', triggerFlashMessage);
    document.addEventListener('livewire:navigated', triggerFlashMessage);

    // --- Pagination SPA Fix ---
    function applyPaginationSPA() {
        const paginationLinks = document.querySelectorAll('nav[role="navigation"] a, .pagination a');
        paginationLinks.forEach(link => {
            if (!link.hasAttribute('wire:navigate')) {
                link.setAttribute('wire:navigate', '');
                link.setAttribute('wire:navigate.hover', '');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', applyPaginationSPA);
    document.addEventListener('livewire:navigated', applyPaginationSPA);
</script>
@endif

<script>
document.addEventListener('submit', function(e) {
    const form = e.target;
    const methodInput = form.querySelector('input[name="_method"]');

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
</script> 

 <!-- Sidebar -->
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
 <a href="{{ route('dashboard') }}" wire:navigate.hover class="flex items-center gap-3 group">
 <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-auto h-11 drop-shadow-sm group-hover:scale-105 transition-transform">
 <span class="text-xl font-black tracking-tighter text-gray-900">Xyra<span class="text-teal-600">.id</span></span>
 </a>
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
 @php
    $cacheKey = 'sidebar_nav_' . auth()->user()->role . '_' . Request::path();
 @endphp

 {!! Cache::remember($cacheKey, 86400, function() {
    return view('layouts.partials.navigation')->render();
 }) !!}
 </nav>

 <!-- User Info & Logout -->
 <div class="p-4 border-t border-gray-50 bg-white">
 <div class="flex items-center justify-between px-2 mb-4">
 <div x-show="sidebarOpen" class="flex flex-col overflow-hidden">
 <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
 <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
 </div>
 <!-- Settings Gear Icon -->
 <a wire:navigate.hover x-show="sidebarOpen" href="{{ route('data.user.edit', Auth::user()->id) }}" 
 class="transition-all duration-300 p-2 rounded-xl flex items-center justify-center group/settings {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'bg-teal-50 text-teal-600' : 'text-gray-400 hover:text-gray-700 hover:bg-gray-50' }}">
 <i class="fas fa-gear text-sm {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'fa-spin' : 'group-hover/settings:rotate-90 transition-transform duration-500' }}"></i>
 </a>
 </div>
 <form action="{{ route('logout') }}" method="POST">
 @csrf
 <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-bold hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-300 group shadow-sm shadow-red-100/50">
 <i class="fas fa-arrow-right-from-bracket flex-shrink-0 group-hover:translate-x-0.5 transition-transform"></i>
 <span x-show="sidebarOpen" class="ml-2 whitespace-nowrap">Keluar Akun</span>
 </button> </form>
 </div>
 </aside>

 <!-- Main Content -->
 <div class="flex-1 flex flex-col overflow-hidden bg-gray-50/50">
 <!-- Top Header -->
 <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-8 sm:px-10 flex-shrink-0 z-10 sticky top-0">
 <div class="flex items-center text-sm">
 <a href="{{ route('dashboard') }}" wire:navigate class="text-teal-600 font-medium hover:underline">Beranda</a>
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
 @livewireScripts
</body>
</html>