<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefPembangunanSumberDana extends Model {
    protected $table      = 'ref_pembangunan_sumber_dana';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    public    $incrementing = false;
    protected $keyType    = 'int';

    protected $fillable = ['id', 'nama'];

    public function pembangunan(): HasMany {
        return $this->hasMany(Pembangunan::class, 'id_sumber_dana');
    }
}
