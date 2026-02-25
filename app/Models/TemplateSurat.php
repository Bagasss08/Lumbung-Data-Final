<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'jenis_surat_id',
        'nama_template',
        'versi_template',
        'file_template',
        'is_active',
        'tanggal_berlaku',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_berlaku' => 'date',
    ];

    // Relasi
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }


    // Helper methods
    public function getFileUrl()
    {
        if ($this->file_template) {
            return Storage::url($this->file_template);
        }
        return null;
    }

    public function getFileNameAttribute()
    {
        if ($this->file_template) {
            return basename($this->file_template);
        }
        return null;
    }

    // Scope untuk query
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}