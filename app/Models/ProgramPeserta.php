<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPeserta extends Model {
    protected $table = 'program_peserta';

    protected $fillable = [
        'program_id',
        'penduduk_id',
        'peserta',
        'kartu_nama',
        'kartu_nik',
        'kartu_no_id',
        'kartu_tempat_lahir',
        'kartu_tanggal_lahir',
        'kartu_alamat',
    ];

    protected $casts = [
        'kartu_tanggal_lahir' => 'date',
    ];

    public function program() {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function penduduk() {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}
