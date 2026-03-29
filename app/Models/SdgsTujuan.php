<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SdgsTujuan extends Model {
    protected $table = 'sdgs_tujuan';

    protected $fillable = ['tahun', 'no_tujuan', 'nama_tujuan', 'nilai'];

    protected $casts = [
        'tahun'     => 'integer',
        'no_tujuan' => 'integer',
        'nilai'     => 'float',
    ];

    public function rekap(): BelongsTo {
        return $this->belongsTo(SdgsRekap::class, 'tahun', 'tahun');
    }

    /**
     * Warna latar (hex) per tujuan SDGs – mengikuti standar UN SDG.
     */
    public static function warnaTujuan(int $no): string {
        return match ($no) {
            1  => '#E5243B',
            2  => '#DDA63A',
            3  => '#4C9F38',
            4  => '#C5192D',
            5  => '#FF3A21',
            6  => '#26BDE2',
            7  => '#FCC30B',
            8  => '#A21942',
            9  => '#FD6925',
            10 => '#DD1367',
            11 => '#FD9D24',
            12 => '#BF8B2E',
            13 => '#3F7E44',
            14 => '#0A97D9',
            15 => '#56C02B',
            16 => '#00689D',
            17 => '#19486A',
            18 => '#56C02B',
            default => '#4B5563',
        };
    }

    /**
     * Nama tujuan master (Indonesian SDGs Desa).
     */
    public static function masterTujuan(): array {
        return [
            1  => 'Desa Tanpa Kemiskinan',
            2  => 'Desa Tanpa Kelaparan',
            3  => 'Desa Sehat dan Sejahtera',
            4  => 'Pendidikan Desa Berkualitas',
            5  => 'Keterlibatan Perempuan Desa',
            6  => 'Desa Layak Air Bersih dan Sanitasi',
            7  => 'Desa Berenergi Bersih dan Terbarukan',
            8  => 'Pertumbuhan Ekonomi Desa Merata',
            9  => 'Infrastruktur dan Inovasi Desa Sesuai Kebutuhan',
            10 => 'Desa Tanpa Kesenjangan',
            11 => 'Kawasan Permukiman Desa Aman dan Nyaman',
            12 => 'Konsumsi dan Produksi Desa Sadar Lingkungan',
            13 => 'Desa Tanggap Perubahan Iklim',
            14 => 'Desa Peduli Lingkungan Laut',
            15 => 'Desa Peduli Lingkungan Darat',
            16 => 'Desa Damai Berkeadilan',
            17 => 'Kemitraan untuk Pembangunan Desa',
            18 => 'Kelembagaan Desa Dinamis dan Budaya Desa Adaptif',
        ];
    }
}
