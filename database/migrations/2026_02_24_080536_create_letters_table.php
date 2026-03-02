<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            
            // Kop & Data Desa
            $table->string('kode_kabupaten');
            $table->string('nama_kabupaten');
            $table->string('logo_desa')->nullable();
            $table->string('kecamatan');
            $table->string('kantor_desa');
            $table->string('nama_desa');
            $table->text('alamat_kantor');
            $table->string('kode_provinsi');
            
            // Data Surat & Pemohon
            $table->string('format_nomor');
            $table->string('nama');
            $table->string('nik', 50);
            $table->string('no_kk', 50);
            $table->string('kepala_kk');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 50);
            $table->text('Alamat');
            $table->string('kabupaten');
            $table->string('agama', 50);
            $table->string('status', 50);
            $table->string('Pendidikan', 100);
            $table->string('pekerjaan');
            $table->string('warga_negara', 50)->default('WNI');
            $table->text('form_keterangan');
            $table->date('mulai_berlaku');
            $table->date('tgl_akhir');
            
            // Tanda Tangan
            $table->date('tgl_surat');
            $table->string('penandatangan');
            $table->string('kepala_desa');
            $table->string('nip_kepala_desa', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};