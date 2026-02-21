<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model {
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'nama_template',
        'tahun',
        'jenis_surat',
        'jenis',
        'original_name',
        'path',
        'mime',
        'size',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
