<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Rekap tahunan data kesehatan desa
     * Sesuai sub-menu Pendataan > Rekap Kesehatan di OpenSID
     */
    public function up(): void {
        Schema::create('rekap_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun')->unique();

            // Fasilitas & Tenaga Kesehatan
            $table->integer('jumlah_puskesmas')->default(0);
            $table->integer('jumlah_pustu')->default(0);       // Puskesmas Pembantu
            $table->integer('jumlah_posyandu')->default(0);
            $table->integer('jumlah_polindes')->default(0);
            $table->integer('jumlah_dokter')->default(0);
            $table->integer('jumlah_bidan')->default(0);
            $table->integer('jumlah_perawat')->default(0);
            $table->integer('jumlah_kader_aktif')->default(0);

            // Statistik Penduduk (snapshot tahunan)
            $table->integer('jumlah_ibu_hamil')->default(0);
            $table->integer('jumlah_balita')->default(0);      // 0-5 tahun
            $table->integer('jumlah_bayi')->default(0);        // 0-1 tahun
            $table->integer('jumlah_anak_pra_sekolah')->default(0); // 2-6 tahun
            $table->integer('jumlah_lansia')->default(0);      // > 60 tahun

            // Kasus Penyakit
            $table->integer('kasus_diare')->default(0);
            $table->integer('kasus_ispa')->default(0);
            $table->integer('kasus_dbd')->default(0);         // Demam Berdarah
            $table->integer('kasus_tb')->default(0);          // Tuberculosis
            $table->integer('kasus_malaria')->default(0);
            $table->integer('kasus_hipertensi')->default(0);
            $table->integer('kasus_diabetes')->default(0);
            $table->integer('kasus_lainnya')->default(0);

            // Cakupan Program
            $table->integer('cakupan_imunisasi_dasar')->default(0);   // persen
            $table->integer('cakupan_asi_eksklusif')->default(0);     // persen
            $table->integer('cakupan_kia')->default(0);                // persen
            $table->integer('prevalensi_stunting')->default(0);        // persen
            $table->integer('prevalensi_gizi_buruk')->default(0);      // persen

            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rekap_kesehatan');
    }
};
