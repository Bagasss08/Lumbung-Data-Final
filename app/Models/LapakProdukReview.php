<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LapakProdukReview extends Model
{
    protected $fillable = [
        'lapak_produk_id',
        'user_id',
        'rating',
        'komentar',
        'foto',
    ];

    public function produk()
    {
        return $this->belongsTo(LapakProduk::class, 'lapak_produk_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
