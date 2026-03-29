<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdmIndikator extends Model {
    protected $table = 'idm_indikator';

    protected $fillable = [
        'tahun',
        'no_urut',
        'dimensi',
        'nama_indikator',
        'skor',
        'keterangan',
        'kegiatan_dilakukan',
        'nilai_tambah',
        'pelaksana_pusat',
        'pelaksana_provinsi',
        'pelaksana_kabupaten',
        'pelaksana_desa',
        'pelaksana_csr',
        'pelaksana_lainnya',
        'catatan',
    ];

    protected $casts = [
        'tahun'        => 'integer',
        'no_urut'      => 'integer',
        'skor'         => 'integer',
        'nilai_tambah' => 'float',
    ];

    public function rekap(): BelongsTo {
        return $this->belongsTo(IdmRekap::class, 'tahun', 'tahun');
    }

    public function getRowColorAttribute(): string {
        if ($this->skor == 0) return 'table-danger';
        if ($this->skor <= 2) return 'table-warning';
        return '';
    }

    public function getDimensiLabelAttribute(): string {
        return match ($this->dimensi) {
            'IKS'   => 'Indeks Ketahanan Sosial',
            'IKE'   => 'Indeks Ketahanan Ekonomi',
            'IKL'   => 'Indeks Ketahanan Lingkungan',
            default => $this->dimensi,
        };
    }

    public function scopeIks($query) {
        return $query->where('dimensi', 'IKS');
    }
    public function scopeIke($query) {
        return $query->where('dimensi', 'IKE');
    }
    public function scopeIkl($query) {
        return $query->where('dimensi', 'IKL');
    }

    public function scopeTahun($query, int $tahun) {
        return $query->where('tahun', $tahun);
    }
}
