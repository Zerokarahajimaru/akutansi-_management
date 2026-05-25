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
    background: #cbd5e1; /* Tailwind slate-300 */
    border-radius: 10px;
 }
 ::-webkit-scrollbar-thumb:hover {
    background: #94a3b8; /* Tailwind slate-400 */
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
    scrollbar-color: #cbd5e1 transparent;
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
 select:focus {
 background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%230d9488' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
 box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
 }

 select option {
 padding: 1rem;
 background-color: white;
 color: #1e293b;
 }

 .custom-scrollbar::-webkit-scrollbar {
    width: 6px;
 }
 </style>
</head>
<body class="bg-teal-50/30 text-slate-800 antialiased font-sans" x-data="{ sidebarOpen: true }">
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

 <div class="flex h-screen overflow-hidden relative">
 <!-- Global SweetAlert Handler -->
 @if(session('success') || session('error'))
 <script>
    function triggerFlashMessage() {
        const message = "{{ session('success') ?? session('error') }}";
        if (!message || message.trim() === '') return;
        if (window.hasShownFlashMessage) return;
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
                        <h3 class="text-base font-bold text-slate-900 m-0">${titleText}</h3>
                    </div>
                    <p class="text-sm text-slate-500 m-0 pl-11">${message}</p>
                </div>
            `,
            width: '24rem',
            padding: '1.25rem',
            showCloseButton: false,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            buttonsStyling: false,
            customClass: {
                popup: '!rounded-2xl !border !border-slate-100 !shadow-xl !bg-white !m-0',
                htmlContainer: '!m-0 !p-0 !text-left',
                actions: '!mt-5 !w-full !flex !justify-end !p-0',
                confirmButton: '!px-5 !py-2 !bg-slate-100 hover:!bg-slate-200 !text-slate-700 !text-sm !font-semibold !rounded-xl !transition-colors !m-0'
            }
        });
    }
    document.addEventListener('DOMContentLoaded', triggerFlashMessage);
    document.addEventListener('livewire:navigated', triggerFlashMessage);
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
                        <h3 class="text-base font-bold text-slate-900 m-0">Konfirmasi Hapus</h3>
                    </div>
                    <p class="text-sm text-slate-500 m-0 pl-11">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
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
                popup: '!rounded-2xl !border !border-slate-100 !shadow-xl !bg-white !m-0',
                htmlContainer: '!m-0 !p-0 !text-left',
                actions: '!mt-6 !w-full !flex !justify-end !gap-3 !p-0',
                confirmButton: '!px-4 !py-2 !bg-rose-600 hover:!bg-rose-700 !text-white !text-sm !font-semibold !rounded-xl !transition-colors !m-0 !shadow-sm',
                cancelButton: '!px-4 !py-2 !bg-slate-100 hover:!bg-slate-200 !text-slate-700 !text-sm !font-semibold !rounded-xl !transition-colors !m-0'
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

 <!-- Sidebar - Fixed and Slideable -->
 <aside 
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 w-72 bg-slate-950 flex flex-col z-50 transition-transform duration-300 ease-in-out shadow-[10px_0_40px_rgba(0,0,0,0.1)]">
 
    <!-- Sidebar Branding -->
    <div class="h-20 flex items-center px-8 border-b border-white/5">
        <a href="{{ route('dashboard') }}" wire:navigate.hover @click="sidebarOpen = false" class="flex items-center gap-3 group">
            <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-auto h-10 drop-shadow-sm group-hover:scale-105 transition-transform">
            <span class="text-xl font-black tracking-tighter text-white">Xyra<span class="text-teal-500">.id</span></span>
        </a>
    </div> 

    <!-- Navigation Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        @php
            $cacheKey = 'sidebar_nav_' . auth()->user()->role . '_' . Request::path();
        @endphp
        {!! Cache::remember($cacheKey, 86400, function() {
            return view('layouts.partials.navigation')->render();
        }) !!}
    </div>

    <!-- Sidebar Footer / User Info -->
    <div class="p-6 border-t border-white/5 bg-black/10">
        <div class="flex items-center justify-between mb-6 px-2">
            <div class="flex flex-col overflow-hidden">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mt-0.5">{{ Auth::user()->role }}</p>
            </div>
            <a wire:navigate.hover href="{{ route('data.user.edit', Auth::user()->id) }}" @click="sidebarOpen = false"
                class="transition-all duration-300 p-2.5 rounded-xl flex items-center justify-center group/settings {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'bg-teal-500/20 text-teal-400' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-gear text-sm {{ Request::is('data/user/'.Auth::user()->id.'/edit') ? 'fa-spin' : 'group-hover/settings:rotate-90 transition-transform duration-500' }}"></i>
            </a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center justify-center w-full py-3 px-4 rounded-2xl bg-slate-900 border border-white/5 text-slate-400 text-xs font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all duration-300 group shadow-lg">
                <i class="fas fa-arrow-right-from-bracket flex-shrink-0 group-hover:translate-x-0.5 transition-transform mr-3"></i>
                <span>Keluar Akun</span>
            </button>
        </form>
    </div>
 </aside>

 <!-- Main Content Wrapper -->
 <div 
    class="flex-1 flex flex-col transition-all duration-300 min-w-0 h-screen"
    :class="sidebarOpen ? 'lg:pl-72' : 'pl-0'">
    
    <!-- Top Header -->
    <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-teal-500/10 flex items-center justify-between px-8 sm:px-10 flex-shrink-0 z-40 sticky top-0">
        <div class="flex items-center gap-6">
            <!-- Sidebar Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-600 hover:bg-teal-50 hover:text-teal-600 transition-all border border-slate-200">
                <i class="fas fa-bars-staggered transition-transform duration-300" :class="sidebarOpen ? 'rotate-90' : ''"></i>
            </button>

            <!-- Breadcrumbs -->
            <div class="flex items-center text-sm">
                <a href="{{ route('dashboard') }}" wire:navigate class="text-teal-600 font-bold hover:text-teal-700 transition-colors">Beranda</a>
                <i class="fas fa-chevron-right text-[10px] mx-4 text-slate-300"></i>
                <span class="text-slate-400 font-medium tracking-tight">@yield('title', 'Dashboard')</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Digital Clock / Date (Optional visual polish) -->
            <div class="hidden md:flex flex-col items-end text-right">
                <span class="text-xs font-black text-slate-800 tracking-tighter">{{ date('d M Y') }}</span>
                <span class="text-[10px] text-teal-600 font-bold uppercase tracking-widest">Sistem Aktif</span>
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-1 p-8 sm:p-10 overflow-y-auto custom-scrollbar bg-transparent">
        <div class="max-w-7xl mx-auto pb-10">
            @yield('content')
        </div>
    </main>
 </div>

 <!-- Mobile Sidebar Backdrop -->
 <div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false" 
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
    x-transition:enter="transition opacity-100 duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition opacity-0 duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
 </div>

 </div>
 @livewireScripts
</body>
</html>
