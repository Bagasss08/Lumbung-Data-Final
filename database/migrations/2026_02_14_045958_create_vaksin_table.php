<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tabel penerima vaksin
     * Sesuai struktur OpenSID tweb_covid19_vaksin (dimodifikasi untuk vaksin umum)
     */
    public function up(): void {
        Schema::create('vaksin', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->nullable();
            $table->string('nama_penerima', 100);
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->string('dusun', 100)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->text('alamat')->nullable();

            // Data vaksinasi
            $table->string('jenis_vaksin', 100);   // nama vaksin: Sinovac, Pfizer, BCG, DPT, dll
            $table->string('kategori_vaksin', 50)->nullable();  // covid19, imunisasi_anak, influenza, dll
            $table->integer('dosis')->default(1);   // ke-1, ke-2, ke-3, booster
            $table->date('tanggal_vaksin');
            $table->string('tempat_pelayanan', 150)->nullable();  // puskesmas/rs/posyandu
            $table->string('petugas', 100)->nullable();
            $table->string('batch_vaksin', 50)->nullable();  // nomor batch/lot vaksin
            $table->enum('status', ['sudah', 'belum', 'tunda'])->default('sudah');
            $table->string('no_sertifikat', 100)->nullable();  // nomor sertifikat vaksin
            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk pencarian cepat
            $table->index('nik');
            $table->index('tanggal_vaksin');
            $table->index('jenis_vaksin');
        });
    }

    public function down(): void {
        Schema::dropIfExists('vaksin');
    }
};
