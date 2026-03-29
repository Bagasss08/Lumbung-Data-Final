# TODO Plan: Update lembaga-desa/index.blade.php for disable button + modal-hapus

- [ ] Step 1: Create this TODO file ✅
- [ ] Step 2: Add Alpine.js `x-data` to main container with `selectedIds`, `selectAll`, `toggleAll()`, `toggleOne()`
- [ ] Step 3: Update select-all checkbox with `x-model="selectAll" @change="toggleAll()"`
- [ ] Step 4: Update row checkboxes with `x-model="selectedIds" @change="toggleOne()"` and class="row-checkbox"
- [ ] Step 5: Transform bulk delete button: type="button", `:disabled`, `@click` for modalHapus.bukaJs(), dynamic classes/count
- [ ] Step 6: Add `<template x-for>` hidden inputs inside form for ids[]
- [ ] Step 7: Add `@include('admin.partials.modal-hapus')` before `@endsection`
- [ ] Step 8: Remove old vanilla JS checkbox event listeners and confirmDelete() function
- [ ] Step 9: Add `@method('DELETE')` to form if missing
- [ ] Step 10: Test & mark complete

