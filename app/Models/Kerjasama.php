<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Kerjasama extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'kerjasama';

    protected $fillable = [
        'nomor_perjanjian',
        'nama_mitra',
        'jenis_mitra',
        'alamat_mitra',
        'kontak_mitra',
        'jenis_kerjasama',
        'ruang_lingkup',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'dokumen',
        'keterangan',
        'config_id',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public static function daftarJenisMitra(): array {
        return [
            'Pemerintah Pusat',
            'Pemerintah Daerah',
            'Swasta',
            'NGO / LSM',
            'Akademisi / Perguruan Tinggi',
            'Lembaga Internasional',
            'Lainnya',
        ];
    }

    public static function daftarJenisKerjasama(): array {
        return [
            'MoU (Memorandum of Understanding)',
            'PKS (Perjanjian Kerja Sama)',
            'MoA (Memorandum of Agreement)',
            'Perjanjian Hibah',
            'Lainnya',
        ];
    }

    public function getSisaHariAttribute(): ?int {
        if (!$this->tanggal_berakhir) return null;
        return max(0, (int) Carbon::now()->diffInDays($this->tanggal_berakhir, false));
    }

    public function getIsHampirBerakhirAttribute(): bool {
        return $this->sisa_hari !== null && $this->sisa_hari <= 30 && $this->status === 'aktif';
    }

    public function getBadgeClassAttribute(): string {
        return match ($this->status) {
            'aktif'        => 'bg-emerald-100 text-emerald-700',
            'berakhir'     => 'bg-gray-100 text-gray-600',
            'ditangguhkan' => 'bg-red-100 text-red-700',
            default        => 'bg-gray-100 text-gray-600',
        };
    }

    public function scopeAktif($query) {
        return $query->where('status', 'aktif');
    }

    public function scopeHampirBerakhir($query, int $hari = 30) {
        return $query->where('status', 'aktif')
            ->whereNotNull('tanggal_berakhir')
            ->whereBetween('tanggal_berakhir', [now(), now()->addDays($hari)]);
    }
}
