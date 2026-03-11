<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpidDokumen extends Model
{
    use SoftDeletes;

    protected $table = 'ppid_dokumen';

    protected $fillable = [
        'ppid_jenis_dokumen_id',
        'judul_dokumen',
        'tahun',
        'bulan',
        'waktu_retensi',
        'tanggal_terbit',
        'keterangan',
        'file_path',
        'status',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tahun'          => 'integer',
        'bulan'          => 'integer',
    ];

    public function jenisDokumen()
    {
        return $this->belongsTo(PpidJenisDokumen::class, 'ppid_jenis_dokumen_id');
    }

    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April',   5 => 'Mei',       6 => 'Juni',
            7 => 'Juli',    8 => 'Agustus',   9 => 'September',
            10 => 'Oktober',11 => 'November', 12 => 'Desember',
        ];
        return $bulan[$this->bulan] ?? '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'aktif'
            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
            : 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-400';
    }
}