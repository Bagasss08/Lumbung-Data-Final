{{--
Partial form – digunakan oleh create.blade.php & edit.blade.php
Variabel yang dibutuhkan:
$jabatanList : Collection dikelompokkan berdasarkan golongan
$pemerintahDesa : model PerangkatDesa (hanya ada saat edit)
--}}
@php $isEdit = isset($pemerintahDesa); @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri: Foto ──────────────────────────────────── --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center gap-4">
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
    <div class="lg:col-span-2 space-y-5">

        {{-- Card 1: Identitas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-3">
                Identitas Perangkat
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Jabatan --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="jabatan_id"
                        class="w-full px-3 py-2.5 rounded-xl border @error('jabatan_id') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
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
                    @error('jabatan_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nama --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $isEdit ? $pemerintahDesa->nama : '') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-3 py-2.5 rounded-xl border @error('nama') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK</label>
                    <input type="text" name="nik" maxlength="16"
                        value="{{ old('nik', $isEdit ? $pemerintahDesa->nik : '') }}" placeholder="16 digit NIK"
                        class="w-full px-3 py-2.5 rounded-xl border @error('nik') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Urutan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="urutan" min="0"
                        value="{{ old('urutan', $isEdit ? $pemerintahDesa->urutan : 0) }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
        </div>

        {{-- Card 2: Data SK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-3">
                Surat Keputusan (SK)
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- No SK --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor SK</label>
                    <input type="text" name="no_sk" value="{{ old('no_sk', $isEdit ? $pemerintahDesa->no_sk : '') }}"
                        placeholder="Contoh: 141/01/2024"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>

                {{-- Tanggal SK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal SK</label>
                    <input type="date" name="tanggal_sk"
                        value="{{ old('tanggal_sk', $isEdit && $pemerintahDesa->tanggal_sk ? $pemerintahDesa->tanggal_sk->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                        class="w-full px-3 py-2.5 rounded-xl border @error('status') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
                        <option value="1" {{ old('status', $isEdit ? $pemerintahDesa->status : '1') === '1' ? 'selected'
                            : '' }}>Aktif</option>
                        <option value="2" {{ old('status', $isEdit ? $pemerintahDesa->status : '1') === '2' ? 'selected'
                            : '' }}>Non-Aktif</option>
                    </select>
                    @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Periode Mulai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Periode Mulai</label>
                    <input type="date" name="periode_mulai"
                        value="{{ old('periode_mulai', $isEdit && $pemerintahDesa->periode_mulai ? $pemerintahDesa->periode_mulai->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>

                {{-- Periode Selesai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Periode Selesai</label>
                    <input type="date" name="periode_selesai"
                        value="{{ old('periode_selesai', $isEdit && $pemerintahDesa->periode_selesai ? $pemerintahDesa->periode_selesai->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2.5 rounded-xl border @error('periode_selesai') border-red-400 @else border-gray-200 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    @error('periode_selesai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Keterangan --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none">{{ old('keterangan', $isEdit ? $pemerintahDesa->keterangan : '') }}</textarea>
                </div>
            </div>
        </div>

    </div>{{-- end kolom kanan --}}
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