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
    background: #ccf2f4; /* Ultra-light teal */
    border-radius: 10px;
 }
 ::-webkit-scrollbar-thumb:hover {
    background: #0d9488; /* Teal-600 */
 }
 ::-webkit-scrollbar-button {
    display: none !important;
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

 .custom-scrollbar::-webkit-scrollbar {
    width: 6px;
 }
 </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
 <!-- SPA Progress Bar -->
 <div class="fixed top-0 left-0 right-0 z-[10000] pointer-events-none">
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
    <!-- Main Content Wrapper -->
    <div 
        class="flex-1 flex flex-col transition-all duration-300 min-w-0 h-screen relative z-0"
        :class="sidebarOpen ? 'lg:pl-72' : 'pl-0'">
        
        <!-- Top Header -->
        <header class="h-20 bg-teal-50 border-b border-teal-100 flex items-center justify-between px-4 md:px-8 flex-shrink-0 z-[100] sticky top-0 shadow-sm shadow-teal-900/5">
            <div class="flex items-center gap-4 md:gap-6">
                <!-- Sidebar Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-slate-400 hover:text-teal-600 transition-all border border-teal-100 shadow-sm">
                    <i class="fas fa-bars-staggered transition-transform duration-300" :class="sidebarOpen ? 'rotate-90' : ''"></i>
                </button>

                <!-- Breadcrumbs -->
                <div class="flex items-center text-sm overflow-hidden text-slate-500">
                    <a href="{{ route('dashboard') }}" wire:navigate class="text-teal-600 font-bold hover:text-teal-700 transition-colors whitespace-nowrap">Beranda</a>
                    <i class="fas fa-chevron-right text-[10px] mx-2 md:mx-4 text-slate-300 flex-shrink-0"></i>
                    <span class="text-slate-400 font-medium tracking-tight truncate">@yield('title', 'Dashboard')</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end text-right">
                    <span class="text-xs font-black text-slate-800 tracking-tighter">{{ date('d M Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto custom-scrollbar bg-transparent relative">
            <div class="max-w-7xl mx-auto pb-10">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        class="fixed inset-0 bg-slate-900/40 z-[190] lg:hidden"
        x-transition:enter="transition opacity-100 duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition opacity-0 duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar - Fixed and Slideable -->
    <aside 
        x-cloak
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 w-72 bg-teal-50 flex flex-col z-[200] transition-transform duration-300 ease-in-out border-r border-teal-100/50 shadow-sm shadow-teal-900/5">
    
        <!-- Sidebar Branding -->
        <div class="h-20 flex items-center px-8 border-b border-teal-100/50">
            <a href="{{ route('dashboard') }}" wire:navigate.hover @click="sidebarOpen = false" class="flex items-center gap-3 group">
                <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="h-8 w-auto transition-transform group-hover:scale-105">
                <span class="text-xl font-black tracking-tighter text-teal-950">Xyra<span class="text-teal-600">.id</span></span>
            </a>
        </div> 

        <!-- Navigation Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @include('layouts.partials.navigation')
        </div>

        <!-- Sidebar Footer / User Info -->
        <div class="p-6 border-t border-teal-100/50 bg-teal-100/20">
            <div class="flex items-center justify-between mb-6 px-2">
                <div class="flex flex-col overflow-hidden">
                    <p class="text-sm font-bold text-teal-950 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-teal-600/60 uppercase tracking-widest font-black mt-0.5">{{ Auth::user()->role }}</p>
                </div>
                <a wire:navigate.hover href="{{ route('data.user.edit', Auth::user()->id) }}" @click="sidebarOpen = false"
                    class="transition-all duration-300 p-2.5 rounded-xl flex items-center justify-center text-teal-400 hover:text-teal-700 hover:bg-white shadow-sm border border-transparent hover:border-teal-100">
                    <i class="fas fa-gear text-sm"></i>
                </a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-white border border-teal-200 text-teal-700 text-xs font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all duration-300 group shadow-sm">
                    <i class="fas fa-arrow-right-from-bracket flex-shrink-0 group-hover:translate-x-0.5 transition-transform mr-3"></i>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>
 </div>

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
        // Only trigger if not already handled by a confirm() or similar
        if (e.defaultPrevented) return;
        
        e.preventDefault();

        window.Swal.fire({
            html: `
                <div class="text-left">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0 border border-rose-100">
                            <i class="fas fa-trash-can text-rose-600 text-sm"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 m-0">Konfirmasi Hapus</h3>
                    </div>
                    <p class="text-sm text-slate-500 m-0 pl-13 leading-relaxed font-medium">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan dan data akan hilang permanen.</p>
                </div>
            `,
            width: '26rem',
            padding: '1.5rem',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Ya, Hapus Saja',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl border border-slate-100 shadow-2xl bg-white',
                htmlContainer: 'm-0 p-0 text-left',
                actions: 'flex items-center justify-end gap-3 mt-8 w-full',
                confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md shadow-red-500/20 active:scale-95',
                cancelButton: 'px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black uppercase tracking-widest rounded-xl border border-slate-200 transition-all duration-300 active:scale-95'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
});
</script>

 @livewireScripts
</body>
</html>
