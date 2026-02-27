<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('kerjasama')) {
            Schema::create('kerjasama', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_perjanjian', 100)->nullable();
                $table->string('nama_mitra', 200);
                $table->string('jenis_mitra', 100)->nullable();
                $table->string('alamat_mitra')->nullable();
                $table->string('kontak_mitra', 100)->nullable();
                $table->string('jenis_kerjasama', 150)->nullable();
                $table->text('ruang_lingkup')->nullable();
                $table->date('tanggal_mulai')->nullable();
                $table->date('tanggal_berakhir')->nullable();
                $table->enum('status', ['aktif', 'berakhir', 'ditangguhkan'])->default('aktif');
                $table->string('dokumen')->nullable();
                $table->text('keterangan')->nullable();
                $table->unsignedBigInteger('config_id')->default(1);
                $table->timestamps();
                $table->softDeletes();

                $table->index(['status', 'config_id']);
                $table->index('tanggal_berakhir');
            });
        } else {
            Schema::table('kerjasama', function (Blueprint $table) {
                $cols = Schema::getColumnListing('kerjasama');
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
        Schema::dropIfExists('kerjasama');
    }
};
