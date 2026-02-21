<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model {
    use HasFactory;

    protected $table = 'jam_kerja';

    protected $fillable = [
        'hari',
        'jam_masuk',
        'jam_pulang',
        'toleransi_terlambat',
        'keterangan',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
    ];
}
