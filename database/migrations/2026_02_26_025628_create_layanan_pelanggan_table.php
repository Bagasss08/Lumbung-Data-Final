<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('layanan_pelanggan')) {
            Schema::create('layanan_pelanggan', function (Blueprint $table) {
                $table->id();
                $table->string('nama_layanan', 200);
                $table->string('jenis_layanan', 100)->nullable();
                $table->text('deskripsi')->nullable();
                $table->text('persyaratan')->nullable();
                $table->string('penanggung_jawab', 150)->nullable();
                $table->string('waktu_penyelesaian', 100)->nullable();
                $table->string('biaya', 100)->nullable();
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
                $table->integer('urutan')->default(0);

                // ── Relasi ke Layanan Surat (surat_format) ──────────
                $table->unsignedBigInteger('surat_format_id')->nullable()
                    ->comment('FK ke tabel surat_format — layanan ini membutuhkan surat apa');
                $table->string('kode_layanan', 50)->nullable()->unique()
                    ->comment('Kode unik layanan, misal: SKD-001');
                $table->string('dasar_hukum')->nullable()
                    ->comment('Peraturan/dasar hukum layanan ini');

                $table->unsignedBigInteger('config_id')->default(1);
                $table->timestamps();
                $table->softDeletes();

                $table->index(['status', 'config_id']);
                $table->index('urutan');
                // Foreign key ke surat_format bersifat opsional (nullable + no constraint)
                // agar tidak gagal jika modul surat belum ada
            });
        } else {
            Schema::table('layanan_pelanggan', function (Blueprint $table) {
                $cols = Schema::getColumnListing('layanan_pelanggan');

                if (!in_array('surat_format_id', $cols)) {
                    $table->unsignedBigInteger('surat_format_id')->nullable()->after('urutan');
                }
                if (!in_array('kode_layanan', $cols)) {
                    $table->string('kode_layanan', 50)->nullable()->after('surat_format_id');
                }
                if (!in_array('dasar_hukum', $cols)) {
                    $table->string('dasar_hukum')->nullable()->after('kode_layanan');
                }
                if (!in_array('config_id', $cols)) {
                    $table->unsignedBigInteger('config_id')->default(1);
                }
                if (!in_array('deleted_at', $cols)) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('layanan_pelanggan');
    }
};
