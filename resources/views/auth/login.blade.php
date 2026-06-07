<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem | Xyra.id</title>
    <link rel="icon" type="image/png" href="{{ asset('Resource/xyra_logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen grid grid-cols-1 lg:grid-cols-2 font-sans text-slate-800 antialiased overflow-x-hidden">

    <!-- LEFT PANEL: BRANDING & DECORATION (Desktop Only) -->
    <section class="hidden lg:flex flex-col justify-between relative overflow-hidden bg-[#3B8A7F] p-16">
        <!-- Abstract Decorations -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#2F5C53] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
        <div class="absolute -bottom-24 -left-24 w-[600px] h-[600px] bg-[#2F5C53] rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-br from-[#2F5C53]/20 via-transparent to-[#2F5C53]/40 pointer-events-none"></div>

        <!-- Header Logo -->
        <div class="relative z-10 flex items-center gap-6">
            <div class="w-20 h-20 bg-transparent flex items-center justify-center transition-transform hover:scale-105 duration-500">
                <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-20 h-20 object-contain">
            </div>
            <div class="h-12 w-[2px] bg-white/20"></div>
            <div>
                <h1 class="text-4xl font-black text-[#A98D66] tracking-tightest whitespace-nowrap">Xyra.id</h1>
                <p class="text-[10px] text-white/60 font-bold uppercase tracking-[0.3em]">Official Inventory System</p>
            </div>
        </div>

        <!-- Center Content -->
        <div class="relative z-10 max-w-xl">
            <h2 class="text-6xl font-black text-white leading-[1.1] mb-8 tracking-tightest">
                Kelola Inventaris <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#A98D66] to-[#8E734B]">Bisnis Anda Lebih Cerdas.</span>
            </h2>
            <p class="text-lg text-slate-400 font-medium leading-relaxed">
                Platform manajemen inventori modern yang dirancang untuk kecepatan, akurasi, dan skalabilitas bisnis Anda di era digital.
            </p>
        </div>

        <!-- Footer -->
        <div class="relative z-10">
            <p class="text-xs text-slate-300 font-bold uppercase tracking-widest">© 2026 XYRA TECHNOLOGY INDONESIA</p>
        </div>
    </section>

    <!-- RIGHT PANEL: LOGIN FORM -->
    <main class="w-full flex items-center justify-center bg-white p-8 sm:p-12 lg:p-16 relative overflow-hidden">
        <!-- Decorative Blobs (Right Side) -->
        <div class="absolute top-1/4 -right-20 w-80 h-80 bg-[#A98D66]/5 rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-1/4 -left-20 w-80 h-80 bg-[#ca5b33]/5 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>

        <div class="w-full max-w-[400px] relative z-10">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-12 flex flex-col items-center">
                <div class="w-24 h-24 bg-transparent flex items-center justify-center mb-6">
                    <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Logo" class="w-24 h-24 object-contain ">
                </div>
                <h2 class="text-3xl font-black text-[#A98D66] tracking-tightest whitespace-nowrap">Xyra.id</h2>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em] mt-3">Inventory Portal</p>
            </div>

            <div class="mb-10 lg:block hidden">
                <h3 class="text-4xl font-black text-[#000000] mb-3 tracking-tightest">Selamat Datang.</h3>
                <p class="text-slate-500 font-medium">Silakan masuk untuk melanjutkan akses sistem.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Input -->
                <div class="space-y-2">
                    <label for="username" class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-[#ca5b33] transition-colors duration-300">
                            <i class="fas fa-user-shield"></i>
                        </span>
                        <input type="text" name="username" id="username" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-5 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/20 focus:border-[#ca5b33] transition-all duration-300 @error('username') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" 
                            placeholder="Contoh: admin_xyra" required autofocus>
                    </div>
                    @error('username')
                        <p class="text-[#B04025] text-[10px] font-bold mt-2 ml-1 flex items-center animate-shake">
                            <i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div x-data="{ showPassword: false }" class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label for="password" class="block text-[11px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-[#ca5b33] transition-colors duration-300">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-14 py-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-[#ca5b33]/20 focus:border-[#ca5b33] transition-all duration-300 @error('password') border-[#B04025]/40 focus:ring-[#B04025]/10 focus:border-[#B04025] @enderror" 
                            placeholder="••••••••" required>
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-300 hover:text-[#ca5b33] focus:outline-none transition-colors duration-300">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[#B04025] text-[10px] font-bold mt-2 ml-1 flex items-center animate-shake">
                            <i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-[#ca5b33] border-slate-300 bg-white rounded focus:ring-[#ca5b33] cursor-pointer transition-all">
                        <label for="remember" class="ml-2.5 block text-xs font-bold text-slate-500 cursor-pointer select-none hover:text-[#ca5b33] transition-colors">Ingat Sesi Saya</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#ca5b33] text-white font-black py-4 rounded-xl shadow-lg shadow-[#ca5b33]/20 hover:bg-[#B04025] hover:-translate-y-1 focus:ring-4 focus:ring-[#ca5b33]/30 active:scale-[0.98] transition-all duration-300 text-xs uppercase tracking-widest">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </main>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .tracking-tightest { letter-spacing: -0.05em; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .animate-shake { animation: shake 0.4s ease-in-out; }
    </style>
</body>
</html>
