<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeraturanDesa extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara spesifik agar Laravel tidak error mencari tabel 'peraturan_desas'
    protected $table = 'peraturan_desa';

    // Mengizinkan semua kolom untuk diisi (mass assignment), kecuali kolom 'id'
    protected $guarded = ['id'];

    // Casting tipe data agar format tanggal dan boolean (aktif/tidak) lebih rapi saat dipanggil
    protected $casts = [
        'tanggal_ditetapkan' => 'date',
        'dimuat_pada' => 'date',
        'is_aktif' => 'boolean',
    ];
}