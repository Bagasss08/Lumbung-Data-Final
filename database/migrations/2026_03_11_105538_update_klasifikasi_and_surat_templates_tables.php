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
        // 1. Update tabel klasifikasi_surats
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            $table->integer('jumlah')->default(0)->after('keterangan');
        });

        // 2. Update tabel surat_templates
        Schema::table('surat_templates', function (Blueprint $table) {
            $table->dropColumn('format_nomor'); // Hapus format_nomor
            $table->string('lampiran')->nullable()->after('judul'); // Tambah lampiran
            
            // Opsional: Jika kolom 'kode' di klasifikasi_surats bersifat unik (unique), 
            // kamu bisa menambahkan foreign key constraint di database.
            // Jika tidak, abaikan/komentar baris di bawah ini dan cukup gunakan relasi Eloquent.
            // $table->foreign('kode_klasifikasi')->references('kode')->on('klasifikasi_surats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });

        Schema::table('surat_templates', function (Blueprint $table) {
            $table->dropColumn('lampiran');
            $table->string('format_nomor')->nullable()->after('judul');
        });
    }
};