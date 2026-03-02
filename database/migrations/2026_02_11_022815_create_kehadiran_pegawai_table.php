<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadiran_pegawai', function (Blueprint $table) {
            $table->id();

            // ⚠️  FK ke tabel perangkat desa TIDAK dipasang di sini
            //     agar tidak bergantung nama/urutan tabel lain.
            //     Jika ingin FK, uncomment baris di bawah & sesuaikan nama tabel:
            $table->unsignedBigInteger('perangkat_id');
            $table->foreign('perangkat_id')->references('id')->on('perangkat_desa')->onDelete('cascade');

            $table->date('tanggal');

            $table->unsignedBigInteger('jam_kerja_id')->nullable();
            $table->foreign('jam_kerja_id')
                ->references('id')
                ->on('kehadiran_jam_kerja')
                ->nullOnDelete();

            $table->time('jam_masuk_aktual')->nullable();
            $table->time('jam_keluar_aktual')->nullable();

            $table->enum('status', [
                'hadir',
                'terlambat',
                'izin',
                'sakit',
                'alpa',
                'dinas_luar',
                'cuti',
                'libur',
            ])->default('hadir');

            $table->unsignedSmallInteger('menit_terlambat')->default(0);

            $table->enum('metode_masuk', ['manual', 'self_checkin'])->nullable();
            $table->enum('metode_keluar', ['manual', 'self_checkout'])->nullable();

            $table->decimal('lat_masuk', 10, 7)->nullable();
            $table->decimal('lng_masuk', 10, 7)->nullable();
            $table->decimal('lat_keluar', 10, 7)->nullable();
            $table->decimal('lng_keluar', 10, 7)->nullable();

            $table->text('keterangan')->nullable();

            $table->unsignedBigInteger('dicatat_oleh')->nullable();
            $table->foreign('dicatat_oleh')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['perangkat_id', 'tanggal']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('kehadiran_pegawai');
    }
};
