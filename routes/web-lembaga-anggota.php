<?php

use App\Http\Controllers\InfoDesa\LembagaAnggotaController;

Route::get('/create-bulk', [LembagaAnggotaController::class, 'createBulk'])->name('create-bulk');
Route::post('/store-bulk', [LembagaAnggotaController::class, 'storeBulk'])->name('store-bulk');
