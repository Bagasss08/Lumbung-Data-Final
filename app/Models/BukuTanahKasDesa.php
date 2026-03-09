<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTanahKasDesa extends Model
{
    use HasFactory;

    protected $table = 'buku_tanah_kas_desa';

    protected $fillable = [
        'asal_tanah_kas_desa', 'nomor_sertifikat', 'luas', 'kelas', 
        'asal_perolehan', 'tanggal_perolehan', 'jenis_tanah', 
        'status_patok', 'status_papan_nama', 'lokasi', 
        'peruntukan', 'mutasi', 'keterangan'
    ];
}