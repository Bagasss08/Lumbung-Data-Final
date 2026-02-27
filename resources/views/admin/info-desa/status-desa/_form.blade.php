<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.status-desa.index') }}" class="hover:text-emerald-600 transition-colors">Status Desa</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900">{{ isset($statusDesa->id) ? 'Edit' : 'Tambah' }}</span>
</nav>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="idmForm()">

        <div
            class="px-6 py-4 border-b border-gray-100 {{ isset($statusDesa->id) ? 'bg-gradient-to-r from-blue-50 to-indigo-50' : 'bg-gradient-to-r from-emerald-50 to-teal-50' }}">
            <h3 class="font-semibold text-gray-800">{{ isset($statusDesa->id) ? 'Edit Data IDM' : 'Tambah Data IDM' }}
            </h3>
            <p class="text-xs text-gray-500 mt-0.5">Nilai IDM = rata-rata IKS + IKE + IKL (dapat dihitung otomatis)</p>
        </div>

        <form
            action="{{ isset($statusDesa->id) ? route('admin.status-desa.update', $statusDesa) : route('admin.status-desa.store') }}"
            method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if(isset($statusDesa->id)) @method('PUT') @endif

            {{-- Baris 1: Nama & Tahun --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Status <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_status"
                        value="{{ old('nama_status', $statusDesa->nama_status ?? 'IDM') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('nama_status') border-red-400 @enderror">
                    @error('nama_status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="tahun" value="{{ old('tahun', $statusDesa->tahun ?? date('Y')) }}"
                        min="2000" :max="{{ date('Y') + 1 }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm @error('tahun') border-red-400 @enderror">
                    @error('tahun')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ── Skor 3 Dimensi IDM ──────────────────────────────── --}}
            <div class="p-5 bg-gray-50 rounded-xl border border-gray-100 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold text-gray-700">Skor 3 Dimensi IDM</h4>
                    <button type="button" @click="hitungOtomatis"
                        class="inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:text-emerald-800 font-medium bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Hitung Nilai Otomatis
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    {{-- IKS --}}
                    <div>
                        <label class="block text-xs font-semibold text-blue-700 mb-1.5">
                            IKS <span class="font-normal text-gray-500">(Ketahanan Sosial)</span>
                        </label>
                        <input type="number" name="skor_ketahanan_sosial" x-model="iks" @input="hitungOtomatis"
                            value="{{ old('skor_ketahanan_sosial', $statusDesa->skor_ketahanan_sosial ?? '0') }}"
                            step="0.0001" min="0" max="1" placeholder="0.0000"
                            class="w-full px-3 py-2.5 rounded-xl border border-blue-100 bg-blue-50/50 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-mono @error('skor_ketahanan_sosial') border-red-400 @enderror">
                        @error('skor_ketahanan_sosial')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- IKE --}}
                    <div>
                        <label class="block text-xs font-semibold text-amber-700 mb-1.5">
                            IKE <span class="font-normal text-gray-500">(Ketahanan Ekonomi)</span>
                        </label>
                        <input type="number" name="skor_ketahanan_ekonomi" x-model="ike" @input="hitungOtomatis"
                            value="{{ old('skor_ketahanan_ekonomi', $statusDesa->skor_ketahanan_ekonomi ?? '0') }}"
                            step="0.0001" min="0" max="1" placeholder="0.0000"
                            class="w-full px-3 py-2.5 rounded-xl border border-amber-100 bg-amber-50/50 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm font-mono @error('skor_ketahanan_ekonomi') border-red-400 @enderror">
                        @error('skor_ketahanan_ekonomi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- IKL --}}
                    <div>
                        <label class="block text-xs font-semibold text-teal-700 mb-1.5">
                            IKL <span class="font-normal text-gray-500">(Ketahanan Ekologi)</span>
                        </label>
                        <input type="number" name="skor_ketahanan_ekologi" x-model="ikl" @input="hitungOtomatis"
                            value="{{ old('skor_ketahanan_ekologi', $statusDesa->skor_ketahanan_ekologi ?? '0') }}"
                            step="0.0001" min="0" max="1" placeholder="0.0000"
                            class="w-full px-3 py-2.5 rounded-xl border border-teal-100 bg-teal-50/50 focus:outline-none focus:ring-2 focus:ring-teal-400 text-sm font-mono @error('skor_ketahanan_ekologi') border-red-400 @enderror">
                        @error('skor_ketahanan_ekologi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Preview hasil hitung --}}
                <div x-show="nilaiOtomatis > 0" x-transition
                    class="flex items-center gap-2 text-xs text-emerald-700 bg-emerald-50 rounded-lg px-3 py-2 border border-emerald-100">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Nilai IDM otomatis: <strong x-text="nilaiOtomatis.toFixed(4)"></strong>
                    &nbsp;→ Status: <strong x-text="statusOtomatis"></strong>
                </div>
            </div>

            {{-- ── Nilai Total & Status ────────────────────────────── --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nilai IDM Total <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="nilai" x-model="nilaiManual"
                        value="{{ old('nilai', $statusDesa->nilai ?? '') }}" step="0.0001" min="0" max="1"
                        placeholder="0.0000"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono @error('nilai') border-red-400 @enderror">
                    <p class="text-xs text-gray-400 mt-1">Bisa diisi manual atau klik "Hitung Otomatis"</p>
                    @error('nilai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status IDM <span
                            class="text-red-500">*</span></label>
                    <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white @error('status') border-red-400 @enderror">
                        <option value="">-- Pilih Status --</option>
                        @foreach($daftarStatus as $s)
                        <option value="{{ $s }}" {{ old('status', $statusDesa->status ?? '') === $s ? 'selected' : ''
                            }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ── Target (Opsional) ───────────────────────────────── --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Status</label>
                    <select name="status_target"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                        <option value="">-- Tidak ada target --</option>
                        @foreach($daftarStatus as $s)
                        <option value="{{ $s }}" {{ old('status_target', $statusDesa->status_target ?? '') === $s ?
                            'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai Target</label>
                    <input type="number" name="nilai_target"
                        value="{{ old('nilai_target', $statusDesa->nilai_target ?? '') }}" step="0.0001" min="0" max="1"
                        placeholder="0.0000"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                </div>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm resize-none">{{ old('keterangan', $statusDesa->keterangan ?? '') }}</textarea>
            </div>

            {{-- Upload Dokumen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dokumen SK / Laporan IDM</label>
                @if(isset($statusDesa->dokumen) && $statusDesa->dokumen)
                <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-xl border border-emerald-100 mb-3">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm text-emerald-700 flex-1">Dokumen sudah ada</span>
                    <a href="{{ Storage::url($statusDesa->dokumen) }}" target="_blank"
                        class="text-xs text-emerald-600 hover:underline font-medium">Lihat →</a>
                </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-emerald-400 transition-colors cursor-pointer"
                    @click="$refs.fileInput.click()">
                    <input type="file" name="dokumen" x-ref="fileInput" accept=".pdf,.doc,.docx" class="hidden"
                        @change="namaFile = $event.target.files[0]?.name">
                    <svg class="w-7 h-7 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-sm text-gray-500" x-text="namaFile || 'Klik untuk pilih file'"></p>
                    <p class="text-xs text-gray-400 mt-0.5">PDF, DOC, DOCX — Maks. 5MB</p>
                </div>
                @error('dokumen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    {{ isset($statusDesa->id) ? 'Perbarui Data' : 'Simpan Data IDM' }}
                </button>
                <a href="{{ route('admin.status-desa.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>


<script>
    function idmForm() {
    return {
        iks: {{ old('skor_ketahanan_sosial', $statusDesa->skor_ketahanan_sosial ?? 0) }},
        ike: {{ old('skor_ketahanan_ekonomi', $statusDesa->skor_ketahanan_ekonomi ?? 0) }},
        ikl: {{ old('skor_ketahanan_ekologi', $statusDesa->skor_ketahanan_ekologi ?? 0) }},
        nilaiOtomatis: 0,
        nilaiManual:   {{ old('nilai', $statusDesa->nilai ?? 0) }},
        namaFile: '',

        statusOtomatis: '',

        ranges: [
            { status: 'Sangat Tertinggal', min: 0,      max: 0.4907 },
            { status: 'Tertinggal',        min: 0.4908, max: 0.5989 },
            { status: 'Berkembang',        min: 0.5990, max: 0.7072 },
            { status: 'Maju',              min: 0.7073, max: 0.8155 },
            { status: 'Mandiri',           min: 0.8156, max: 1.0000 },
        ],

        hitungOtomatis() {
            const i = parseFloat(this.iks) || 0;
            const e = parseFloat(this.ike) || 0;
            const l = parseFloat(this.ikl) || 0;

            if (i === 0 && e === 0 && l === 0) {
                this.nilaiOtomatis = 0;
                return;
            }

            const total = parseFloat(((i + e + l) / 3).toFixed(4));
            this.nilaiOtomatis = total;
            this.nilaiManual   = total;

            // Tentukan status otomatis
            const r = this.ranges.find(r => total >= r.min && total <= r.max);
            this.statusOtomatis = r ? r.status : '-';

            // Update dropdown status
            const sel = document.querySelector('select[name="status"]');
            if (sel && r) sel.value = r.status;

            // Update input nilai
            const inp = document.querySelector('input[name="nilai"]');
            if (inp) inp.value = total.toFixed(4);
        },

        init() {
            this.hitungOtomatis();
        }
    }
}
</script>