<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('buku_inventaris_kekayaan_desa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique()->comment('Kode unik barang');
            $table->string('nama_barang', 255)->comment('Nama barang/aset');
            $table->string('kategori', 100)->comment('Kategori: Tanah, Peralatan, Gedung, dll');
            $table->decimal('jumlah', 10, 2)->default(1)->comment('Jumlah barang');
            $table->string('satuan', 50)->comment('Satuan: buah, unit, m2, dll');
            $table->year('tahun_pengadaan')->nullable()->comment('Tahun pengadaan barang');
            $table->string('asal_usul', 100)->nullable()->comment('Pembelian, Hibah, Bantuan, dll');
            $table->decimal('harga_satuan', 15, 2)->nullable()->default(0)->comment('Harga per satuan');
            $table->decimal('harga_total', 15, 2)->nullable()->default(0)->comment('Total harga (auto-calculated)');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik')->comment('Kondisi barang');
            $table->string('lokasi', 255)->nullable()->comment('Lokasi penyimpanan/penempatan');
            $table->text('keterangan')->nullable()->comment('Keterangan tambahan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('buku_inventaris_kekayaan_desa');
    }
};
