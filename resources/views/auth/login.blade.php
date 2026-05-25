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
<body class="bg-white flex items-center justify-center min-h-screen p-6 font-sans text-slate-800">
 
 <div class="w-full max-w-[28rem] bg-teal-50 shadow-sm shadow-teal-900/5 rounded-[2.5rem] overflow-hidden border border-teal-100 p-10 sm:p-14 transition-all duration-500 relative z-10">
 
 <div class="mb-10 text-center">
    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-3xl shadow-sm border border-teal-50 mb-8">
        <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-16 h-16 object-contain">
    </div>
    <h2 class="text-3xl font-black text-teal-950 tracking-tightest">Xyra<span class="text-teal-600">.id</span></h2>
    <p class="text-xs text-teal-700/50 font-bold uppercase tracking-[0.2em] mt-3 leading-relaxed">Portal Manajemen Inventori</p>
 </div>

 <form method="POST" action="{{ route('login') }}" class="space-y-8">
 @csrf

 <div class="space-y-2">
    <label for="username" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Identitas Pengguna</label>
    <div class="relative group">
        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-teal-300 group-focus-within:text-teal-600 transition-colors duration-300">
            <i class="fas fa-user-shield text-sm"></i>
        </span>
        <input type="text" name="username" id="username" 
            class="w-full bg-white border border-teal-200 rounded-[1.25rem] pl-12 pr-5 py-4 text-sm text-slate-800 placeholder-teal-200 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 @error('username') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" 
            placeholder="Masukkan username" required autofocus>
    </div>
    @error('username')
        <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}</p>
    @enderror
 </div>

 <div x-data="{ showPassword: false }" class="space-y-2">
    <label for="password" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kata Sandi Akun</label>
    <div class="relative group">
        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-teal-300 group-focus-within:text-teal-600 transition-colors duration-300">
            <i class="fas fa-lock text-sm"></i>
        </span>
        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" 
            class="w-full bg-white border border-teal-200 rounded-[1.25rem] pl-12 pr-14 py-4 text-sm text-slate-800 placeholder-teal-200 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 @error('password') border-rose-400 focus:ring-rose-500/10 focus:border-rose-500 @enderror" 
            placeholder="••••••••" required>
        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-5 flex items-center text-teal-300 hover:text-teal-600 focus:outline-none transition-colors duration-300">
            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
        </button>
    </div>
    @error('password')
        <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 flex items-center"><i class="fas fa-circle-exclamation mr-2"></i>{{ $message }}</p>
    @enderror
 </div>

 <div class="flex items-center justify-between px-1">
    <div class="flex items-center">
        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-teal-600 border-teal-200 rounded-lg focus:ring-teal-500 focus:ring-offset-0 bg-white transition-all cursor-pointer">
        <label for="remember" class="ml-2.5 block text-xs font-bold text-slate-500 cursor-pointer select-none hover:text-slate-700 transition-colors">Ingat Saya</label>
    </div>
 </div>

 <button type="submit" class="w-full bg-teal-600 text-white font-black py-4 rounded-[1.25rem] shadow-lg shadow-teal-500/20 hover:bg-teal-700 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-teal-500/20 active:scale-[0.98] transition-all duration-300 text-xs uppercase tracking-widest">
    Masuk Sekarang
 </button>
 </form>
 </div>
</body>
</html>
