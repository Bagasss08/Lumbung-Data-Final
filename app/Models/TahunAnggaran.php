<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAnggaran extends Model
{
    protected $table = 'tahun_anggaran';
    
    protected $fillable = [
        'tahun',
        'status',
    ];
    
    public function kasDesa() {
        return $this->hasMany(KasDesa::class);
    }
}
