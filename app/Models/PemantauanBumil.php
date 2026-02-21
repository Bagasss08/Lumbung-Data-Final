<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanBumil extends Model {
    use HasFactory;

    protected $table = 'pemantauan_bumil';

    protected $fillable = [
        'kia_id',
        'posyandu_id',
        'user_id',
        'tanggal_pemantauan',
        'bulan',
        'tahun',
        'usia_kehamilan',
        'berat_badan',
        'tinggi_badan',
        'tekanan_darah_sistole',
        'tekanan_darah_diastole',
        'lingkar_lengan',
        'status_kehamilan',
        'dapat_pil_fe',
        'jumlah_pil_fe',
        'imunisasi_tt',
        'dapat_vit_a',
        'dapat_tablet_tambah_darah',
        'pemeriksaan_lab',
        'konseling_gizi',
        'anemia',
        'kek',
        'petugas',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemantauan'    => 'date',
        'bulan'                 => 'integer',
        'tahun'                 => 'integer',
        'usia_kehamilan'        => 'integer',
        'berat_badan'           => 'decimal:2',
        'tinggi_badan'          => 'decimal:2',
        'lingkar_lengan'        => 'decimal:2',
        'tekanan_darah_sistole' => 'decimal:1',
        'tekanan_darah_diastole' => 'decimal:1',
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

    public function getTekananDarahAttribute(): string {
        if ($this->tekanan_darah_sistole && $this->tekanan_darah_diastole) {
            return $this->tekanan_darah_sistole . '/' . $this->tekanan_darah_diastole;
        }
        return '-';
    }

    public function getNamaBulanAttribute(): string {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        return $bulan[$this->bulan] ?? '-';
    }
}
