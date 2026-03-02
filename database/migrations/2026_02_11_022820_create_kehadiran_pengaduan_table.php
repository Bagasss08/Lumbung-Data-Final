<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_pengaduan', function (Blueprint $table) {
            $table->id();

            // ⚠️  FK ke tabel perangkat desa TIDAK dipasang di sini
            //     Uncomment & sesuaikan nama tabel jika ingin FK:
            $table->unsignedBigInteger('perangkat_id');
            $table->foreign('perangkat_id')->references('id')->on('perangkat_desa')->onDelete('cascade');

            $table->date('tanggal_kehadiran');
            $table->string('jenis_pengaduan', 100);

            $table->time('jam_masuk_diajukan')->nullable();
            $table->time('jam_keluar_diajukan')->nullable();
            $table->enum('status_diajukan', [
                'hadir',
                'terlambat',
                'izin',
                'sakit',
                'alpa',
                'dinas_luar',
                'cuti',
                'libur'
            ])->nullable();

            $table->text('alasan');
            $table->string('bukti_file')->nullable();

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();

            $table->unsignedBigInteger('diproses_oleh')->nullable();
            $table->foreign('diproses_oleh')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('diproses_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_pengaduan');
    }
};
