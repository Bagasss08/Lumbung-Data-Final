<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * KIA = Kesehatan Ibu dan Anak
     * Tabel ini mencatat data ibu dan anaknya (0-6 tahun)
     * Sesuai struktur OpenSID tweb_kia
     */
    public function up(): void {
        Schema::create('kia', function (Blueprint $table) {
            $table->id();
            $table->string('no_register', 50)->unique()->nullable();  // No. Registrasi KIA
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandu')->nullOnDelete();

            // Data Ibu
            $table->string('nik_ibu', 20)->nullable();
            $table->string('nama_ibu', 100);
            $table->date('tgl_lahir_ibu')->nullable();
            $table->integer('umur_ibu')->nullable();
            $table->string('alamat_ibu', 255)->nullable();
            $table->string('dusun', 100)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->integer('kehamilan_ke')->default(1);
            $table->date('hpht')->nullable();              // Hari Pertama Haid Terakhir
            $table->date('taksiran_lahir')->nullable();    // Tanggal Perkiraan Lahir
            $table->enum('status_kehamilan', ['hamil', 'melahirkan', 'selesai'])->default('hamil');
            $table->enum('status_resiko', ['normal', 'resiko_rendah', 'resiko_tinggi'])->default('normal');
            $table->string('tempat_pemeriksaan', 100)->nullable();  // puskesmas/rs/bidan/posyandu
            $table->date('tanggal_melahirkan')->nullable();
            $table->enum('jenis_persalinan', ['normal', 'sesar', 'vakum'])->nullable();
            $table->string('penolong_persalinan', 100)->nullable();  // bidan/dokter/dukun

            // Data Anak (bisa kosong jika masih hamil)
            $table->string('nik_anak', 20)->nullable();
            $table->string('nama_anak', 100)->nullable();
            $table->enum('jenis_kelamin_anak', ['L', 'P'])->nullable();
            $table->date('tgl_lahir_anak')->nullable();
            $table->decimal('berat_lahir', 5, 2)->nullable();   // kg
            $table->decimal('panjang_lahir', 5, 2)->nullable(); // cm

            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kia');
    }
};
