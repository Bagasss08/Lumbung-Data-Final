<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangAnggaran extends Model {
    protected $table = 'bidang_anggaran';

    protected $fillable = ['nama_bidang'];

    public function kegiatanAnggaran() {
        return $this->hasMany(KegiatanAnggaran::class, 'bidang_id');
    }
}
