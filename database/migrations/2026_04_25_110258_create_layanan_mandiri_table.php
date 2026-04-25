<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanan_mandiri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')
                ->constrained('penduduk')
                ->onDelete('cascade');
            $table->string('pin', 255)->nullable()->comment('Hashed 6-digit PIN');
            $table->string('no_telepon', 20)->nullable()->comment('No HP warga untuk verifikasi');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            $table->unique('penduduk_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('layanan_mandiri');
    }
};
