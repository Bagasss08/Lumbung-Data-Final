<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanAnak extends Model {
    use HasFactory;

    protected $table = 'pemantauan_anak';

    protected $fillable = [
        'kia_id',
        'posyandu_id',
        'user_id',
        'tanggal_pemantauan',
        'bulan',
        'tahun',
        'umur_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'status_bb_u',
        'status_tb_u',
        'status_bb_tb',
        'dapat_vit_a',
        'status_imunisasi',
        'asi_eksklusif',
        'perkembangan',
        'petugas',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemantauan' => 'date',
        'bulan'              => 'integer',
        'tahun'              => 'integer',
        'umur_bulan'         => 'integer',
        'berat_badan'        => 'decimal:2',
        'tinggi_badan'       => 'decimal:2',
        'lingkar_kepala'     => 'decimal:2',
        'lingkar_lengan'     => 'decimal:2',
    ];

    // ==================
    // RELASI
    // ==================

    public function kia() {
        return $this->belongsTo(Kia::class);
    }

    public function posyandu() {
        return $this->belongsTo(Posyandu::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // ==================
    // ACCESSOR
    // ==================

    public function getIsStuntingAttribute(): bool {
        return in_array($this->status_tb_u, ['pendek', 'sangat_pendek']);
    }

    public function getStatusGiziLabelAttribute(): string {
        return match ($this->status_tb_u) {
            'sangat_pendek' => 'Sangat Pendek (Stunting Berat)',
            'pendek'        => 'Pendek (Stunting)',
            'normal'        => 'Normal',
            'tinggi'        => 'Tinggi',
            default         => '-',
        };
    }
}
