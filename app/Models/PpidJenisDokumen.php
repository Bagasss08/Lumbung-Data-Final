<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidJenisDokumen extends Model {
    protected $table = 'ppid_jenis_dokumen';

    protected $fillable = ['nama', 'keterangan'];

    public function dokumen() {
        return $this->hasMany(PpidDokumen::class, 'ppid_jenis_dokumen_id');
    }
}
