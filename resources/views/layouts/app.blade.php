<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joki Super - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <div class="w-64 bg-white shadow-md">
            <div class="p-6 text-xl font-bold text-blue-600">Dashboard</div>
            <nav class="mt-4">
                <a href="/" class="flex items-center py-3 px-6 {{ Request::is('/') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fas fa-th-large mr-3"></i> Dashboard
                </a>
                <a href="/stock" class="flex items-center py-3 px-6 {{ Request::is('stock') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fas fa-box mr-3"></i> Data Barang
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-shopping-cart mr-3"></i> Penjualan
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-shopping-bag mr-3"></i> Pembelian
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-file-alt mr-3"></i> Laporan
                </a>
            </nav>
        </div>

        <div class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </div>
    </div>
</body>
</html>