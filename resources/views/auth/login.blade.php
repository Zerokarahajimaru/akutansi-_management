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
        <div class="w-1/2 bg-indigo-600 flex items-center justify-center p-8">
            <img src="{{ asset('Resource/cloth_shop_bg.jpg') }}" alt="Clothing Shop" class="w-full h-full object-cover rounded-lg">
        </div>

        <!-- Right Column: Login Form -->
        <div class="w-1/2 p-8">
            <h2 class="text-3xl font-bold text-slate-900 mb-6 text-center">Login to Cloth Management</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-slate-700 text-sm font-bold mb-2">Username:</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-slate-700 text-sm font-bold mb-2">Password:</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center text-slate-700">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        Remember Me
                    </label>
                    <a href="#" class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800">
                        Forgot Password?
                    </a>
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
