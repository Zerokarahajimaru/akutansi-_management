<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\StokBarang;
use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\Pelanggan;
use App\Models\User;
use App\Auth\CachedUserProvider;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Register custom Cached Eloquent Provider
        Auth::provider('cached-eloquent', function ($app, array $config) {
            return new CachedUserProvider($app['hash'], $config['model']);
        });

        // Clear dashboard cache automatically whenever transactions or stock change
        $clearDashboard = function () {
            Cache::forget('dashboard_data_' . Carbon::today()->format('Y-m-d'));
        };

        Penjualan::saved($clearDashboard);
        Penjualan::deleted($clearDashboard);
        
        Pembelian::saved($clearDashboard);
        Pembelian::deleted($clearDashboard);
        
        StokBarang::saved($clearDashboard);
        StokBarang::deleted($clearDashboard);

        // --- Latency Optimization: Resource Caches ---
        
        // Invalidate Product List
        $clearBarang = function () { Cache::forget('active_barangs_list'); };
        DataBarang::saved($clearBarang);
        DataBarang::deleted($clearBarang);

        // Invalidate Supplier List
        $clearPemasok = function () { Cache::forget('active_pemasoks_list'); };
        Pemasok::saved($clearPemasok);
        Pemasok::deleted($clearPemasok);

        // Invalidate Customer List
        $clearPelanggan = function () { Cache::forget('active_pelanggans_list'); };
        Pelanggan::saved($clearPelanggan);
        Pelanggan::deleted($clearPelanggan);
    }
}
