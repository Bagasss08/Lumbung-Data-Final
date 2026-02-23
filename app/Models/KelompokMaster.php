<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMaster extends Model {
    use HasFactory;

    protected $table = 'kelompok_master';

    protected $fillable = [
        'nama',
        'singkatan',
        'jenis',
        'keterangan',
    ];

    public static $jenisOptions = [
        'sosial'       => 'Sosial',
        'ekonomi'      => 'Ekonomi',
        'keagamaan'    => 'Keagamaan',
        'kesehatan'    => 'Kesehatan',
        'pendidikan'   => 'Pendidikan',
        'pertanian'    => 'Pertanian',
        'keamanan'     => 'Keamanan',
        'lainnya'      => 'Lainnya',
    ];

    public function kelompok() {
        return $this->hasMany(Kelompok::class, 'id_kelompok_master');
    }

    public function getJenisLabelAttribute(): string {
        return self::$jenisOptions[$this->jenis] ?? ucfirst($this->jenis ?? '-');
    }
}
