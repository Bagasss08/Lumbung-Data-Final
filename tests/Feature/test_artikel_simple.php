<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Artikel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    // Test creating an artikel
    $artikel = new Artikel();
    $artikel->nama = 'Test Artikel';
    $artikel->deskripsi = 'Ini adalah artikel test';
    $artikel->save();

    echo "Artikel berhasil dibuat dengan ID: " . $artikel->id . "\n";

    // Test retrieving artikels
    $artikels = Artikel::all();
    echo "Total artikel di database: " . $artikels->count() . "\n";

    foreach ($artikels as $art) {
        echo "- ID: {$art->id}, Nama: {$art->nama}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
