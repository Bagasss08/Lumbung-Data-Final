<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('idm_indikator', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->integer('no_urut');
            $table->string('dimensi', 10)->comment('IKS | IKE | IKL');
            $table->string('nama_indikator', 100);

            // Skor 0–5
            $table->tinyInteger('skor')->default(0);

            // Keterangan kondisi saat ini
            $table->text('keterangan')->nullable();

            // Kegiatan yang dapat dilakukan jika skor tidak maksimal
            $table->text('kegiatan_dilakukan')->nullable();

            // Nilai tambah terhadap IDM jika skor max
            $table->decimal('nilai_tambah', 10, 8)->nullable();

            // Yang dapat melaksanakan kegiatan
            $table->string('pelaksana_pusat', 100)->nullable();
            $table->string('pelaksana_provinsi', 100)->nullable();
            $table->string('pelaksana_kabupaten', 100)->nullable();
            $table->string('pelaksana_desa', 100)->nullable();
            $table->string('pelaksana_csr', 100)->nullable();    // ← tambahan
            $table->string('pelaksana_lainnya', 100)->nullable(); // ← tambahan
            $table->text('catatan')->nullable();

            $table->unique(['tahun', 'no_urut']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('idm_indikator');
    }
};
