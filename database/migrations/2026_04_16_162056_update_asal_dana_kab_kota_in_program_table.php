<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Gabungkan nilai 'Kab' dan 'Kota' menjadi 'Kab/Kota'
        DB::table('program')
            ->whereIn('asal_dana', ['Kab', 'Kota'])
            ->update(['asal_dana' => 'Kab/Kota']);
    }

    public function down(): void {
        // Tidak bisa dikembalikan secara akurat karena
        // tidak tahu mana yang asalnya 'Kab' dan mana 'Kota'
        // Biarkan kosong atau log saja
    }
};
