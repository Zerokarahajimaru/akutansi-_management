<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login | Xyra.id</title>
 <link rel="icon" type="image/png" href="{{ asset('Resource/xyra_logo.png') }}">
 <script src="https://cdn.tailwindcss.com"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans text-gray-800">
 <div class="w-full max-w-md bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl overflow-hidden border border-gray-100 p-8 sm:p-12 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
 
 <div class="mb-8 text-center">
 <img src="{{ asset('Resource/xyra_logo.png') }}" alt="Xyra.id Logo" class="w-32 mx-auto mb-6 drop-shadow-sm hover:-trangray-y-0.5 transition-transform duration-300">
 <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome Back</h2>
 <p class="text-sm text-gray-500 mt-2">Please enter your details to sign in.</p>
 </div>

 <form method="POST" action="{{ route('login') }}" class="space-y-6">
 @csrf

 <div>
 <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
 <div class="relative group">
 <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-teal-500 transition-colors">
 <i class="fas fa-user text-sm"></i>
 </span>
 <input type="text" name="username" id="username" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('username') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror" placeholder="Enter your username" required autofocus>
 </div>
 @error('username')
 <p class="text-red-500 text-xs font-medium mt-1.5 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div>
 <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
 <div class="relative group">
 <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-teal-500 transition-colors">
 <i class="fas fa-lock text-sm"></i>
 </span>
 <input type="password" name="password" id="password" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('password') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror" placeholder="••••••••" required>
 </div>
 @error('password')
 <p class="text-red-500 text-xs font-medium mt-1.5 flex items-center"><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $message }}</p>
 @enderror
 </div>

 <div class="flex items-center">
 <div class="flex items-center h-5">
 <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 focus:ring-offset-0 bg-white transition-colors cursor-pointer">
 </div>
 <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">Remember me</label>
 </div>

 <button type="submit" class="w-full bg-teal-600 text-white font-semibold py-3.5 rounded-xl hover:bg-teal-700 hover:-trangray-y-0.5 focus:outline-none focus:ring-4 focus:ring-teal-500/30 transition-all duration-300 shadow-md shadow-teal-600/20 text-sm">
 Sign In
 </button>
 </form>
 </div>
</body>
</html>