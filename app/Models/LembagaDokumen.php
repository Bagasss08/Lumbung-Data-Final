<?php

namespace App\Models\InfoDesa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaDokumen extends Model {
    use HasFactory;

    protected $table = 'lembaga_dokumen';

    protected $fillable = [
        'lembaga_id',
        'judul',
        'tahun',
        'aktif',
        'keterangan',
        'file',
        'status',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi ke LembagaDesa
     */
    public function lembaga() {
        return $this->belongsTo(LembagaDesa::class, 'lembaga_id');
    }
}
