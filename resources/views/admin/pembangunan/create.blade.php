@extends('layouts.admin')

@section('title', isset($pembangunan) ? 'Edit Kegiatan' : 'Tambah Kegiatan')

@section('content')

<div class="max-w-4xl mx-auto">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-6">
        <a href="{{ route('admin.pembangunan.index') }}" class="hover:text-emerald-600">Pembangunan</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="font-medium text-gray-900">{{ isset($pembangunan) ? 'Edit' : 'Tambah' }}</span>
    </nav>

    <form method="POST"
        action="{{ isset($pembangunan) ? route('admin.pembangunan.update', $pembangunan) : route('admin.pembangunan.store') }}"
        enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($pembangunan)) @method('PUT') @endif

        {{-- ── SECTION 1: Informasi Umum ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs flex items-center justify-center font-bold">1</span>
                    Informasi Umum
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Tahun Anggaran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tahun Anggaran <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="tahun_anggaran"
                        value="{{ old('tahun_anggaran', $pembangunan->tahun_anggaran ?? date('Y')) }}" min="2000"
                        max="2099"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tahun_anggaran') border-red-300 @enderror">
                    @error('tahun_anggaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Sasaran (RPJMDes / RKPDes) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sasaran</label>
                    <select name="id_sasaran"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">-- Pilih Sasaran --</option>
                        @foreach($sasarans as $s)
                        <option value="{{ $s->id }}" {{ old('id_sasaran', $pembangunan->id_sasaran ?? '') == $s->id ?
                            'selected' : '' }}>
                            {{ $s->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Kegiatan (full width) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $pembangunan->nama ?? '') }}"
                        placeholder="Contoh: Pembangunan Jalan Usaha Tani Dusun Barat"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('nama') border-red-300 @enderror">
                    @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Bidang --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Bidang</label>
                    <select name="id_bidang"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($bidangs as $b)
                        <option value="{{ $b->id }}" {{ old('id_bidang', $pembangunan->id_bidang ?? '') == $b->id ?
                            'selected' : '' }}>
                            {{ $b->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sumber Dana (referensi utama) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber Dana Utama</label>
                    <select name="id_sumber_dana"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">-- Pilih Sumber Dana --</option>
                        @foreach($sumberDana as $sd)
                        <option value="{{ $sd->id }}" {{ old('id_sumber_dana', $pembangunan->id_sumber_dana ?? '') ==
                            $sd->id ? 'selected' : '' }}>
                            {{ $sd->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pelaksana --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pelaksana</label>
                    <input type="text" name="pelaksana" value="{{ old('pelaksana', $pembangunan->pelaksana ?? '') }}"
                        placeholder="TPK, Rekanan, Swakelola, dll"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                {{-- Lokasi (wilayah administratif) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi (Wilayah Administratif)</label>
                    <select name="id_lokasi"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach($wilayahs as $w)
                        <option value="{{ $w->id }}" {{ old('id_lokasi', $pembangunan->id_lokasi ?? '') == $w->id ?
                            'selected' : '' }}>
                            Dusun {{ $w->dusun }} RW {{ $w->rw }} RT {{ $w->rt }}
                        </option>
                        @endforeach
                    </select>
                    @if($wilayahs->isEmpty())
                    <p class="mt-1 text-xs text-amber-600">⚠ Data wilayah administratif belum tersedia. Isi melalui menu
                        Info Desa → Wilayah Administratif.</p>
                    @endif
                </div>

            </div>
        </div>

        {{-- ── SECTION 2: Volume & Waktu ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center font-bold">2</span>
                    Volume & Waktu Pelaksanaan
                </h3>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Volume</label>
                    <input type="number" name="volume" step="0.01" min="0"
                        value="{{ old('volume', $pembangunan->volume ?? '') }}" placeholder="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan</label>
                    <input type="text" name="satuan" value="{{ old('satuan', $pembangunan->satuan ?? '') }}"
                        placeholder="meter, m², unit, ls"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu (hari)</label>
                    <input type="number" name="waktu" min="0" value="{{ old('waktu', $pembangunan->waktu ?? '') }}"
                        placeholder="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div></div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="mulai_pelaksanaan"
                        value="{{ old('mulai_pelaksanaan', isset($pembangunan) ? $pembangunan->mulai_pelaksanaan?->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="akhir_pelaksanaan"
                        value="{{ old('akhir_pelaksanaan', isset($pembangunan) ? $pembangunan->akhir_pelaksanaan?->format('Y-m-d') : '') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- ── SECTION 3: Anggaran (multi-sumber, sesuai OpenSID) ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-yellow-50">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-amber-500 text-white text-xs flex items-center justify-center font-bold">3</span>
                    Alokasi Anggaran
                    <span class="text-xs font-normal text-gray-500 ml-1">— Jumlah Total = Pemerintah + Provinsi +
                        Kab/Kota + Swadaya + Lainnya</span>
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach([
                ['dana_pemerintah', 'Dana Pemerintah (APBN/DD)', 'text-blue-700'],
                ['dana_provinsi', 'Dana Provinsi', 'text-purple-700'],
                ['dana_kabkota', 'Dana Kab/Kota', 'text-indigo-700'],
                ['swadaya', 'Swadaya Masyarakat', 'text-emerald-700'],
                ['sumber_lain', 'Sumber Lain', 'text-gray-700'],
                ] as [$field, $label, $color])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        {{ $label }}
                        <span class="text-xs {{ $color }} ml-1">(Rp)</span>
                    </label>
                    <input type="number" name="{{ $field }}" min="0" step="1000"
                        value="{{ old($field, $pembangunan->$field ?? 0) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent anggaran-input">
                </div>
                @endforeach

                {{-- Total auto-hitung --}}
                <div class="md:col-span-3 bg-amber-50 rounded-xl p-4 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-700">Total Anggaran</span>
                        <span id="totalAnggaran" class="text-xl font-bold text-amber-700">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECTION 4: Koordinat & Foto ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-teal-50 to-cyan-50">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-600 text-white text-xs flex items-center justify-center font-bold">4</span>
                    Koordinat Peta & Foto
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Latitude</label>
                    <input type="number" name="lat" step="0.00000001" value="{{ old('lat', $pembangunan->lat ?? '') }}"
                        placeholder="-7.12345678"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Longitude</label>
                    <input type="number" name="lng" step="0.00000001" value="{{ old('lng', $pembangunan->lng ?? '') }}"
                        placeholder="109.12345678"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Utama</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500">
                    @isset($pembangunan)
                    @if($pembangunan->foto)
                    <div class="mt-2">
                        <img src="{{ $pembangunan->foto_url }}" class="h-24 rounded-lg object-cover border" alt="foto">
                    </div>
                    @endif
                    @endisset
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Uraian / Dokumentasi</label>
                    <textarea name="dokumentasi" rows="3" placeholder="Deskripsi umum kegiatan..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('dokumentasi', $pembangunan->dokumentasi ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="1" {{ old('status', $pembangunan->status ?? 1) == 1 ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="0" {{ old('status', $pembangunan->status ?? 1) == 0 ? 'selected' : '' }}>Arsip
                        </option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pembangunan.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl shadow hover:shadow-md transition-all">
                {{ isset($pembangunan) ? 'Simpan Perubahan' : 'Tambah Kegiatan' }}
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Auto-hitung total anggaran
function hitungTotal() {
    const inputs = document.querySelectorAll('.anggaran-input');
    let total = 0;
    inputs.forEach(i => { total += parseFloat(i.value) || 0; });
    document.getElementById('totalAnggaran').textContent =
        'Rp ' + total.toLocaleString('id-ID');
}

document.querySelectorAll('.anggaran-input').forEach(i => {
    i.addEventListener('input', hitungTotal);
});

// Hitung saat halaman dimuat (edit mode)
hitungTotal();
</script>
@endsection