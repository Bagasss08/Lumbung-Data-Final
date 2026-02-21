<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
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
