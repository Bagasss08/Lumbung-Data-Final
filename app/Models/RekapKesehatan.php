<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKesehatan extends Model {
    use HasFactory;

    protected $table = 'rekap_kesehatan';

    protected $fillable = [
        'tahun',
        'jumlah_puskesmas',
        'jumlah_pustu',
        'jumlah_posyandu',
        'jumlah_polindes',
        'jumlah_dokter',
        'jumlah_bidan',
        'jumlah_perawat',
        'jumlah_kader_aktif',
        'jumlah_ibu_hamil',
        'jumlah_balita',
        'jumlah_bayi',
        'jumlah_anak_pra_sekolah',
        'jumlah_lansia',
        'kasus_diare',
        'kasus_ispa',
        'kasus_dbd',
        'kasus_tb',
        'kasus_malaria',
        'kasus_hipertensi',
        'kasus_diabetes',
        'kasus_lainnya',
        'cakupan_imunisasi_dasar',
        'cakupan_asi_eksklusif',
        'cakupan_kia',
        'prevalensi_stunting',
        'prevalensi_gizi_buruk',
        'keterangan',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    // Accessor
    public function getTotalFasilitasAttribute(): int {
        return $this->jumlah_puskesmas + $this->jumlah_pustu
            + $this->jumlah_posyandu + $this->jumlah_polindes;
    }

    public function getTotalTenagaAttribute(): int {
        return $this->jumlah_dokter + $this->jumlah_bidan
            + $this->jumlah_perawat + $this->jumlah_kader_aktif;
    }

    public function getTotalKasusMenularAttribute(): int {
        return $this->kasus_diare + $this->kasus_ispa + $this->kasus_dbd
            + $this->kasus_tb + $this->kasus_malaria;
    }

    public function getTotalKasusTidakMenularAttribute(): int {
        return $this->kasus_hipertensi + $this->kasus_diabetes + $this->kasus_lainnya;
    }
}
