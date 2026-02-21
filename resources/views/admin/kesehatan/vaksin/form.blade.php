@extends('layouts.admin')
@section('title', isset($vaksin) ? 'Edit Data Vaksin' : 'Tambah Data Vaksin')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.vaksin.index') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h3 class="text-base font-semibold text-gray-900">
            {{ isset($vaksin) ? 'Edit Data Vaksin' : 'Tambah Data Vaksin' }}
        </h3>
        <p class="text-sm text-gray-500">Data penerima vaksin</p>
    </div>
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
    action="{{ isset($vaksin) ? route('admin.kesehatan.vaksin.update', $vaksin) : route('admin.kesehatan.vaksin.store') }}">
    @csrf
    @if(isset($vaksin)) @method('PUT') @endif

    <div class="space-y-6">

        {{-- Data Penerima --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Data Penerima</h4>
            <p class="text-xs text-gray-400 mb-5">Pilih dari data penduduk untuk auto-isi, atau isi manual</p>

            {{-- Dropdown pilih penduduk --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cari dari Data Penduduk</label>
                <select id="pilih_penduduk" name="penduduk_id"
                    class="w-full px-4 py-2.5 text-sm border border-emerald-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                    <option value="">-- Pilih Penerima dari Data Penduduk (Opsional) --</option>
                    @foreach($pendudukList as $p)
                    <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}"
                        data-tgl="{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') : '' }}"
                        data-umur="{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->age : '' }}"
                        data-jk="{{ $p->jenis_kelamin }}" {{ old('penduduk_id', $vaksin->penduduk_id ?? '') == $p->id ?
                        'selected' : '' }}>
                        {{ $p->nama }} — {{ $p->nik ?? 'Tanpa NIK' }}
                    </option>
                    @endforeach
                </select>
                <p class="text-xs text-emerald-600 mt-1">Memilih dari sini akan otomatis mengisi kolom di bawah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penerima <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_penerima" id="nama_penerima" required
                        value="{{ old('nama_penerima', $vaksin->nama_penerima ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border @error('nama_penerima') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('nama_penerima')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK</label>
                    <input type="text" name="nik" id="nik" maxlength="20" value="{{ old('nik', $vaksin->nik ?? '') }}"
                        placeholder="16 digit NIK"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $vaksin->jenis_kelamin ?? '') === 'L' ? 'selected' :
                            '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $vaksin->jenis_kelamin ?? '') === 'P' ? 'selected' :
                            '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir"
                        value="{{ old('tgl_lahir', isset($vaksin->tgl_lahir) ? $vaksin->tgl_lahir->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Umur (tahun)</label>
                    <input type="number" name="umur" id="umur" min="0" max="150"
                        value="{{ old('umur', $vaksin->umur ?? '') }}" placeholder="Auto dari tgl lahir"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Dusun</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $vaksin->dusun ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $vaksin->alamat ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>
        </div>

        {{-- Data Vaksinasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Data Vaksinasi</h4>

            @php
            $kategoriVaksin = [
            'covid19' => 'COVID-19',
            'imunisasi_anak' => 'Imunisasi Anak',
            'lainnya' => 'Lainnya',
            ];
            $dosisList = [
            1 => 'Dosis 1',
            2 => 'Dosis 2',
            3 => 'Dosis 3 / Booster',
            4 => 'Booster',
            5 => 'Lengkap',
            6 => 'Ulangan',
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Vaksin <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="jenis_vaksin" required list="vaksin-list"
                        value="{{ old('jenis_vaksin', $vaksin->jenis_vaksin ?? '') }}" placeholder="Pilih atau ketik..."
                        class="w-full px-4 py-2.5 text-sm border @error('jenis_vaksin') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    <datalist id="vaksin-list">
                        @foreach($jenisVaksinOptions as $opt)
                        <option value="{{ $opt }}">
                            @endforeach
                    </datalist>
                    @error('jenis_vaksin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Vaksin</label>
                    <select name="kategori_vaksin"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriVaksin as $val => $lbl)
                        <option value="{{ $val }}" {{ old('kategori_vaksin', $vaksin->kategori_vaksin ?? '') === $val ?
                            'selected' : '' }}>
                            {{ $lbl }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Dosis <span
                            class="text-red-500">*</span></label>
                    <select name="dosis" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih Dosis --</option>
                        @foreach($dosisList as $val => $lbl)
                        <option value="{{ $val }}" {{ old('dosis', $vaksin->dosis ?? '') === $val ? 'selected' : '' }}>
                            {{ $lbl }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Vaksin <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_vaksin" required
                        value="{{ old('tanggal_vaksin', isset($vaksin->tanggal_vaksin) ? $vaksin->tanggal_vaksin->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span
                            class="text-red-500">*</span></label>
                    <select name="status" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="sudah" {{ old('status', $vaksin->status ?? 'sudah') === 'sudah' ? 'selected' : ''
                            }}>Sudah Vaksin</option>
                        <option value="belum" {{ old('status', $vaksin->status ?? '') === 'belum' ? 'selected' : ''
                            }}>Belum Vaksin</option>
                        <option value="tunda" {{ old('status', $vaksin->status ?? '') === 'tunda' ? 'selected' : ''
                            }}>Ditunda</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Pelayanan</label>
                    <input type="text" name="tempat_pelayanan"
                        value="{{ old('tempat_pelayanan', $vaksin->tempat_pelayanan ?? '') }}"
                        placeholder="Puskesmas / Posyandu / dll"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Petugas</label>
                    <input type="text" name="petugas" value="{{ old('petugas', $vaksin->petugas ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Batch Vaksin</label>
                    <input type="text" name="batch_vaksin"
                        value="{{ old('batch_vaksin', $vaksin->batch_vaksin ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Sertifikat</label>
                    <input type="text" name="no_sertifikat"
                        value="{{ old('no_sertifikat', $vaksin->no_sertifikat ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('keterangan', $vaksin->keterangan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($vaksin) ? 'Simpan Perubahan' : 'Tambah Data' }}
            </button>
            <a href="{{ route('admin.kesehatan.vaksin.index') }}"
                class="px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // Auto-isi dari dropdown penduduk
document.getElementById('pilih_penduduk').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (!opt.value) return;
    document.getElementById('nama_penerima').value = opt.dataset.nama  || '';
    document.getElementById('nik').value           = opt.dataset.nik   || '';
    document.getElementById('tgl_lahir').value     = opt.dataset.tgl   || '';
    document.getElementById('umur').value          = opt.dataset.umur  || '';
    const jk = document.getElementById('jenis_kelamin');
    if (opt.dataset.jk) jk.value = opt.dataset.jk;
});

// Auto hitung umur dari tanggal lahir
document.getElementById('tgl_lahir').addEventListener('change', function () {
    const d = new Date(this.value);
    if (!isNaN(d)) {
        document.getElementById('umur').value = Math.floor((new Date() - d) / (365.25 * 24 * 3600 * 1000));
    }
});
</script>
@endsection