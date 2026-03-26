<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table = 'surat_templates';

    // app/Models/SuratTemplate.php

protected $fillable = [
    'judul',
    'lampiran',
    'status',
    'konten_template',
    'file_path',
    'klasifikasi_surat_id' // <-- INI WAJIB ADA AGAR BISA DISIMPAN
];

    /**
     * Relasi: 1 Surat Template milik 1 Klasifikasi Surat
     */

    public function klasifikasi()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'klasifikasi_surat_id');
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