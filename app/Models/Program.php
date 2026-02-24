<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model {
    protected $table = 'program';

    protected $fillable = [
        'nama',
        'sumber_dana',
        'tahun',
        'keterangan',
        'nominal',
        'syarat',
        'sasaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_selesai'  => 'date',
        'nominal'          => 'decimal:2',
    ];

    public function peserta() {
        return $this->hasMany(ProgramPeserta::class, 'program_id');
    }

    public function getSasaranLabelAttribute(): string {
        return $this->sasaran == 1 ? 'Penduduk' : 'Keluarga';
    }

    public function getStatusLabelAttribute(): string {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
