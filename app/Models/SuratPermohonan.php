<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPermohonan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'surat_permohonan';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Pastikan 'jenis_surat_id' atau 'surat_template_id' ada di sini
     * sesuai dengan kolom yang ada di database Anda.
     */
    protected $fillable = [
        'penduduk_id',
        'surat_template_id', // Tambahkan ini jika Anda berencana me-rename kolom
        'keperluan',
        'dokumen_pendukung',
        'data_isian',
        'status',
        'tanggal_permohonan',
        'catatan_petugas',   // <-- Tambahkan ini
        'notif_dibaca',      // <-- Tambahkan ini juga
    ];

    protected $casts = [
        'data_isian' => 'array',
    ];

    /**
     * Relasi: Permohonan Surat dimiliki oleh satu Template Surat.
     * Kita beri nama 'suratTemplate' agar sesuai dengan panggilan di Controller.
     */
    public function suratTemplate()
{
    // Pastikan foreign key di sini adalah 'surat_template_id' sesuai DB Anda sekarang
    return $this->belongsTo(SuratTemplate::class, 'surat_template_id');
}

    /**
     * Relasi: Permohonan Surat diajukan oleh satu Penduduk (Warga).
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    /**
     * Scope untuk mempermudah filter berdasarkan status jika diperlukan nanti.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
