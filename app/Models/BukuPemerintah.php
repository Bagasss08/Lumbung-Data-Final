<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuPemerintah extends Model
{
    use HasFactory;

    protected $table = 'buku_pemerintah';

    protected $fillable = [
        'nama_lengkap', 'niap', 'nip', 'jenis_kelamin', 
        'tempat_lahir', 'tanggal_lahir', 'agama', 
        'pangkat_golongan', 'jabatan', 'pendidikan_terakhir',
        'nomor_keputusan_pengangkatan', 'tanggal_keputusan_pengangkatan',
        'nomor_keputusan_pemberhentian', 'tanggal_keputusan_pemberhentian',
        'keterangan'
    ];
}