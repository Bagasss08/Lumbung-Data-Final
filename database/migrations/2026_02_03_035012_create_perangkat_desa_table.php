<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();

            // Relasi ke penduduk (opsional: bisa diisi manual jika belum ada di DB)
            $table->unsignedBigInteger('penduduk_id')->nullable()
                ->comment('FK ke tabel penduduk, nullable jika input manual');

            // Relasi ke jabatan
            $table->unsignedBigInteger('jabatan_id')
                ->comment('FK ke jabatan_perangkat');

            // Data identitas (diisi otomatis dari penduduk jika ada, atau manual)
            $table->string('nama', 100);
            $table->string('nik', 16)->nullable();
            $table->string('foto', 255)->nullable()->comment('Path foto perangkat');

            // Data SK
            $table->string('no_sk', 100)->nullable()->comment('Nomor SK pengangkatan');
            $table->date('tanggal_sk')->nullable();
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();

            // Status
            $table->enum('status', ['1', '2'])->default('1')
                ->comment('1 = Aktif, 2 = Non-Aktif (sesuai konvensi OpenSID)');

            $table->text('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0)
                ->comment('Urutan tampil di halaman publik');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jabatan_id')->references('id')->on('jabatan_perangkat')->onDelete('restrict');
        });
    }

    public function down(): void {
        Schema::dropIfExists('perangkat_desa');
    }
};
