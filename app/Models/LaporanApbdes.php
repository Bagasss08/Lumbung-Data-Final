<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanApbdes extends Model {
    use HasFactory;

    protected $table = 'laporan_apbdes';

    protected $fillable = [
        'judul',
        'tahun',
        'semester',
        'file',
        'tgl_upload',
        'tgl_kirim',
    ];

    protected $casts = [
        'tahun'      => 'integer',
        'semester'   => 'integer',
        'tgl_upload' => 'datetime',
        'tgl_kirim'  => 'datetime',
    ];

    /**
     * Accessor: label semester
     */
    public function getSemesterLabelAttribute(): string {
        return 'Semester ' . $this->semester;
    }

    /**
     * Scope filter by tahun
     */
    public function scopeFilterTahun($query, $tahun) {
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        return $query;
    }
}
