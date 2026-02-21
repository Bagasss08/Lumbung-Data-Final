@extends('layouts.admin')
@section('title', isset($kia) ? 'Edit KIA' : 'Tambah KIA')

@section('content')

{{-- Sub-tab --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">Posyandu</a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium bg-emerald-100 text-emerald-700">Kesehatan Ibu &amp; Anak
        (KIA)</a>
</div>

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.pendataan.kia') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <h3 class="text-base font-semibold text-gray-900">
        {{ isset($kia) ? 'Edit KIA: ' . $kia->nama_ibu : 'Tambah Data KIA' }}
    </h3>
</div>

@if($errors->any())
<div class="p-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    <p class="font-semibold mb-1">Perbaiki kesalahan berikut:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST"
    action="{{ isset($kia) ? route('admin.kesehatan.pendataan.kia.update', $kia) : route('admin.kesehatan.pendataan.kia.store') }}">
    @csrf
    @if(isset($kia)) @method('PUT') @endif

    <div class="space-y-6">

        {{-- Registrasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Registrasi</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Register KIA</label>
                    <input type="text" name="no_register"
                        value="{{ old('no_register', $kia->no_register ?? $noRegister ?? '') }}"
                        placeholder="Auto-generate jika kosong"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong untuk generate otomatis</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Posyandu</label>
                    <select name="posyandu_id"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih Posyandu --</option>
                        @foreach($posyanduList as $p)
                        <option value="{{ $p->id }}" {{ old('posyandu_id', $kia->posyandu_id ?? '') == $p->id ?
                            'selected' : '' }}>
                            {{ $p->nama_posyandu }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Pemeriksaan</label>
                    <select name="tempat_pemeriksaan"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        @php $tempatList = ['Posyandu','Puskesmas','Klinik','Rumah Sakit','Bidan Praktek','Dokter
                        Praktek']; @endphp
                        @foreach($tempatList as $t)
                        <option value="{{ $t }}" {{ old('tempat_pemeriksaan', $kia->tempat_pemeriksaan ?? '') === $t ?
                            'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Data Ibu --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Data Ibu</h4>
            <p class="text-xs text-gray-400 mb-5">Pilih dari data penduduk untuk auto-isi, atau isi manual</p>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cari dari Data Penduduk</label>
                <select id="pilih_penduduk_ibu" name="penduduk_id_ibu"
                    class="w-full px-4 py-2.5 text-sm border border-emerald-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                    <option value="">-- Pilih Ibu dari Data Penduduk (Opsional) --</option>
                    @foreach($pendudukIbu as $p)
                    <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}"
                        data-tgl="{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('Y-m-d') : '' }}" {{
                        old('penduduk_id_ibu', $kia->penduduk_id_ibu ?? '') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }} — {{ $p->nik ?? 'Tanpa NIK' }}
                    </option>
                    @endforeach
                </select>
                <p class="text-xs text-emerald-600 mt-1">Memilih dari sini akan otomatis mengisi kolom di bawah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Ibu <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" id="nama_ibu" required
                        value="{{ old('nama_ibu', $kia->nama_ibu ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border @error('nama_ibu') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('nama_ibu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK Ibu</label>
                    <input type="text" name="nik_ibu" id="nik_ibu" maxlength="20"
                        value="{{ old('nik_ibu', $kia->nik_ibu ?? '') }}" placeholder="16 digit NIK"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir Ibu</label>
                    <input type="date" name="tgl_lahir_ibu" id="tgl_lahir_ibu"
                        value="{{ old('tgl_lahir_ibu', isset($kia->tgl_lahir_ibu) ? $kia->tgl_lahir_ibu->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $kia->no_hp ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kehamilan Ke-</label>
                    <input type="number" name="kehamilan_ke" min="1"
                        value="{{ old('kehamilan_ke', $kia->kehamilan_ke ?? 1) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <input type="text" name="alamat_ibu" value="{{ old('alamat_ibu', $kia->alamat_ibu ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Dusun</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $kia->dusun ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>
        </div>

        {{-- Data Kehamilan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Data Kehamilan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">HPHT</label>
                    <input type="date" name="hpht" id="hpht"
                        value="{{ old('hpht', isset($kia->hpht) ? $kia->hpht->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    <p class="text-xs text-gray-400 mt-1">Hari Pertama Haid Terakhir</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Taksiran Persalinan (HPL)</label>
                    <input type="date" name="taksiran_lahir" id="hpl"
                        value="{{ old('taksiran_lahir', isset($kia->taksiran_lahir) ? $kia->taksiran_lahir->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Kehamilan <span
                            class="text-red-500">*</span></label>
                    <select name="status_kehamilan" id="status_kehamilan" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="hamil" {{ old('status_kehamilan', $kia->status_kehamilan ?? 'hamil') === 'hamil'
                            ? 'selected' : '' }}>Sedang Hamil</option>
                        <option value="melahirkan" {{ old('status_kehamilan', $kia->status_kehamilan ?? '') ===
                            'melahirkan' ? 'selected' : '' }}>Sudah Melahirkan</option>
                        <option value="selesai" {{ old('status_kehamilan', $kia->status_kehamilan ?? '') === 'selesai' ?
                            'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Risiko <span
                            class="text-red-500">*</span></label>
                    <select name="status_resiko" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="normal" {{ old('status_resiko', $kia->status_resiko ?? 'normal') === 'normal' ?
                            'selected' : '' }}>Normal</option>
                        <option value="resiko_rendah" {{ old('status_resiko', $kia->status_resiko ?? '') ===
                            'resiko_rendah' ? 'selected' : '' }}>Risiko Rendah</option>
                        <option value="resiko_tinggi" {{ old('status_resiko', $kia->status_resiko ?? '') ===
                            'resiko_tinggi' ? 'selected' : '' }}>Risiko Tinggi</option>
                    </select>
                </div>
            </div>

            {{-- Bagian melahirkan --}}
            <div id="bagian-melahirkan"
                class="{{ old('status_kehamilan', $kia->status_kehamilan ?? 'hamil') === 'hamil' ? 'hidden' : '' }} mt-5 pt-5 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Melahirkan</label>
                        <input type="date" name="tanggal_melahirkan"
                            value="{{ old('tanggal_melahirkan', isset($kia->tanggal_melahirkan) ? $kia->tanggal_melahirkan->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Persalinan</label>
                        <select name="jenis_persalinan"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                            <option value="">-- Pilih --</option>
                            @php $persalinanList = ['normal' => 'Normal', 'sesar' => 'Sesar', 'vakum' => 'Vakum'];
                            @endphp
                            @foreach($persalinanList as $val => $lbl)
                            <option value="{{ $val }}" {{ old('jenis_persalinan', $kia->jenis_persalinan ?? '') === $val
                                ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penolong Persalinan</label>
                        <select name="penolong_persalinan"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                            <option value="">-- Pilih --</option>
                            @php $penolongList = ['Dokter','Bidan','Dukun Terlatih','Dukun Tidak Terlatih','Lainnya'];
                            @endphp
                            @foreach($penolongList as $p)
                            <option value="{{ $p }}" {{ old('penolong_persalinan', $kia->penolong_persalinan ?? '') ===
                                $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Anak --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Data Anak</h4>
            <p class="text-xs text-gray-400 mb-5">Isi setelah anak lahir. Pilih dari data penduduk atau isi manual.</p>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cari dari Data Penduduk</label>
                <select id="pilih_penduduk_anak" name="penduduk_id_anak"
                    class="w-full px-4 py-2.5 text-sm border border-emerald-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                    <option value="">-- Pilih Anak dari Data Penduduk (Opsional) --</option>
                    @foreach($pendudukAnak as $p)
                    <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}"
                        data-tgl="{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('Y-m-d') : '' }}"
                        data-jk="{{ $p->jenis_kelamin }}" {{ old('penduduk_id_anak', $kia->penduduk_id_anak ?? '') ==
                        $p->id ? 'selected' : '' }}>
                        {{ $p->nama }} — {{ $p->nik ?? 'Tanpa NIK' }}
                    </option>
                    @endforeach
                </select>
                <p class="text-xs text-emerald-600 mt-1">Memilih dari sini akan otomatis mengisi kolom di bawah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Anak</label>
                    <input type="text" name="nama_anak" id="nama_anak"
                        value="{{ old('nama_anak', $kia->nama_anak ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK Anak</label>
                    <input type="text" name="nik_anak" id="nik_anak" value="{{ old('nik_anak', $kia->nik_anak ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin_anak" id="jenis_kelamin_anak"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin_anak', $kia->jenis_kelamin_anak ?? '') === 'L' ?
                            'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin_anak', $kia->jenis_kelamin_anak ?? '') === 'P' ?
                            'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir Anak</label>
                    <input type="date" name="tgl_lahir_anak" id="tgl_lahir_anak"
                        value="{{ old('tgl_lahir_anak', isset($kia->tgl_lahir_anak) ? $kia->tgl_lahir_anak->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Berat Lahir (kg)</label>
                    <input type="number" name="berat_lahir" step="0.01" min="0" max="20"
                        value="{{ old('berat_lahir', $kia->berat_lahir ?? '') }}" placeholder="2.50"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Panjang Lahir (cm)</label>
                    <input type="number" name="panjang_lahir" step="0.1" min="0" max="100"
                        value="{{ old('panjang_lahir', $kia->panjang_lahir ?? '') }}" placeholder="48.0"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('keterangan', $kia->keterangan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($kia) ? 'Simpan Perubahan' : 'Tambah KIA' }}
            </button>
            <a href="{{ route('admin.kesehatan.pendataan.kia') }}"
                class="px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
        </div>

    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    // Auto-isi data IBU dari dropdown penduduk
    const pilihanIbu = document.getElementById('pilih_penduduk_ibu');
    if (pilihanIbu) {
        pilihanIbu.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            if (!opt.value) return;
            document.getElementById('nama_ibu').value        = opt.dataset.nama || '';
            document.getElementById('nik_ibu').value         = opt.dataset.nik  || '';
            document.getElementById('tgl_lahir_ibu').value   = opt.dataset.tgl  || '';
        });
    }

    // Auto-isi data ANAK dari dropdown penduduk
    const pilihanAnak = document.getElementById('pilih_penduduk_anak');
    if (pilihanAnak) {
        pilihanAnak.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            if (!opt.value) return;
            document.getElementById('nama_anak').value       = opt.dataset.nama || '';
            document.getElementById('nik_anak').value        = opt.dataset.nik  || '';
            document.getElementById('tgl_lahir_anak').value  = opt.dataset.tgl  || '';
            const jk = document.getElementById('jenis_kelamin_anak');
            if (opt.dataset.jk) jk.value = opt.dataset.jk;
        });
    }

    // Auto hitung HPL dari HPHT (+280 hari)
    const hphtInput = document.getElementById('hpht');
    if (hphtInput) {
        hphtInput.addEventListener('change', function () {
            const d = new Date(this.value);
            if (!isNaN(d)) {
                const hpl = new Date(d.getTime() + 280 * 86400000);
                document.getElementById('hpl').value = hpl.toISOString().split('T')[0];
            }
        });
    }

    // Toggle bagian melahirkan
    const statusKehamilan = document.getElementById('status_kehamilan');
    if (statusKehamilan) {
        statusKehamilan.addEventListener('change', function () {
            const bagian = document.getElementById('bagian-melahirkan');
            if (bagian) bagian.classList.toggle('hidden', this.value === 'hamil');
        });
    }

});
</script>
@endsection