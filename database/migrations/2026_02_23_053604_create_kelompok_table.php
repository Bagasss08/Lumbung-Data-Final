<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tabel master jenis/kategori kelompok
        Schema::create('kelompok_master', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->comment('Nama jenis kelompok, misal: PKK, Karang Taruna, dll');
            $table->string('singkatan', 20)->nullable();
            $table->string('jenis', 50)->nullable()->comment('sosial, ekonomi, keagamaan, dll');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel kelompok
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelompok_master')->constrained('kelompok_master')->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('singkatan', 20)->nullable();
            $table->date('tgl_terbentuk')->nullable();
            $table->string('sk_desa', 100)->nullable()->comment('Nomor SK Desa');
            $table->date('tgl_sk_desa')->nullable();
            $table->string('sk_kabupaten', 100)->nullable();
            $table->date('tgl_sk_kabupaten')->nullable();
            $table->string('nik_ketua', 16)->nullable();
            $table->string('nama_ketua', 100)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('aktif', ['1', '0'])->default('1');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel anggota kelompok (pivot penduduk ↔ kelompok)
        Schema::create('kelompok_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelompok')->constrained('kelompok')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('jabatan', 50)->nullable()->comment('Ketua, Sekretaris, Bendahara, Anggota, dll');
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->enum('aktif', ['1', '0'])->default('1');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('nik');
            $table->index('id_kelompok');
        });
    }

    public function down(): void {
        Schema::dropIfExists('kelompok_anggota');
        Schema::dropIfExists('kelompok');
        Schema::dropIfExists('kelompok_master');
    }
};
