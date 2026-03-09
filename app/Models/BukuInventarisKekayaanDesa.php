<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BukuInventarisKekayaanDesa extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'buku_inventaris_kekayaan_desa';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'tahun_pengadaan',
        'asal_usul',
        'harga_satuan',
        'harga_total',
        'kondisi',
        'lokasi',
        'keterangan',
    ];

    protected $casts = [
        'jumlah'          => 'decimal:2',
        'harga_satuan'    => 'decimal:2',
        'harga_total'     => 'decimal:2',
        'tahun_pengadaan' => 'integer',
    ];

    // Kategori aset desa
    public static function kategoriList(): array {
        return [
            'Tanah',
            'Peralatan dan Mesin',
            'Gedung dan Bangunan',
            'Jalan, Irigasi, dan Jaringan',
            'Aset Tetap Lainnya',
            'Konstruksi dalam Pengerjaan',
            'Hewan dan Tanaman',
        ];
    }

    // Sumber perolehan aset
    public static function asalUsulList(): array {
        return [
            'Pembelian',
            'Hibah',
            'Bantuan Pemerintah',
            'Bantuan Swasta',
            'Swadaya Masyarakat',
            'Warisan',
            'Lainnya',
        ];
    }

    // Satuan barang
    public static function satuanList(): array {
        return [
            'buah',
            'unit',
            'set',
            'pasang',
            'm²',
            'm³',
            'meter',
            'kg',
            'liter',
            'bidang',
            'lokal',
            'ruang',
        ];
    }

    // Format harga ke Rupiah
    public function getHargaSatuanFormatAttribute(): string {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    public function getHargaTotalFormatAttribute(): string {
        return 'Rp ' . number_format($this->harga_total, 0, ',', '.');
    }

    // Badge warna kondisi
    public function getKondisiBadgeAttribute(): string {
        return match ($this->kondisi) {
            'Baik'         => 'bg-emerald-100 text-emerald-700',
            'Rusak Ringan' => 'bg-amber-100 text-amber-700',
            'Rusak Berat'  => 'bg-red-100 text-red-700',
            default        => 'bg-gray-100 text-gray-700',
        };
    }

    // Auto-hitung harga total sebelum simpan
    protected static function booted(): void {
        static::saving(function ($model) {
            $model->harga_total = $model->jumlah * $model->harga_satuan;
        });
    }
}
