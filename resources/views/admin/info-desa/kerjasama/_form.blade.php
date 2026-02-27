{{-- Partial: dipakai oleh create.blade.php dan edit.blade.php --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.kerjasama.index') }}" class="hover:text-emerald-600 transition-colors">Kerjasama</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900">{{ isset($kerjasama->id) ? 'Edit' : 'Tambah' }}</span>
</nav>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ namaFile: '' }">

        <div
            class="px-6 py-4 border-b border-gray-100 {{ isset($kerjasama->id) ? 'bg-gradient-to-r from-blue-50 to-indigo-50' : 'bg-gradient-to-r from-emerald-50 to-teal-50' }}">
            <h3 class="font-semibold text-gray-800">{{ isset($kerjasama->id) ? 'Edit Data Kerjasama' : 'Tambah Kerjasama
                Baru' }}</h3>
            <p class="text-xs text-gray-500 mt-0.5">Data perjanjian kerjasama dan kemitraan desa</p>
        </div>

        <form
            action="{{ isset($kerjasama->id) ? route('admin.kerjasama.update', $kerjasama) : route('admin.kerjasama.store') }}"
            method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @if(isset($kerjasama->id)) @method('PUT') @endif

            {{-- Nomor & Status --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Perjanjian</label>
                    <input type="text" name="nomor_perjanjian"
                        value="{{ old('nomor_perjanjian', $kerjasama->nomor_perjanjian ?? '') }}"
                        placeholder="cth: 001/KS/PKD/2024"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono @error('nomor_perjanjian') border-red-400 @enderror">
                    @error('nomor_perjanjian')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span
                            class="text-red-500">*</span></label>
                    <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white @error('status') border-red-400 @enderror">
                        <option value="aktif" {{ old('status', $kerjasama->status ?? 'aktif') === 'aktif' ? 'selected' :
                            '' }}>Aktif</option>
                        <option value="berakhir" {{ old('status', $kerjasama->status ?? '') === 'berakhir' ? 'selected'
                            : '' }}>Berakhir</option>
                        <option value="ditangguhkan" {{ old('status', $kerjasama->status ?? '') === 'ditangguhkan' ?
                            'selected' : '' }}>Ditangguhkan</option>
                    </select>
                </div>
            </div>

            {{-- Nama Mitra --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Mitra <span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama_mitra" value="{{ old('nama_mitra', $kerjasama->nama_mitra ?? '') }}"
                    placeholder="Nama instansi/lembaga/perusahaan mitra"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('nama_mitra') border-red-400 @enderror">
                @error('nama_mitra')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Jenis Mitra & Jenis Kerjasama --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Mitra</label>
                    <select name="jenis_mitra"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($daftarJenisMitra as $j)
                        <option value="{{ $j }}" {{ old('jenis_mitra', $kerjasama->jenis_mitra ?? '') === $j ?
                            'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kerjasama</label>
                    <select name="jenis_kerjasama"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($daftarJenisKerjasama as $j)
                        <option value="{{ $j }}" {{ old('jenis_kerjasama', $kerjasama->jenis_kerjasama ?? '') === $j ?
                            'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Alamat & Kontak --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Mitra</label>
                    <input type="text" name="alamat_mitra"
                        value="{{ old('alamat_mitra', $kerjasama->alamat_mitra ?? '') }}"
                        placeholder="Alamat kantor/instansi mitra"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kontak</label>
                    <input type="text" name="kontak_mitra"
                        value="{{ old('kontak_mitra', $kerjasama->kontak_mitra ?? '') }}"
                        placeholder="No. telp / email PIC"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            {{-- Masa Berlaku --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        value="{{ old('tanggal_mulai', $kerjasama->tanggal_mulai?->format('Y-m-d') ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('tanggal_mulai') border-red-400 @enderror">
                    @error('tanggal_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir"
                        value="{{ old('tanggal_berakhir', $kerjasama->tanggal_berakhir?->format('Y-m-d') ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('tanggal_berakhir') border-red-400 @enderror">
                    @error('tanggal_berakhir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Ruang Lingkup --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Ruang Lingkup Kerjasama</label>
                <textarea name="ruang_lingkup" rows="3" placeholder="Jelaskan cakupan dan tujuan kerjasama ini..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm resize-none">{{ old('ruang_lingkup', $kerjasama->ruang_lingkup ?? '') }}</textarea>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm resize-none">{{ old('keterangan', $kerjasama->keterangan ?? '') }}</textarea>
            </div>

            {{-- Upload Dokumen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dokumen Perjanjian</label>
                @if(isset($kerjasama->dokumen) && $kerjasama->dokumen)
                <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-xl border border-emerald-100 mb-3">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm text-emerald-700 flex-1">Dokumen sudah ada</span>
                    <a href="{{ Storage::url($kerjasama->dokumen) }}" target="_blank"
                        class="text-xs text-emerald-600 hover:underline font-medium">Lihat →</a>
                </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-emerald-400 transition-colors cursor-pointer"
                    @click="$refs.fileKerjasama.click()">
                    <input type="file" name="dokumen" x-ref="fileKerjasama" accept=".pdf,.doc,.docx" class="hidden"
                        @change="namaFile = $event.target.files[0]?.name">
                    <svg class="w-7 h-7 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-sm text-gray-500" x-text="namaFile || 'Klik untuk pilih file'"></p>
                    <p class="text-xs text-gray-400 mt-0.5">PDF, DOC, DOCX — Maks. 10MB</p>
                </div>
                @error('dokumen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    {{ isset($kerjasama->id) ? 'Perbarui Data' : 'Simpan Kerjasama' }}
                </button>
                <a href="{{ route('admin.kerjasama.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>