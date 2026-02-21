<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaksin extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'vaksin';

    protected $fillable = [
        'nik',
        'penduduk_id',
        'nama_penerima',
        'jenis_kelamin',
        'tgl_lahir',
        'umur',
        'dusun',
        'rt',
        'rw',
        'wilayah_id',
        'user_id',
        'alamat',
        'jenis_vaksin',
        'kategori_vaksin',
        'dosis',
        'tanggal_vaksin',
        'tempat_pelayanan',
        'petugas',
        'batch_vaksin',
        'status',
        'no_sertifikat',
        'keterangan',
    ];

    protected $casts = [
        'tgl_lahir'      => 'date',
        'tanggal_vaksin' => 'date',
        'dosis'          => 'integer',
        'umur'           => 'integer',
    ];

    // ==================
    // RELASI
    // ==================

    public function penduduk() {
        return $this->belongsTo(Penduduk::class);
    }

    public function wilayah() {
        return $this->belongsTo(Wilayah::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // ==================
    // SCOPE
    // ==================

    public function scopeSudahVaksin($query) {
        return $query->where('status', 'sudah');
    }

    public function scopeBelumVaksin($query) {
        return $query->where('status', 'belum');
    }

    public function scopeByJenisVaksin($query, string $jenis) {
        return $query->where('jenis_vaksin', $jenis);
    }

    // ==================
    // ACCESSOR
    // ==================

    public function getDosisLabelAttribute(): string {
        return match ($this->dosis) {
            1       => 'Dosis 1',
            2       => 'Dosis 2',
            3       => 'Dosis 3 / Booster',
            4       => 'Booster',
            5       => 'Lengkap',
            6       => 'Ulangan',
            default => 'Dosis ' . $this->dosis,
        };
    }

    public function getStatusLabelAttribute(): string {
        return match ($this->status) {
            'sudah' => 'Sudah Vaksin',
            'belum' => 'Belum Vaksin',
            'tunda' => 'Ditunda',
            default => '-',
        };
    }

    public function getStatusBadgeAttribute(): string {
        return match ($this->status) {
            'sudah' => 'success',
            'belum' => 'danger',
            'tunda' => 'warning',
            default => 'secondary',
        };
    }
}
