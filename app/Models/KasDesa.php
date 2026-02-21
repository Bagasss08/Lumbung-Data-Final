<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasDesa extends Model
{
    protected $table = 'kas_desa';
    
    protected $fillable = [
        'tahun_id',
        'nama',
        'saldo_awal',
        'saldo_akhir',
    ];
    
    public function tahun() {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function transaksi() {
        return $this->hasMany(TransaksiKas::class);
    }
}
