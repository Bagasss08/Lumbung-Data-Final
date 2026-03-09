<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuLembaranDesa extends Model
{
    use HasFactory;

    protected $table = 'buku_lembaran_desa';

    protected $fillable = [
        'jenis_peraturan', 'nomor_ditetapkan', 'tanggal_ditetapkan', 'tentang',
        'tanggal_diundangkan_lembaran', 'nomor_diundangkan_lembaran',
        'tanggal_diundangkan_berita', 'nomor_diundangkan_berita', 'keterangan'
    ];
}