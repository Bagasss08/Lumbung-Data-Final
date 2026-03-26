<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_templates', function (Blueprint $table) {
            // Hapus kolom kode_klasifikasi yang lama (jika sebelumnya sudah terlanjur dibuat)
            if (Schema::hasColumn('surat_templates', 'kode_klasifikasi')) {
                $table->dropColumn('kode_klasifikasi');
            }

            // Tambahkan kolom foreign key baru yang mengarah ke 'id' di tabel klasifikasi_surats
            $table->foreignId('klasifikasi_surat_id')
                  ->nullable() // Boleh kosong (opsional, hapus nullable() jika wajib diisi)
                  ->constrained('klasifikasi_surats')
                  ->onDelete('set null'); // Jika klasifikasi dihapus, ID di sini jadi null (tidak ikut terhapus)
        });
    }

    public function down(): void
    {
        Schema::table('surat_templates', function (Blueprint $table) {
            $table->dropForeign(['klasifikasi_surat_id']);
            $table->dropColumn('klasifikasi_surat_id');
        });
    }
};