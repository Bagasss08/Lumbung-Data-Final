<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisatas';

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'deskripsi',
        'gambar',
        'lokasi',
        'jam_buka',
        'harga_tiket',
        'fasilitas',
        'status',
    ];

    protected $casts = [
        'fasilitas' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getGambarUrlAttribute(): string
{
    // Cek apakah file ada di disk public folder wisata
    if ($this->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists('wisata/' . $this->gambar)) {
        return asset('storage/wisata/' . $this->gambar);
    }
    
    // Jika tidak ada, tampilkan placeholder
    return 'https://via.placeholder.com/600x400?text=' . urlencode($this->nama);
}

    public function getDeskripsiSingkatAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->deskripsi ?? ''), 100);
    }

    /*
    |--------------------------------------------------------------------------
    | EVENTS — auto-generate slug saat create/update
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (self $wisata) {
            if (empty($wisata->slug)) {
                $wisata->slug = static::generateUniqueSlug($wisata->nama);
            }
        });

        static::updating(function (self $wisata) {
            if ($wisata->isDirty('nama') && empty($wisata->getOriginal('slug'))) {
                $wisata->slug = static::generateUniqueSlug($wisata->nama, $wisata->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $nama, ?int $excludeId = null): string
    {
        $slug = Str::slug($nama);
        $count = 1;

        while (true) {
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = Str::slug($nama) . '-' . $count++;
        }

        return $slug;
    }
}