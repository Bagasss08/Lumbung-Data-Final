<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetDesa extends Model
{
    use HasFactory;

    protected $table = 'aset_desa'; // Sesuai nama tabel di database lumbungdata
    protected $guarded = ['id'];
}