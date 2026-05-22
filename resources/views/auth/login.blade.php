<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Column: Aesthetic Image -->
        <div class="w-1/2 hidden md:block">
            <img src="{{ asset('Resource/cloth_shop_bg.jpg') }}" alt="Clothing Shop" class="w-full h-full object-cover">
        </div>

        <!-- Right Column: Login Form -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl mb-4">
                    <i class="fas fa-vest-patches text-3xl"></i>
                </div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Login xyraid</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input type="text" name="username" id="username" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('username') border-rose-500 @enderror" placeholder="Masukkan username" required autofocus>
                    </div>
                    @error('username')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-widest">Password</label>
                        <a href="#" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" id="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('password') border-rose-500 @enderror" placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 bg-slate-50">
                    <label for="remember" class="ml-2 block text-sm text-slate-600 font-medium">Tetap masuk (Remember Me)</label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 transition-all shadow-lg shadow-indigo-200 text-sm">
                    MASUK SEKARANG
                </button>
            </form>
        </div>
    </div>
</body>
</html>
