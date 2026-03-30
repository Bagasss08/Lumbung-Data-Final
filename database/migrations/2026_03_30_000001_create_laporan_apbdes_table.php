<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('laporan_apbdes', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->year('tahun');
            $table->tinyInteger('semester')->default(1)->comment('1 = Semester 1, 2 = Semester 2');
            $table->string('file')->nullable()->comment('Path file PDF');
            $table->timestamp('tgl_upload')->nullable();
            $table->timestamp('tgl_kirim')->nullable()->comment('Tanggal kirim ke OpenDK');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('laporan_apbdes');
    }
};
