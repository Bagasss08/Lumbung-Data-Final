<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RumahTangga;
use App\Models\Wilayah;

echo "=== Testing Delete Functionality ===\n\n";

// Create test data
echo "1. Creating test data...\n";

$wilayah = Wilayah::create([
    'dusun' => 'Test Dusun',
    'rt' => '01',
    'rw' => '01',
    'desa_id' => 1,
    'laki_laki' => 0,
    'perempuan' => 0
]);

$uniqueId = time() . rand(1000, 9999);

$penduduk = Penduduk::create([
    'nik' => '1234567890' . $uniqueId,
    'nama' => 'Test Penduduk ' . $uniqueId,
    'jenis_kelamin' => 'L',
    'tempat_lahir' => 'Test City',
    'tanggal_lahir' => '1990-01-01',
    'agama' => 'Islam',
    'pendidikan' => 'SMA',
    'pekerjaan' => 'bekerja',
    'status_kawin' => 'belum_kawin',
    'status_hidup' => 'hidup',
    'alamat' => 'Test Address',
    'wilayah_id' => $wilayah->id
]);

$keluarga = Keluarga::create([
    'no_kk' => '1234567890' . $uniqueId,
    'alamat' => 'Test Family Address',
    'wilayah_id' => $wilayah->id,
    'tgl_terdaftar' => '2024-01-01',
    'klasifikasi_ekonomi' => 'mampu'
]);

$rumahTangga = RumahTangga::create([
    'no_rumah_tangga' => 'RT' . $uniqueId,
    'alamat' => 'Test Household Address',
    'wilayah_id' => $wilayah->id,
    'jumlah_anggota' => 1,
    'klasifikasi_ekonomi' => 'mampu',
    'tgl_terdaftar' => '2024-01-01'
]);

// Attach relationships
$keluarga->anggota()->attach($penduduk->id, ['hubungan_keluarga' => 'kepala_keluarga']);
$rumahTangga->anggota()->attach($penduduk->id, ['hubungan_rumah_tangga' => 'kepala_rumah_tangga']);

echo "   ✓ Test data created\n";
echo "   - Penduduk ID: {$penduduk->id}\n";
echo "   - Keluarga ID: {$keluarga->id}\n";
echo "   - Rumah Tangga ID: {$rumahTangga->id}\n\n";

// Test 1: Try to delete Keluarga with members (should fail)
echo "2. Testing Keluarga delete with members (should fail)...\n";
try {
    $keluarga->delete();
    echo "   ✗ ERROR: Keluarga was deleted despite having members!\n";
} catch (Exception $e) {
    echo "   ✓ SUCCESS: Keluarga delete prevented - {$e->getMessage()}\n";
}

// Test 2: Try to delete RumahTangga with members (should fail)
echo "3. Testing RumahTangga delete with members (should fail)...\n";
try {
    $rumahTangga->delete();
    echo "   ✗ ERROR: RumahTangga was deleted despite having members!\n";
} catch (Exception $e) {
    echo "   ✓ SUCCESS: RumahTangga delete prevented - {$e->getMessage()}\n";
}

// Test 3: Delete Penduduk (should detach relationships and succeed)
echo "4. Testing Penduduk delete (should detach relationships and succeed)...\n";

$keluargaAnggotaCountBefore = $keluarga->anggota()->count();
$rumahTanggaAnggotaCountBefore = $rumahTangga->anggota()->count();

echo "   - Keluarga anggota count before: {$keluargaAnggotaCountBefore}\n";
echo "   - RumahTangga anggota count before: {$rumahTanggaAnggotaCountBefore}\n";

try {
    $penduduk->delete();
    echo "   ✓ SUCCESS: Penduduk deleted successfully\n";

    $keluargaAnggotaCountAfter = $keluarga->fresh()->anggota()->count();
    $rumahTanggaAnggotaCountAfter = $rumahTangga->fresh()->anggota()->count();

    echo "   - Keluarga anggota count after: {$keluargaAnggotaCountAfter}\n";
    echo "   - RumahTangga anggota count after: {$rumahTanggaAnggotaCountAfter}\n";

    if ($keluargaAnggotaCountAfter == 0 && $rumahTanggaAnggotaCountAfter == 0) {
        echo "   ✓ SUCCESS: Relationships properly detached\n";
    } else {
        echo "   ✗ ERROR: Relationships not properly detached\n";
    }
} catch (Exception $e) {
    echo "   ✗ ERROR: Penduduk delete failed - {$e->getMessage()}\n";
}

// Test 4: Now delete Keluarga (should succeed since no members)
echo "5. Testing Keluarga delete after removing members (should succeed)...\n";
try {
    $keluarga->delete();
    echo "   ✓ SUCCESS: Keluarga deleted successfully\n";
} catch (Exception $e) {
    echo "   ✗ ERROR: Keluarga delete failed - {$e->getMessage()}\n";
}

// Test 5: Now delete RumahTangga (should succeed since no members)
echo "6. Testing RumahTangga delete after removing members (should succeed)...\n";
try {
    $rumahTangga->delete();
    echo "   ✓ SUCCESS: RumahTangga deleted successfully\n";
} catch (Exception $e) {
    echo "   ✗ ERROR: RumahTangga delete failed - {$e->getMessage()}\n";
}

// Cleanup
echo "7. Cleaning up test data...\n";
$wilayah->delete();
echo "   ✓ Test data cleaned up\n";

echo "\n=== Testing Complete ===\n";
