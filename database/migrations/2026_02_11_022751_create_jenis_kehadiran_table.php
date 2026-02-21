<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jenis_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kehadiran', 10)->unique();
            $table->string('nama_kehadiran', 100);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jenis_kehadiran');
    }
};
