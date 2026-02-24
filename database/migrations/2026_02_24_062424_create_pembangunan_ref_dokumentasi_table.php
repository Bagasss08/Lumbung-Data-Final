<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel Dokumentasi / Foto Kegiatan Pembangunan.
 * Nama tabel: pembangunan_ref_dokumentasi (PERSIS OpenSID)
 *
 * Poin penting dari OpenSID (issue #4180):
 * - id_pembangunan → FK ke pembangunan.id
 * - persentase     → progres kegiatan 0-100% DISIMPAN DI SINI (bukan di tabel induk)
 * - judul, foto, tanggal, uraian → data dokumentasi per fase
 *
 * "Yang dilaporkan adalah pembangunan yang telah mencapai persentase
 *  pembangunan 100%. Persentase pembangunan dapat dilihat di tabel
 *  pembangunan_ref_dokumentasi.persentase" — OpenSID issue #4180
 */
return new class extends Migration {
    public function up(): void {
        Schema::create('pembangunan_ref_dokumentasi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pembangunan')
                ->comment('FK → pembangunan.id');

            $table->string('judul', 200)->nullable()
                ->comment('Judul / keterangan singkat dokumentasi');

            $table->string('foto', 255)->nullable()
                ->comment('Path file foto dokumentasi');

            $table->unsignedTinyInteger('persentase')->default(0)
                ->comment('Persentase progres kegiatan saat dokumentasi ini diambil (0-100)');

            $table->date('tanggal')->nullable()
                ->comment('Tanggal pengambilan dokumentasi');

            $table->text('uraian')->nullable()
                ->comment('Uraian / deskripsi dokumentasi');

            $table->timestamps();

            // ── Foreign Key ──
            $table->foreign('id_pembangunan')
                ->references('id')->on('pembangunan')
                ->cascadeOnDelete();

            $table->index('id_pembangunan', 'idx_dok_pembangunan');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembangunan_ref_dokumentasi');
    }
};
