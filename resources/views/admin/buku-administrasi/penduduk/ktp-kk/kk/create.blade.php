@extends('layouts.admin')
@section('title', 'Tambah Kartu Keluarga')

@section('content')
    <div class="flex items-center gap-2 mb-1">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <p class="text-lg font-semibold text-gray-700">Tambah Kartu Keluarga</p>
    </div>
    <p class="text-sm text-gray-400 mb-6 ml-7">Tambahkan anggota dari data penduduk yang sudah terdaftar</p>

    @if($errors->has('anggota'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first('anggota') }}</div>
    @endif

    <form action="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4 space-y-5">
            <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider border-b pb-3">Data Kartu Keluarga</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No KK <span class="text-red-500">*</span></label>
                    <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('no_kk') border-red-400 @enderror"/>
                    @error('no_kk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terdaftar <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_terdaftar" value="{{ old('tgl_terdaftar') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('alamat') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi Ekonomi</label>
                    <select name="klasifikasi_ekonomi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih</option>
                        @foreach(['sangat_miskin','miskin','hampir_miskin','tidak_miskin'] as $k)
                        <option value="{{ $k }}" @selected(old('klasifikasi_ekonomi') === $k)>{{ ucwords(str_replace('_', ' ', $k)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan Aktif</label>
                    <input type="text" name="jenis_bantuan_aktif" value="{{ old('jenis_bantuan_aktif') }}"
                           placeholder="Cth: PKH, BPNT"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                </div>
            </div>
        </div>

        <!-- Anggota Keluarga -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider">Anggota Keluarga</h3>
                <button type="button" id="btn-tambah-anggota"
                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Anggota
                </button>
            </div>
            <p class="text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 mb-4">
                ⚠️ Harus ada tepat <strong>satu</strong> anggota dengan hubungan <strong>Kepala Keluarga</strong>.
            </p>
            <div id="anggota-container" class="space-y-3"></div>
            <p id="no-anggota" class="text-sm text-gray-400 text-center py-4">Belum ada anggota. Klik "Tambah Anggota".</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.index') }}"
               class="px-5 py-2 text-sm border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">Simpan</button>
        </div>
    </form>

    {{-- Data penduduk untuk JS --}}
    <script>
    const pendudukOptions = [
        <option value="">Pilih Penduduk</option>
        @foreach($pendudukList as $p)
        { id: {{ $p->id }}, text: "{{ $p->nik }} — {{ $p->nama }}" },
        @endforeach
    ];

    const hubunganOptions = ['kepala_keluarga','istri','anak','menantu','cucu','orang_tua','mertua','saudara','lainnya'];

    let anggotaCount = 0;

    function buatFormAnggota(index) {
        const pOptions = pendudukOptions.map(p => `<option value="${p.id}">${p.text}</option>`).join('');
        const hOptions = hubunganOptions.map(h => `<option value="${h}">${h.replace(/_/g,' ').replace(/\b\w/g, c => c.toUpperCase())}</option>`).join('');
        return `
        <div class="border border-gray-200 rounded-lg p-4 relative anggota-item grid grid-cols-1 md:grid-cols-3 gap-4" id="anggota-${index}">
            <button type="button" onclick="hapusAnggota(${index})"
                    class="absolute top-3 right-3 text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="md:col-span-2">
                <label class="block text-xs text-gray-600 mb-1">Penduduk *</label>
                <select name="anggota[${index}][penduduk_id]" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    ${pOptions}
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Hubungan Keluarga *</label>
                <select name="anggota[${index}][hubungan_keluarga]" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    ${hOptions}
                </select>
            </div>
        </div>`;
    }

    document.getElementById('btn-tambah-anggota').addEventListener('click', function () {
        document.getElementById('anggota-container').insertAdjacentHTML('beforeend', buatFormAnggota(anggotaCount));
        anggotaCount++;
        document.getElementById('no-anggota').style.display = 'none';
    });

    function hapusAnggota(index) {
        document.getElementById('anggota-' + index).remove();
        if (!document.querySelectorAll('.anggota-item').length) {
            document.getElementById('no-anggota').style.display = 'block';
        }
    }
    </script>
@endsection