<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LapakProduk extends Model {
    protected $table = 'lapak_produk';

    protected $fillable = [
        'lapak_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'satuan',
        'foto',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok'  => 'integer',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_produk . '-' . uniqid());
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_produk')) {
                $model->slug = Str::slug($model->nama_produk . '-' . uniqid());
            }
        });
    }

    public function lapak(): BelongsTo {
        return $this->belongsTo(Lapak::class, 'lapak_id');
    }

    public function getFotoUrlAttribute(): string {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/no-image.png');
    }

    public function getHargaFormatAttribute(): string {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function scopeAktif($query) {
        return $query->where('status', 'aktif');
    }
}
