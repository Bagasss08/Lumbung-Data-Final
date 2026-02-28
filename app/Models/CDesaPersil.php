<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CDesaPersil extends Model
{
    protected $table = 'c_desa_persil';
    protected $guarded = ['id'];

    public function cDesa()
    {
        return $this->belongsTo(CDesa::class, 'c_desa_id');
    }
}