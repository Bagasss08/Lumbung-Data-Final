<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Trik Sapu Jagat: Hapus index paksa pakai Raw SQL dan Try-Catch
        // Jadi kalau namanya beda, dia nggak akan bikin terminal merah/error.
        
        try {
            DB::statement('ALTER TABLE klasifikasi_surats DROP INDEX kode');
        } catch (\Exception $e) {} // Abaikan kalau gagal

        try {
            DB::statement('ALTER TABLE klasifikasi_surats DROP INDEX klasifikasi_surats_kode_index');
        } catch (\Exception $e) {} // Abaikan kalau gagal

        try {
            DB::statement('ALTER TABLE klasifikasi_surats DROP INDEX klasifikasi_surats_kode_unique');
        } catch (\Exception $e) {} // Abaikan kalau gagal

        // 2. Sekarang pintunya sudah pasti bersih, tinggal kita jebol jadi TEXT
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            $table->text('kode')->change();
        });
    }

    public function down(): void
    {
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            $table->string('kode', 255)->change();
        });
    }
};