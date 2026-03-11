<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ppid_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppid_jenis_dokumen_id')->nullable()->constrained('ppid_jenis_dokumen')->nullOnDelete();
            $table->string('judul_dokumen');
            $table->integer('tahun')->nullable();
            $table->tinyInteger('bulan')->nullable()->comment('1-12');
            $table->string('waktu_retensi')->nullable()->comment('Contoh: 2 Tahun, Permanen');
            $table->date('tanggal_terbit')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ppid_dokumen');
    }
};
