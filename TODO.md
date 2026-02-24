# TODO - Perbaikan Error PembangunanController dan Pembangunan.php

## Issues yang ditemukan:

### 1. Error di app/Models/Pembangunan.php
- Model mereferensikan `TwebWilClusterdesa::class` yang tidak ada
- Seharusnya menggunakan `Wilayah::class` yang sudah ada di project

### 2. Error di app/Http/Controllers/admin/Pembangunan/PembangunanController.php
- Method `getWilayahList()` mencoba query tabel `tweb_wil_clusterdesa`
- Seharusnya query tabel `wilayah` yang sudah ada

### 3. Warning "Data wilayah administratif belum tersedia"
- Meskipun data sudah ada di tabel `wilayah`, tetap muncul warning
- Karena query mencari di tabel yang salah (`tweb_wil_clusterdesa`)

## Plan Perbaikan:

- [x] app/Models/Pembangunan.php
  - [x] Perbaiki relasi lokasi() → dari TwebWilClusterdesa ke Wilayah

- [x] app/Http/Controllers/admin/Pembangunan/PembangunanController.php
  - [x] Perbaiki getWilayahList() → dari tweb_wil_clusterdesa ke wilayah

- [x] Testing - Verifikasi perbaikan

## Ringkasan Perubahan:

1. **app/Models/Pembangunan.php**: 
   - Line ~73: `TwebWilClusterdesa::class` → `Wilayah::class`

2. **app/Http/Controllers/admin/Pembangunan/PembangunanController.php**:
   - Line ~247: `\DB::table('tweb_wil_clusterdesa')` → `\DB::table('wilayah')`
