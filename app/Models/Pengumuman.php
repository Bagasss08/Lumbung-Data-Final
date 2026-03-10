<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // KODE AJAIB PENYELAMAT: Beritahu Laravel nama tabel aslinya!
    protected $table = 'pengumumans';

    protected $fillable = [
        'dibuat_oleh',
        'judul',
        'isi',
        'target_role'
    ];

    // Relasi untuk mengetahui siapa yang membuat
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}