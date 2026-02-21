<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Pemantauan bulanan ibu hamil (sub-menu Stunting)
     * Dicatat setiap bulan di posyandu
     * Sesuai struktur OpenSID tweb_posyandu_pemantauan_bumil
     */
    public function up(): void {
        Schema::create('pemantauan_bumil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kia_id')->constrained('kia')->cascadeOnDelete();
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandu')->nullOnDelete();
            $table->date('tanggal_pemantauan');
            $table->integer('bulan');       // 1-12
            $table->integer('tahun');
            $table->integer('usia_kehamilan')->nullable();  // dalam minggu
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('tekanan_darah_sistole', 5, 1)->nullable();
            $table->decimal('tekanan_darah_diastole', 5, 1)->nullable();
            $table->decimal('lingkar_lengan', 5, 2)->nullable();  // LILA dalam cm
            $table->enum('status_kehamilan', ['hamil', 'melahirkan'])->default('hamil');
            $table->enum('dapat_pil_fe', ['ya', 'tidak'])->default('tidak');
            $table->integer('jumlah_pil_fe')->default(0);
            $table->enum('imunisasi_tt', ['ya', 'tidak'])->default('tidak');
            $table->enum('dapat_vit_a', ['ya', 'tidak'])->default('tidak');
            $table->enum('dapat_tablet_tambah_darah', ['ya', 'tidak'])->default('tidak');
            $table->enum('pemeriksaan_lab', ['ya', 'tidak'])->default('tidak');
            $table->enum('konseling_gizi', ['ya', 'tidak'])->default('tidak');
            $table->enum('anemia', ['ya', 'tidak', 'tidak_diketahui'])->default('tidak_diketahui');
            $table->enum('kek', ['ya', 'tidak', 'tidak_diketahui'])->default('tidak_diketahui');  // Kurang Energi Kronis
            $table->string('petugas', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pemantauan_bumil');
    }
};
