<?php

use Illuminate\Support\Facades\Route;

// ============================================================
// IMPORT CONTROLLER KESEHATAN
// ============================================================
use App\Http\Controllers\Admin\kesehatan\PosyanduController;
use App\Http\Controllers\Admin\kesehatan\KiaController;
use App\Http\Controllers\Admin\kesehatan\VaksinController;
use App\Http\Controllers\Admin\kesehatan\StuntingController;
use App\Http\Controllers\Admin\kesehatan\PemantauanController;

// ============================================================
// ROUTE ADMIN KESEHATAN
// Taruh di dalam group middleware auth + prefix admin yang sudah ada
// Contoh:
//   Route::prefix('admin')->middleware(['auth'])->group(function () {
//       require __DIR__.'/kesehatan.php';
//   });
// ============================================================

Route::prefix('kesehatan')->name('kesehatan.')->group(function () {

    // ----------------------------------------------------------
    // 1. PENDATAAN
    // Sub-menu: Posyandu, KIA (Ibu Hamil + Anak)
    // ----------------------------------------------------------
    Route::prefix('pendataan')->name('pendataan.')->group(function () {

        // Posyandu
        Route::get('/posyandu',              [PosyanduController::class, 'index'])->name('posyandu');
        Route::get('/posyandu/tambah',       [PosyanduController::class, 'create'])->name('posyandu.create');
        Route::post('/posyandu',             [PosyanduController::class, 'store'])->name('posyandu.store');
        Route::get('/posyandu/{posyandu}',   [PosyanduController::class, 'show'])->name('posyandu.show');
        Route::get('/posyandu/{posyandu}/edit',   [PosyanduController::class, 'edit'])->name('posyandu.edit');
        Route::put('/posyandu/{posyandu}',   [PosyanduController::class, 'update'])->name('posyandu.update');
        Route::delete('/posyandu/{posyandu}', [PosyanduController::class, 'destroy'])->name('posyandu.destroy');

        // KIA - Kesehatan Ibu dan Anak
        Route::get('/kia',               [KiaController::class, 'index'])->name('kia');
        Route::get('/kia/tambah',        [KiaController::class, 'create'])->name('kia.create');
        Route::post('/kia',              [KiaController::class, 'store'])->name('kia.store');
        Route::get('/kia/{kia}',         [KiaController::class, 'show'])->name('kia.show');
        Route::get('/kia/{kia}/edit',    [KiaController::class, 'edit'])->name('kia.edit');
        Route::put('/kia/{kia}',         [KiaController::class, 'update'])->name('kia.update');
        Route::delete('/kia/{kia}',      [KiaController::class, 'destroy'])->name('kia.destroy');
    });

    // ----------------------------------------------------------
    // 2. PEMANTAUAN (Rekap Kesehatan Desa)
    // ----------------------------------------------------------
    Route::prefix('pemantauan')->name('pemantauan.')->group(function () {
        Route::get('/',                         [PemantauanController::class, 'index'])->name('index');
        Route::get('/rekap/tambah',             [PemantauanController::class, 'createRekap'])->name('rekap.create');
        Route::post('/rekap',                   [PemantauanController::class, 'storeRekap'])->name('rekap.store');
        Route::get('/rekap/{rekapKesehatan}/edit', [PemantauanController::class, 'editRekap'])->name('rekap.edit');
        Route::put('/rekap/{rekapKesehatan}',   [PemantauanController::class, 'updateRekap'])->name('rekap.update');
        Route::delete('/rekap/{rekapKesehatan}', [PemantauanController::class, 'destroyRekap'])->name('rekap.destroy');
    });

    // Alias untuk backward compat (nama route lama)
    Route::get('/pemantauan', [PemantauanController::class, 'index'])->name('pemantauan');

    // ----------------------------------------------------------
    // 3. VAKSIN
    // ----------------------------------------------------------
    Route::prefix('vaksin')->name('vaksin.')->group(function () {
        Route::get('/',              [VaksinController::class, 'index'])->name('index');
        Route::get('/tambah',        [VaksinController::class, 'create'])->name('create');
        Route::post('/',             [VaksinController::class, 'store'])->name('store');
        Route::get('/{vaksin}',      [VaksinController::class, 'show'])->name('show');
        Route::get('/{vaksin}/edit', [VaksinController::class, 'edit'])->name('edit');
        Route::put('/{vaksin}',      [VaksinController::class, 'update'])->name('update');
        Route::delete('/{vaksin}',   [VaksinController::class, 'destroy'])->name('destroy');
    });

    // ----------------------------------------------------------
    // 4. STUNTING
    // Sub-tab: Posyandu, KIA, Pemantauan Bumil, Pemantauan Anak, Scorecard
    // ----------------------------------------------------------
    Route::prefix('stunting')->name('stunting.')->group(function () {

        // Tab Posyandu (tampilan dari stunting)
        Route::get('/posyandu', [StuntingController::class, 'posyandu'])->name('posyandu');

        // Tab KIA
        Route::get('/kia', [StuntingController::class, 'kia'])->name('kia');

        // Tab Pemantauan Bulanan Ibu Hamil
        Route::get('/pemantauan-bumil',  [StuntingController::class, 'pemantauanBumil'])->name('pemantauan-bumil');
        Route::post('/pemantauan-bumil', [StuntingController::class, 'storePemantauanBumil'])->name('pemantauan-bumil.store');

        // Tab Pemantauan Bulanan Anak 0-6 Tahun
        Route::get('/pemantauan-anak',   [StuntingController::class, 'pemantauanAnak'])->name('pemantauan-anak');
        Route::post('/pemantauan-anak',  [StuntingController::class, 'storePemantauanAnak'])->name('pemantauan-anak.store');

        // Tab Scorecard Konvergensi
        Route::get('/scorecard',   [StuntingController::class, 'scorecard'])->name('scorecard');
        Route::post('/scorecard',  [StuntingController::class, 'storeScorecard'])->name('scorecard.store');
    });
});
