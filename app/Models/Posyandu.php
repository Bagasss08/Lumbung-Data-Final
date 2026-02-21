<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posyandu extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'posyandu';

    protected $fillable = [
        'nama_posyandu',
        'dusun',
        'alamat',
        'rt',
        'rw',
        'wilayah_id',
        'hari_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'penanggung_jawab',
        'jumlah_kader',
        'status_posyandu',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_kader' => 'integer',
    ];

    // ==================
    // RELASI
    // ==================

    public function wilayah() {
        return $this->belongsTo(Wilayah::class);
    }

    public function kia() {
        return $this->hasMany(Kia::class);
    }

    public function pemantauanBumil() {
        return $this->hasMany(PemantauanBumil::class);
    }

    public function pemantauanAnak() {
        return $this->hasMany(PemantauanAnak::class);
    }

    // ==================
    // SCOPE
    // ==================

    public function scopeAktif($query) {
        return $query->where('status_posyandu', 'aktif');
    }

    // ==================
    // ACCESSOR
    // ==================

    public function getStatusLabelAttribute(): string {
        return $this->status_posyandu === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }
}
