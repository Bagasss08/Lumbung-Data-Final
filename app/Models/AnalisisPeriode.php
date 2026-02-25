<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalisisPeriode extends Model {
    protected $table = 'analisis_periode';

    protected $fillable = [
        'id_master',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'aktif'           => 'boolean',
    ];

    public function master(): BelongsTo {
        return $this->belongsTo(AnalisisMaster::class, 'id_master');
    }

    public function responden(): HasMany {
        return $this->hasMany(AnalisisResponden::class, 'id_periode');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
