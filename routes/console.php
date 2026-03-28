<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {

    // Hapus pesan yang lebih dari 7 hari
    DB::table('messages')
        ->where('created_at', '<', now()->subDays(7))
        ->delete();

})->dailyAt('11:19'); // dijalankan setiap hari jam 11:16


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Hapus dokumen PPID yang sudah melewati masa retensi
// Berjalan otomatis setiap hari pukul 00:05 dini hari
Schedule::command('ppid:hapus-kedaluwarsa')
    ->dailyAt('00:05')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/ppid-retensi.log'));
