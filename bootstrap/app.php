<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // 1. TAMBAHKAN IMPORT INI DI ATAS

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        
        // 2. TAMBAHKAN BLOK 'then' INI UNTUK MEMUAT ROUTE SUPERADMIN
        then: function () {
            // Memuat routes/superadmin.php dengan prefix 'superadmin' dan name 'superadmin.'
            // Kita langsung pasang middleware 'web' dan 'role:superadmin' (sesuaikan nama role-nya)
            Route::middleware(['web', 'role:superadmin'])
                ->prefix('superadmin')
                ->name('superadmin.')
                ->group(base_path('routes/superadmin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

    // --- UPDATE BAGIAN INI ---
    $middleware->alias([
        'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        'check.identitas.desa' => \App\Http\Middleware\CheckIdentitasDesa::class,
        'check.setup' => \App\Http\Middleware\CheckSetup::class, // tambah ini
    ]);
        // -------------------------

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();