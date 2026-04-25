<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananMandiri extends Model {
    use HasFactory;

    protected $table = 'layanan_mandiri';

    protected $fillable = [
        'penduduk_id',
        'pin',
        'no_telepon',
        'last_login_at',
    ];

    protected $casts = [
    ];

    /**
     * Relasi ke Penduduk.
     */
    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
