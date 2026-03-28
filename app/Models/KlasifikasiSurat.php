<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_surats';

    protected $fillable = [
        'kode',
        'nama_klasifikasi',
        'nama', 
        'retensi_aktif',
        'retensi_inaktif',
        'status',
        'keterangan',
        'jumlah', 
    ];

    protected $casts = [
        'status' => 'boolean',
        'retensi_aktif' => 'integer',
        'retensi_inaktif' => 'integer',
        'jumlah' => 'integer', 
    ];

    /**
     * Relasi: 1 Klasifikasi punya banyak Surat Template
     */
    public function suratTemplates()
    {
        // PERBAIKAN: Menggunakan klasifikasi_surat_id yang merujuk ke id
        return $this->hasMany(SuratTemplate::class, 'klasifikasi_surat_id', 'id');
    }
}