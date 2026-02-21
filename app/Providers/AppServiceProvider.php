<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Desa; // Sesuaikan dengan nama Model kamu

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
        // Ambil data desa pertama kali, jika tabel kosong hindari error dengan optional/null
        try {
            $desa = Desa::first(); 
        } catch (\Exception $e) {
            $desa = null;
        }

        // Bagikan variabel $desa ke SEMUA view (*)
        View::share('desa', $desa);
    }
}
