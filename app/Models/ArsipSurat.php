<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArsipSurat extends Model
{
    use SoftDeletes;

    protected $table = 'arsip_surat';

    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'nama_pemohon',
        'nik',
        'tanggal_surat',
        'file_path',
        'status',
        'user_id'
    ];

    protected $dates = [
        'tanggal_surat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}