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
        'nama', // <--- 'kategori' diubah menjadi 'nama'
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
        // Parameter: (Model Tujuan, foreign_key_di_tujuan, local_key_di_model_ini)
        return $this->hasMany(SuratTemplate::class, 'kode_klasifikasi', 'kode');
    }
}