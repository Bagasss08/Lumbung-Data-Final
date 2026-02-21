<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanPerangkat extends Model {
    protected $table = 'jabatan_perangkat';

    protected $fillable = ['nama', 'golongan', 'urutan'];

    const GOLONGAN_PEMERINTAH = 'pemerintah_desa';
    const GOLONGAN_BPD        = 'bpd';

    public function perangkat() {
        return $this->hasMany(PerangkatDesa::class, 'jabatan_id');
    }

    public function getLabelGolonganAttribute(): string {
        return match ($this->golongan) {
            'pemerintah_desa' => 'Pemerintah Desa',
            'bpd'             => 'BPD',
            default           => '-',
        };
    }

    public static function listByGolongan(): array {
        return self::orderBy('urutan')
            ->get()
            ->groupBy('golongan')
            ->map(fn($group) => $group->pluck('nama', 'id'))
            ->toArray();
    }
}
