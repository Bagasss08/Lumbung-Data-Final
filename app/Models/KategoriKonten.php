<?php

namespace App\Models; // Pastikan namespace ini benar

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
    use HasFactory;

    protected $table = 'kategori_konten'; // Sesuai tabel DB
    protected $guarded = ['id'];
}