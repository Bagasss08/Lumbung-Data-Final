<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kabupaten', 'nama_kabupaten', 'logo_desa', 'kecamatan', 'kantor_desa',
        'nama_desa', 'alamat_kantor', 'format_nomor', 'kepala_desa', 'kode_provinsi',
        'nama', 'nik', 'no_kk', 'kepala_kk', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'Alamat', 'kabupaten', 'agama', 'status', 'Pendidikan',
        'pekerjaan', 'warga_negara', 'form_keterangan', 'mulai_berlaku', 'tgl_akhir',
        'tgl_surat', 'penandatangan', 'nip_kepala_desa'
    ];
}