<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanSurat extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_surats';

    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi: 1 Persyaratan bisa dipakai banyak Template
     */
    public function templates()
    {
        return $this->belongsToMany(
            SuratTemplate::class,
            'surat_persyaratan',
            'persyaratan_surat_id',
            'surat_template_id'
        );
    }
}