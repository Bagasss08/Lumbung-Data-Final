<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model {
    use HasFactory;

    protected $table = 'kelompok';

    protected $fillable = [
        'id_kelompok_master',
        'nama',
        'singkatan',
        'tgl_terbentuk',
        'sk_desa',
        'tgl_sk_desa',
        'sk_kabupaten',
        'tgl_sk_kabupaten',
        'nik_ketua',
        'nama_ketua',
        'telepon',
        'alamat',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'tgl_terbentuk'    => 'date',
        'tgl_sk_desa'      => 'date',
        'tgl_sk_kabupaten' => 'date',
    ];

    public function master() {
        return $this->belongsTo(KelompokMaster::class, 'id_kelompok_master');
    }

    public function anggota() {
        return $this->hasMany(KelompokAnggota::class, 'id_kelompok');
    }

    public function anggotaAktif() {
        return $this->hasMany(KelompokAnggota::class, 'id_kelompok')->where('aktif', '1');
    }

    public function getStatusLabelAttribute(): string {
        return $this->aktif === '1' ? 'Aktif' : 'Tidak Aktif';
    }

    public function getStatusColorAttribute(): string {
        return $this->aktif === '1' ? 'emerald' : 'red';
    }
}
