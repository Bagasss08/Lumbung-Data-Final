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
