<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_pemerintah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('niap')->nullable()->comment('Nomor Induk Aparatur Pemerintah Desa');
            $table->string('nip')->nullable()->comment('NIP bagi PNS');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan');
            $table->string('pendidikan_terakhir');
            $table->string('nomor_keputusan_pengangkatan');
            $table->date('tanggal_keputusan_pengangkatan');
            $table->string('nomor_keputusan_pemberhentian')->nullable();
            $table->date('tanggal_keputusan_pemberhentian')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_pemerintah');
    }
};