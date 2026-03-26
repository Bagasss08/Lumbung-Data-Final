<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings'; // Nama tabel yang kita buat tadi

    protected $fillable = [
        'key',
        'value',
        'type'
    ];

    /**
     * Mempermudah pengambilan nilai setting
     */
    public static function getByKey($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}