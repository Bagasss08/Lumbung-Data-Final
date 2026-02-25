<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel utama Kegiatan Pembangunan.
 * Nama tabel: pembangunan (sama persis dengan OpenSID)
 *
 * Poin penting dari OpenSID:
 * - id_lokasi      → FK ke tweb_wil_clusterdesa.id (dusun/RW/RT)
 * - id_bidang      → FK ke ref_pembangunan_bidang.id
 * - id_sasaran     → FK ke ref_pembangunan_sasaran.id
 * - id_sumber_dana → FK ke ref_pembangunan_sumber_dana.id
 * - Anggaran dipecah: dana_pemerintah, dana_provinsi, dana_kabkota, swadaya
 *   (total = dana_pemerintah + dana_provinsi + dana_kabkota + swadaya)
 *   Sesuai issue #4819 OpenSID "Jumlah Anggaran = [Pemerintah]+[Provinsi]+[Kab/Kota]+[Swakelola]"
 * - lat, lng       → koordinat peta (OpenSID menampilkan di peta desa)
 * - volume + satuan → volume fisik pekerjaan (misal: 200 meter, 3 unit)
 * - waktu          → durasi pelaksanaan (hari)
 * - foto           → satu foto utama di tabel induk
 * - dokumentasi    → deskripsi umum (TEXT)
 * - config_id      → multi-desa (standar OpenSID, isi default 1 jika single desa)
 */
return new class extends Migration {
    public function up(): void {
        Schema::create('pembangunan', function (Blueprint $table) {
            $table->id();

            // ── Relasi ke konfigurasi desa (standar OpenSID multi-desa) ──
            $table->unsignedInteger('config_id')->default(1)
                ->comment('ID konfigurasi desa (multi-desa support)');

            // ── Referensi lookup tables ──
            $table->unsignedTinyInteger('id_bidang')->nullable()
                ->comment('FK → ref_pembangunan_bidang');
            $table->unsignedTinyInteger('id_sasaran')->nullable()
                ->comment('FK → ref_pembangunan_sasaran (RPJMDes/RKPDes)');
            $table->unsignedTinyInteger('id_sumber_dana')->nullable()
                ->comment('FK → ref_pembangunan_sumber_dana');

            // ── Lokasi (FK ke wilayah administratif desa) ──
            $table->unsignedBigInteger('id_lokasi')->nullable()
                ->comment('FK → tweb_wil_clusterdesa.id (dusun/RW/RT)');

            // ── Informasi dasar kegiatan ──
            $table->year('tahun_anggaran')->nullable()
                ->comment('Tahun anggaran kegiatan');
            $table->string('nama', 200)
                ->comment('Nama kegiatan pembangunan');
            $table->string('pelaksana', 200)->nullable()
                ->comment('Nama pelaksana: TPK, rekanan, swakelola, dll');

            // ── Volume fisik ──
            $table->float('volume')->nullable()
                ->comment('Volume fisik pekerjaan (angka)');
            $table->string('satuan', 50)->nullable()
                ->comment('Satuan volume: meter, m2, unit, ls, dll');

            // ── Waktu pelaksanaan ──
            $table->unsignedSmallInteger('waktu')->nullable()
                ->comment('Durasi pelaksanaan dalam hari');
            $table->date('mulai_pelaksanaan')->nullable()
                ->comment('Tanggal mulai pelaksanaan');
            $table->date('akhir_pelaksanaan')->nullable()
                ->comment('Tanggal akhir pelaksanaan');

            // ── Anggaran (dipecah per sumber — sesuai OpenSID issue #4793 & #4819) ──
            $table->decimal('dana_pemerintah', 15, 2)->default(0)
                ->comment('Dana dari Pemerintah Pusat (APBN/Dana Desa)');
            $table->decimal('dana_provinsi', 15, 2)->default(0)
                ->comment('Dana dari Pemerintah Provinsi');
            $table->decimal('dana_kabkota', 15, 2)->default(0)
                ->comment('Dana dari Pemerintah Kabupaten/Kota');
            $table->decimal('swadaya', 15, 2)->default(0)
                ->comment('Dana swadaya/gotong royong masyarakat');
            $table->decimal('sumber_lain', 15, 2)->default(0)
                ->comment('Sumber pembiayaan lainnya (req #4819)');

            // ── Koordinat peta (OpenSID menampilkan di peta desa) ──
            $table->decimal('lat', 10, 8)->nullable()
                ->comment('Latitude koordinat lokasi');
            $table->decimal('lng', 11, 8)->nullable()
                ->comment('Longitude koordinat lokasi');

            // ── Dokumentasi ──
            $table->string('foto', 255)->nullable()
                ->comment('Path foto utama kegiatan');
            $table->text('dokumentasi')->nullable()
                ->comment('Deskripsi/uraian kegiatan (text bebas)');

            // ── Status ──
            $table->tinyInteger('status')->default(1)
                ->comment('1=aktif, 0=arsip');

            $table->timestamps();

            // ── Foreign Keys ──
            $table->foreign('id_bidang')
                ->references('id')->on('ref_pembangunan_bidang')
                ->nullOnDelete();

            $table->foreign('id_sasaran')
                ->references('id')->on('ref_pembangunan_sasaran')
                ->nullOnDelete();

            $table->foreign('id_sumber_dana')
                ->references('id')->on('ref_pembangunan_sumber_dana')
                ->nullOnDelete();

            // FK ke wilayah administratif (tweb_wil_clusterdesa)
            // Catatan: tambahkan FK ini hanya jika tabel tweb_wil_clusterdesa sudah ada
            // $table->foreign('id_lokasi')
            //       ->references('id')->on('tweb_wil_clusterdesa')
            //       ->nullOnDelete();

            $table->index(['config_id', 'tahun_anggaran'], 'idx_pembangunan_config_tahun');
            $table->index('id_bidang', 'idx_pembangunan_bidang');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembangunan');
    }
};
