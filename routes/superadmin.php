<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\LogController;
use App\Http\Controllers\SuperAdmin\KontakController;
use App\Http\Controllers\SuperAdmin\NotifikasiController;
use App\Http\Controllers\SuperAdmin\LiveChatController;
use App\Http\Controllers\SuperAdmin\PengumumanController;

// Semua route di sini otomatis akan memiliki prefix URL '/superadmin' 
// dan penamaan route 'superadmin.'

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Users
Route::resource('users', UserController::class);

// Settings
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

// Logs
Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

// Pemberitahuan
// Kontak Masuk
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');

// Kirim Pemberitahuan (Notifikasi)
Route::get('/notifikasi/create', [NotifikasiController::class, 'create'])->name('notifikasi.create');
Route::post('/notifikasi', [NotifikasiController::class, 'store'])->name('notifikasi.store');

// === LIVE CHAT (ADMIN & SUPERADMIN) ===
Route::get('/livechat', [LiveChatController::class, 'index'])->name('livechat.index');
Route::get('/livechat/fetch/{userId}', [LiveChatController::class, 'fetchMessages'])->name('livechat.fetch');
Route::post('/livechat/send', [LiveChatController::class, 'sendMessage'])->name('livechat.send');

// === PENGUMUMAN / BROADCAST ===
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');