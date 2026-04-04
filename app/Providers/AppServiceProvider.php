<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
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
    public function boot(): void {
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }

        Carbon::setLocale('id');

        try {
            $desa = Desa::first();
        } catch (\Exception $e) {
            $desa = null;
        }

        View::share('desa', $desa);
    }
}
