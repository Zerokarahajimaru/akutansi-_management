<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login | Xyra.id</title>
 <link rel="icon" type="image/png" href="{{ asset('Resource/xyra_logo.png') }}">
 <script src="https://cdn.tailwindcss.com"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 to-teal-950 flex items-center justify-center min-h-screen p-4 font-sans text-slate-800">
 <div class="w-full max-w-md backdrop-blur-xl bg-white/95 shadow-2xl rounded-[2rem] overflow-hidden border border-white/20 p-8 sm:p-12 transition-all duration-300">
 
 <div class="mb-8 text-center">
 <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-32 mx-auto mb-6 drop-shadow-sm hover:-translate-y-0.5 transition-transform duration-300">
 <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome Back</h2>
 <p class="text-sm text-slate-500 mt-2">Silakan masukkan username dan password Anda untuk masuk.</p>
 </div>

 <form method="POST" action="{{ route('login') }}" class="space-y-6">
 @csrf

 <div>
 <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
 <div class="relative group">
 <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-teal-500 transition-colors">
 <i class="fas fa-user text-sm"></i>
 </span>
 <input type="text" name="username" id="username" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('username') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror" placeholder="Enter your username" required autofocus>
 </div>
 @error('username')
 <p class="text-red-500 text-xs font-medium mt-1.5 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div x-data="{ showPassword: false }">
 <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
 <div class="relative group">
 <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-teal-500 transition-colors">
 <i class="fas fa-lock text-sm"></i>
 </span>
 <input :type="showPassword ? 'text' : 'password'" name="password" id="password" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-11 pr-12 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('password') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror" placeholder="••••••••" required>
 <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
 <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
 </button>
 </div>
 @error('password')
 <p class="text-red-500 text-xs font-medium mt-1.5 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div class="flex items-center">
 <div class="flex items-center h-5">
 <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-teal-600 border-slate-300 rounded focus:ring-teal-500 focus:ring-offset-0 bg-white transition-colors cursor-pointer">
 </div>
 <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">Remember me</label>
 </div>

 <button type="submit" class="w-full bg-teal-600 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-teal-500/30 hover:bg-teal-700 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-teal-500/30 transition-all duration-300 text-sm">
 Sign In
 </button>
 </form>
 </div>
</body>
</html>