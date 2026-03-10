<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('buku_ktp', function (Blueprint $table) {
            $table->id();
            $table->string('no_ktp', 16)->unique();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('dusun')->nullable();
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->default('WNI');
            $table->date('tanggal_terbit');
            $table->date('tanggal_berlaku')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buku_kk', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 16)->unique();
            $table->string('nama_kepala_keluarga');
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('dusun')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->date('tanggal_terbit');
            $table->integer('jumlah_anggota')->default(0);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('anggota_kk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kk_id')->constrained('buku_kk')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama_lengkap');
            $table->string('hubungan_keluarga'); // Kepala Keluarga, Istri, Anak, dll
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_perkawinan');
            $table->string('kewarganegaraan')->default('WNI');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('anggota_kk');
        Schema::dropIfExists('buku_kk');
        Schema::dropIfExists('buku_ktp');
    }
};
