<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CetakSurat extends Model
{
    protected $table = 'cetak_surat';
    
    protected $fillable = [
        'template_id',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'keterangan',
        'data_warga',
        'file_surat',
        'generated_file',
        'status',
        'created_by'
    ];

    protected $casts = [
        'data_warga' => 'array',
        'tanggal_surat' => 'date'
    ];

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'template_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}