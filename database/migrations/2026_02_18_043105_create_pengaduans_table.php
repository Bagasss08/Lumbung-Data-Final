<?php
// database/migrations/xxxx_xx_xx_create_pengaduans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();
            // nullable karena bisa pengaduan dari umum (anonim), seperti OpenSID
            $table->string('nama', 100);          // nama pelapor (bisa diisi manual jika anonim)
            $table->string('email', 100)->nullable(); // email pelapor (opsional, untuk balasan jika anonim)
            $table->string('subjek', 200);         // judul/subjek pengaduan
            $table->text('isi');                   // isi pengaduan
            $table->string('lampiran')->nullable(); // file attachment
            $table->string('ip_address', 45)->nullable(); // anti-spam seperti OpenSID
            $table->tinyInteger('status')->default(1);
            // 1 = Baru, 2 = Proses, 3 = Selesai, 4 = Ditolak
            $table->text('tanggapan')->nullable();  // balasan dari admin/petugas
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengaduan');
    }
};
