{{--
Partial form – digunakan oleh create.blade.php & edit.blade.php
Variabel yang dibutuhkan:
$jabatanList : Collection dikelompokkan berdasarkan golongan
$pemerintahDesa : model PerangkatDesa (hanya ada saat edit)
--}}
@php $isEdit = isset($pemerintahDesa); @endphp

<div class="p-6 space-y-6">

    {{-- Info tip --}}
    <div class="flex items-center gap-2.5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke-width="2"/>
            <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
            <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"/>
        </svg>
        <p class="text-amber-700 text-xs">
            Kolom bertanda <strong class="text-amber-600">*</strong> wajib diisi sebelum menyimpan data.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kiri: Foto ──────────────────────────────────── --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-center gap-4">
                {{-- Preview Foto --}}
                <div id="fotoPreviewWrapper"
                    class="w-36 h-36 rounded-2xl bg-emerald-50 overflow-hidden border-2 border-dashed border-emerald-200 flex items-center justify-center relative">
                    @if($isEdit && $pemerintahDesa->foto)
                    <img id="fotoPreview" src="{{ asset('storage/' . $pemerintahDesa->foto) }}"
                        alt="{{ $pemerintahDesa->nama }}" class="w-full h-full object-cover">
                    @else
                    <div id="fotoPlaceholder" class="flex flex-col items-center text-emerald-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-xs mt-1">Foto</p>
                    </div>
                    @if($isEdit) <img id="fotoPreview" class="hidden w-full h-full object-cover"> @endif
                    @endif
                </div>

                <label class="cursor-pointer">
                    <span
                        class="px-4 py-2 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-xl hover:bg-emerald-100 transition">
                        Pilih Foto
                    </span>
                    <input type="file" name="foto" id="fotoInput" accept="image/*" class="hidden"
                        onchange="previewFoto(this)">
                </label>
                <p class="text-xs text-gray-400 text-center">JPG/PNG, maks. 2MB</p>

                @error('foto')
                <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ── Kolom Kanan: Data Utama ────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card 1: Identitas --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 tracking-wide uppercase">
                        Identitas Perangkat
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Jabatan --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Jabatan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <select name="jabatan_id"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('jabatan_id') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent bg-white">
                                <option value="">– Pilih Jabatan –</option>
                                @foreach($jabatanList as $golongan => $items)
                                <optgroup label="{{ $golongan === 'pemerintah_desa' ? 'Pemerintah Desa' : 'BPD' }}">
                                    @foreach($items as $jabatan)
                                    <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $isEdit ? $pemerintahDesa->
                                        jabatan_id : '') == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->nama }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        @error('jabatan_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="nama" value="{{ old('nama', $isEdit ? $pemerintahDesa->nama : '') }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('nama') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">NIK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <input type="text" name="nik" maxlength="16"
                                value="{{ old('nik', $isEdit ? $pemerintahDesa->nik : '') }}" placeholder="16 digit NIK"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('nik') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                        @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Urutan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <input type="number" name="urutan" min="0"
                                value="{{ old('urutan', $isEdit ? $pemerintahDesa->urutan : 0) }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Data SK --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 tracking-wide uppercase">
                        Surat Keputusan (SK)
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- No SK --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor SK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <input type="text" name="no_sk" value="{{ old('no_sk', $isEdit ? $pemerintahDesa->no_sk : '') }}"
                                placeholder="Contoh: 141/01/2024"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Tanggal SK --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal SK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" name="tanggal_sk"
                                value="{{ old('tanggal_sk', $isEdit && $pemerintahDesa->tanggal_sk ? $pemerintahDesa->tanggal_sk->format('Y-m-d') : '') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <select name="status"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('status') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent bg-white">
                                <option value="1" {{ old('status', $isEdit ? $pemerintahDesa->status : '1') === '1' ? 'selected'
                                    : '' }}>Aktif</option>
                                <option value="2" {{ old('status', $isEdit ? $pemerintahDesa->status : '1') === '2' ? 'selected'
                                    : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                        @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Periode Mulai --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Mulai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" name="periode_mulai"
                                value="{{ old('periode_mulai', $isEdit && $pemerintahDesa->periode_mulai ? $pemerintahDesa->periode_mulai->format('Y-m-d') : '') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Periode Selesai --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Selesai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" name="periode_selesai"
                                value="{{ old('periode_selesai', $isEdit && $pemerintahDesa->periode_selesai ? $pemerintahDesa->periode_selesai->format('Y-m-d') : '') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('periode_selesai') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
                        </div>
                        @error('periode_selesai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent resize-none">{{ old('keterangan', $isEdit ? $pemerintahDesa->keterangan : '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>{{-- end kolom kanan --}}
    </div>
</div>

@push('scripts')
<script>
    function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img         = document.getElementById('fotoPreview');
        const placeholder = document.getElementById('fotoPlaceholder');
        img.src           = e.target.result;
        img.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush

