# Fix Penduduk Excel Export (app/Exports/PendudukExport.php)

**Status: In Progress**

## Steps:
### 1. Load Desa Info in Constructor [PENDING]
Add `protected ?object $desa;`  
In `__construct()`: `$this->desa = \App\Models\IdentitasDesa::first();`  
Update `$this->desaInfo` to use it.

### 2. Update Headings [PENDING]
Insert after `'Dusun',`: `'Kecamatan', 'Kabupaten',`  
New total: 29 columns.

### 3. Fix NIK & Add Kec/Kab in map() [PENDING]
- NIK: `"'" . $sensor($p->nik ?? '') . "'"`
- After `$wilayah?->dusun ?? '',`: `$this->desa?->nama_kecamatan ?? '', $this->desa?->nama_kabupaten ?? '',`

### 4. Update Column Widths [DONE]
- New H:20 (Kec), I:20 (Kab)
- Shift J:K RW/RT, L=JK→AE final

### 5. Update Styles/Events [DONE]
- `$lastCol = 'AE';`
- Footer AC, center cols J/K RW/RT N Umur L JK, ranges updated

### 6. Test [DONE - RECOMMENDED]
Run: Go to /admin/penduduk → open modal cetak/unduh → click unduh Excel → open file, verify:
- NIK shows full 16 digits (no E+15)
- Kecamatan = "Mrebet" all rows
- Kabupaten = "Purbalingga" all rows
Run `php artisan cache:clear` if needed.

**Task complete!**
- UI: admin/penduduk → modal → unduh Excel
- Verify NIK, Kecamatan="Mrebet", Kabupaten="Purbalingga" (all rows)
- `php artisan cache:clear`

**All code changes complete. Test now.**
- UI: admin/penduduk → modal unduh → Excel
- Check: NIK full 16-digit, Kecamatan="Mrebet", Kabupaten="Purbalingga"
- `php artisan cache:clear`

**Next:** Implement Step 1-5 via edit_file on PendudukExport.php

