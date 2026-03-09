<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuAgendaSuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'buku_agenda_surat_keluar';

    protected $fillable = [
        'tanggal_pengiriman', 'nomor_surat', 'tanggal_surat', 
        'tujuan', 'isi_singkat', 'keterangan'
    ];
}