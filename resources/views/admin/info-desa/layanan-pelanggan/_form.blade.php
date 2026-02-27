{{-- Partial: dipakai oleh create.blade.php dan edit.blade.php --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.layanan-pelanggan.index') }}" class="hover:text-emerald-600 transition-colors">Layanan
        Pelanggan</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900">{{ isset($layananPelanggan->id) ? 'Edit' : 'Tambah' }}</span>
</nav>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-100 {{ isset($layananPelanggan->id) ? 'bg-gradient-to-r from-blue-50 to-indigo-50' : 'bg-gradient-to-r from-emerald-50 to-teal-50' }}">
            <h3 class="font-semibold text-gray-800">{{ isset($layananPelanggan->id) ? 'Edit Layanan' : 'Tambah Layanan
                Pelanggan' }}</h3>
            <p class="text-xs text-gray-500 mt-0.5">Isi informasi layanan publik yang tersedia di desa</p>
        </div>

        <form
            action="{{ isset($layananPelanggan->id) ? route('admin.layanan-pelanggan.update', $layananPelanggan) : route('admin.layanan-pelanggan.store') }}"
            method="POST" class="p-6 space-y-5">
            @csrf
            @if(isset($layananPelanggan->id)) @method('PUT') @endif

            {{-- Nama & Kode --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Layanan <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_layanan"
                        value="{{ old('nama_layanan', $layananPelanggan->nama_layanan ?? '') }}"
                        placeholder="cth: Pembuatan KTP Elektronik"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('nama_layanan') border-red-400 @enderror">
                    @error('nama_layanan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Layanan</label>
                    <input type="text" name="kode_layanan"
                        value="{{ old('kode_layanan', $layananPelanggan->kode_layanan ?? '') }}"
                        placeholder="cth: SKD-001"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono @error('kode_layanan') border-red-400 @enderror">
                    @error('kode_layanan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Jenis & Status --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Layanan</label>
                    <select name="jenis_layanan"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($daftarJenis as $j)
                        <option value="{{ $j }}" {{ old('jenis_layanan', $layananPelanggan->jenis_layanan ?? '') === $j
                            ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span
                            class="text-red-500">*</span></label>
                    <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white @error('status') border-red-400 @enderror">
                        <option value="aktif" {{ old('status', $layananPelanggan->status ?? 'aktif') === 'aktif' ?
                            'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $layananPelanggan->status ?? '') === 'nonaktif' ?
                            'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Layanan</label>
                <textarea name="deskripsi" rows="3"
                    placeholder="Jelaskan apa layanan ini dan siapa yang membutuhkannya..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm resize-none">{{ old('deskripsi', $layananPelanggan->deskripsi ?? '') }}</textarea>
            </div>

            {{-- Persyaratan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Persyaratan</label>
                <p class="text-xs text-gray-400 mb-1.5">Tulis satu persyaratan per baris</p>
                <textarea name="persyaratan" rows="5"
                    placeholder="Fotokopi KTP&#10;Fotokopi KK&#10;Surat pengantar RT/RW&#10;Pas foto 3x4 (2 lembar)"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono resize-none">{{ old('persyaratan', $layananPelanggan->persyaratan ?? '') }}</textarea>
            </div>

            {{-- Penanggung Jawab & Waktu --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab"
                        value="{{ old('penanggung_jawab', $layananPelanggan->penanggung_jawab ?? '') }}"
                        placeholder="cth: Seksi Pelayanan"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu Penyelesaian</label>
                    <input type="text" name="waktu_penyelesaian"
                        value="{{ old('waktu_penyelesaian', $layananPelanggan->waktu_penyelesaian ?? '') }}"
                        placeholder="cth: 1 hari kerja"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            {{-- Biaya & Urutan --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Biaya</label>
                    <input type="text" name="biaya" value="{{ old('biaya', $layananPelanggan->biaya ?? '') }}"
                        placeholder="cth: Gratis / Rp 10.000"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="urutan" min="0"
                        value="{{ old('urutan', $layananPelanggan->urutan ?? 0) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Angka lebih kecil = tampil lebih atas</p>
                </div>
            </div>

            {{-- Dasar Hukum --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dasar Hukum</label>
                <input type="text" name="dasar_hukum"
                    value="{{ old('dasar_hukum', $layananPelanggan->dasar_hukum ?? '') }}"
                    placeholder="cth: Permendagri No. 2/2017 tentang Standar Pelayanan..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>

            {{-- Relasi Surat (jika modul surat ada) --}}
            @if($modulSuratAda && $suratFormats->isNotEmpty())
            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                <label class="block text-sm font-semibold text-blue-800 mb-1.5">
                    🔗 Terhubung dengan Surat
                </label>
                <p class="text-xs text-blue-600 mb-3">Pilih template surat yang digunakan untuk layanan ini</p>
                <select name="surat_format_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm bg-white">
                    <option value="">-- Tidak perlu surat --</option>
                    @foreach($suratFormats as $sf)
                    <option value="{{ $sf->id }}" {{ old('surat_format_id', $layananPelanggan->surat_format_id ?? '') ==
                        $sf->id ? 'selected' : '' }}>
                        {{ $sf->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            @elseif(!$modulSuratAda)
            <div class="p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <p class="text-xs text-gray-400 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Relasi ke modul Layanan Surat akan aktif setelah modul surat diinstall.
                </p>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    {{ isset($layananPelanggan->id) ? 'Perbarui Layanan' : 'Simpan Layanan' }}
                </button>
                <a href="{{ route('admin.layanan-pelanggan.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>