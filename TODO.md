# TODO: Enhance Autocomplete for KIA and Vaccine Forms

## Task
Add autocomplete for address (alamat) and village (dusun) fields when selecting residents in KIA and Vaccine forms.

## Steps:

### 1. Update KiaController
- [ ] Add `alamat` field to select query for $pendudukIbu and $pendudukAnak
- [ ] Add `wilayah_id` field to select query to get dusun information

### 2. Update VaksinController
- [ ] Add `alamat` field to select query for $pendudukList
- [ ] Add `wilayah_id` field to select query to get dusun information

### 3. Update kia-form.blade.php
- [ ] Add data-alamat attribute to option elements (for Ibu and Anak)
- [ ] Add data-dusun attribute to option elements
- [ ] Update JavaScript to auto-fill alamat_ibu and dusun fields

### 4. Update vaccin/form.blade.php
- [ ] Add data-alamat attribute to option elements
- [ ] Add data-dusun attribute to option elements
- [ ] Update JavaScript to auto-fill alamat and dusun fields
