{{-- resources/views/admin/bantuan/_form.blade.php --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Nama Program --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Nama Program <span class="text-red-500">*</span>
        </label>
        <input type="text" name="nama"
            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
            placeholder="Contoh: Program Keluarga Harapan (PKH)" value="{{ old('nama', $bantuan->nama ?? '') }}"
            required>
        @error('nama')
        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </p>
        @enderror
    </div>

    {{-- Sumber Dana --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sumber Dana</label>
        <input type="text" name="sumber_dana"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
            placeholder="Contoh: APBN, APBD, CSR..." value="{{ old('sumber_dana', $bantuan->sumber_dana ?? '') }}">
    </div>

    {{-- Tahun --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun</label>
        <input type="number" name="tahun"
            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('tahun') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
            placeholder="{{ date('Y') }}" min="2000" max="2099"
            value="{{ old('tahun', $bantuan->tahun ?? date('Y')) }}">
        @error('tahun')
        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nominal --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nominal (Rp)</label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400">Rp</span>
            <input type="number" name="nominal"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('nominal') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                placeholder="0" min="0" step="1000" value="{{ old('nominal', $bantuan->nominal ?? '') }}">
        </div>
        @error('nominal')
        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Sasaran --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Sasaran Penerima <span class="text-red-500">*</span>
        </label>
        <select name="sasaran"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all appearance-none"
            required>
            <option value="1" {{ old('sasaran', $bantuan->sasaran ?? 1) == 1 ? 'selected' : '' }}>Penduduk (Individu)
            </option>
            <option value="2" {{ old('sasaran', $bantuan->sasaran ?? 1) == 2 ? 'selected' : '' }}>Keluarga (Kepala KK)
            </option>
        </select>
    </div>

    {{-- Tanggal Mulai --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
            value="{{ old('tanggal_mulai', isset($bantuan) ? optional($bantuan->tanggal_mulai)->format('Y-m-d') : '') }}">
    </div>

    {{-- Tanggal Selesai --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
            value="{{ old('tanggal_selesai', isset($bantuan) ? optional($bantuan->tanggal_selesai)->format('Y-m-d') : '') }}">
        @error('tanggal_selesai')
        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status Program</label>
        <select name="status"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all appearance-none">
            <option value="1" {{ old('status', $bantuan->status ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('status', $bantuan->status ?? 1) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>

    {{-- Syarat / Kriteria --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Syarat / Kriteria Penerima</label>
        <textarea name="syarat" rows="3"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all resize-none"
            placeholder="Tuliskan syarat atau kriteria penerima bantuan...">{{ old('syarat', $bantuan->syarat ?? '') }}</textarea>
    </div>

    {{-- Keterangan --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan / Deskripsi</label>
        <textarea name="keterangan" rows="3"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all resize-none"
            placeholder="Deskripsi singkat tentang program ini...">{{ old('keterangan', $bantuan->keterangan ?? '') }}</textarea>
    </div>

</div>