<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'perangkat_desa';

    protected $fillable = [
        'nama',
        'penduduk_id',
        'jabatan',
        'no_sk',
        'tanggal_sk',
        'periode_mulai',
        'periode_selesai',
        'status'
    ];

    protected $casts = [
        'tanggal_sk' => 'date',
        'periode_mulai' => 'date',
        'periode_selesai' => 'date',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
