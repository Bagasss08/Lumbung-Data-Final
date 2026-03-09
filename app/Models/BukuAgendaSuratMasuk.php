<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuAgendaSuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'buku_agenda_surat_masuk';

    protected $fillable = [
        'tanggal_penerimaan', 'nomor_surat', 'tanggal_surat', 
        'pengirim', 'isi_singkat', 'disposisi', 'keterangan'
    ];
}