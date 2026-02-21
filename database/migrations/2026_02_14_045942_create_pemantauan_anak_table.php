<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Pemantauan bulanan anak 0-6 tahun (sub-menu Stunting)
     * Sesuai struktur OpenSID tweb_posyandu_pemantauan_balita
     */
    public function up(): void {
        Schema::create('pemantauan_anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kia_id')->constrained('kia')->cascadeOnDelete();
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandu')->nullOnDelete();
            $table->date('tanggal_pemantauan');
            $table->integer('bulan');       // 1-12
            $table->integer('tahun');
            $table->integer('umur_bulan');  // usia anak dalam bulan saat pemantauan
            $table->decimal('berat_badan', 5, 2)->nullable();    // kg
            $table->decimal('tinggi_badan', 5, 2)->nullable();   // cm
            $table->decimal('lingkar_kepala', 5, 2)->nullable(); // cm
            $table->decimal('lingkar_lengan', 5, 2)->nullable(); // cm LILA

            // Status Gizi (sesuai standar WHO/Kemenkes)
            $table->enum('status_bb_u', ['sangat_kurang', 'kurang', 'normal', 'lebih'])->nullable(); // BB/U
            $table->enum('status_tb_u', ['sangat_pendek', 'pendek', 'normal', 'tinggi'])->nullable(); // TB/U (stunting)
            $table->enum('status_bb_tb', ['sangat_kurus', 'kurus', 'normal', 'gemuk', 'obesitas'])->nullable(); // BB/TB

            $table->enum('dapat_vit_a', ['ya', 'tidak'])->default('tidak');
            $table->enum('status_imunisasi', ['lengkap', 'belum_lengkap', 'tidak_imunisasi'])->default('belum_lengkap');
            $table->enum('asi_eksklusif', ['ya', 'tidak', 'tidak_berlaku'])->default('tidak_berlaku');  // berlaku usia 0-6 bulan

            // Pengecekan perkembangan
            $table->enum('perkembangan', ['sesuai', 'meragukan', 'penyimpangan'])->nullable();

            $table->string('petugas', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pemantauan_anak');
    }
};
