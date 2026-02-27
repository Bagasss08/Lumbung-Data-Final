<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Jika tabel belum ada, buat fresh
        if (!Schema::hasTable('status_desa')) {
            Schema::create('status_desa', function (Blueprint $table) {
                $table->id();
                $table->string('nama_status', 100)->default('IDM')->comment('Nama index: IDM, IPD, dll');
                $table->year('tahun');

                // ── Skor Utama ───────────────────────────────────────
                $table->decimal('nilai', 8, 4)->default(0)
                    ->comment('Total nilai/skor gabungan');

                $table->string('status', 50)->nullable()
                    ->comment('Sangat Tertinggal | Tertinggal | Berkembang | Maju | Mandiri');

                // ── Skor Dimensi (sesuai IDM resmi Kemendes) ────────
                $table->decimal('skor_ketahanan_sosial', 8, 4)->default(0)
                    ->comment('IKS — Indeks Ketahanan Sosial');
                $table->decimal('skor_ketahanan_ekonomi', 8, 4)->default(0)
                    ->comment('IKE — Indeks Ketahanan Ekonomi');
                $table->decimal('skor_ketahanan_ekologi', 8, 4)->default(0)
                    ->comment('IKL — Indeks Ketahanan Ekologi/Lingkungan');

                // ── Target & Realisasi ───────────────────────────────
                $table->string('status_target', 50)->nullable()
                    ->comment('Target status yang ingin dicapai');
                $table->decimal('nilai_target', 8, 4)->nullable()
                    ->comment('Nilai IDM yang ditargetkan');

                // ── Pendukung ────────────────────────────────────────
                $table->text('keterangan')->nullable();
                $table->string('dokumen')->nullable()
                    ->comment('Path file dokumen SK/laporan IDM');

                // ── Multi-desa support ───────────────────────────────
                $table->unsignedBigInteger('config_id')->default(1)
                    ->comment('Untuk instalasi multi-desa');

                $table->timestamps();
                $table->softDeletes();

                $table->index(['tahun', 'config_id']);
                $table->index('status');
            });
        } else {
            // Tabel sudah ada — tambah kolom yang kurang
            Schema::table('status_desa', function (Blueprint $table) {
                $cols = Schema::getColumnListing('status_desa');

                if (!in_array('skor_ketahanan_sosial', $cols)) {
                    $table->decimal('skor_ketahanan_sosial', 8, 4)->default(0)->after('status');
                }
                if (!in_array('skor_ketahanan_ekonomi', $cols)) {
                    $table->decimal('skor_ketahanan_ekonomi', 8, 4)->default(0)->after('skor_ketahanan_sosial');
                }
                if (!in_array('skor_ketahanan_ekologi', $cols)) {
                    $table->decimal('skor_ketahanan_ekologi', 8, 4)->default(0)->after('skor_ketahanan_ekonomi');
                }
                if (!in_array('status_target', $cols)) {
                    $table->string('status_target', 50)->nullable()->after('skor_ketahanan_ekologi');
                }
                if (!in_array('nilai_target', $cols)) {
                    $table->decimal('nilai_target', 8, 4)->nullable()->after('status_target');
                }
                if (!in_array('config_id', $cols)) {
                    $table->unsignedBigInteger('config_id')->default(1)->after('dokumen');
                }
                if (!in_array('deleted_at', $cols)) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('status_desa');
    }
};
