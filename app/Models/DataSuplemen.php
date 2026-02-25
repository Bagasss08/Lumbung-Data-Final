<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSuplemen extends Model {
    protected $table = 'tweb_suplemen';

    protected $fillable = [
        'nama',
        'sasaran',     // '1' = Perorangan (by NIK), '2' = Keluarga (by No. KK)
        'keterangan',
        'logo',
        'tgl_mulai',
        'tgl_selesai',
        'aktif',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
        'aktif'       => 'boolean',
    ];

    // ─── Relasi ─────────────────────────────────────────────────────

    public function terdata() {
        return $this->hasMany(SuplemenTerdata::class, 'id_suplemen');
    }

    // ─── Accessor ───────────────────────────────────────────────────

    public function getSasaranLabelAttribute(): string {
        return $this->sasaran == '1' ? 'Perorangan' : 'Keluarga';
    }

    public function getJumlahTerdataAttribute(): int {
        return $this->terdata()->count();
    }
}
