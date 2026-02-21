<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lapak extends Model {
    protected $table = 'lapak';

    protected $fillable = [
        'penduduk_id',
        'nama_toko',
        'slug',
        'deskripsi',
        'foto',
        'telepon',
        'alamat',
        'link_maps',
        'status',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_toko);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_toko')) {
                $model->slug = Str::slug($model->nama_toko);
            }
        });
    }

    public function penduduk(): BelongsTo {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function produk(): HasMany {
        return $this->hasMany(LapakProduk::class, 'lapak_id');
    }

    public function produkAktif(): HasMany {
        return $this->hasMany(LapakProduk::class, 'lapak_id')->where('status', 'aktif');
    }

    public function getFotoUrlAttribute(): string {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/no-image.png');
    }

    public function scopeAktif($query) {
        return $query->where('status', 'aktif');
    }
}
