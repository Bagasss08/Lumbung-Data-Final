<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table = 'surat_templates';

    protected $fillable = [
        'judul',
        'lampiran', // <--- format_nomor diganti jadi lampiran
        'kode_klasifikasi',
        'status',
        'konten_template',
        'file_path',
    ];

    /**
     * Relasi: 1 Surat Template milik 1 Klasifikasi Surat
     */
    public function klasifikasi()
    {
        // Parameter: (Model Tujuan, foreign_key_di_model_ini, owner_key_di_tujuan)
        return $this->belongsTo(KlasifikasiSurat::class, 'kode_klasifikasi', 'kode');
    }

    /**
     * Relasi: 1 Template punya banyak Persyaratan (Many to Many)
     */
    public function persyaratan()
    {
        return $this->belongsToMany(
            \App\Models\PersyaratanSurat::class,
            'surat_persyaratan',
            'surat_template_id',
            'persyaratan_surat_id'
        );
    }

    /**
     * Scope: ambil template yang statusnya aktif saja
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}