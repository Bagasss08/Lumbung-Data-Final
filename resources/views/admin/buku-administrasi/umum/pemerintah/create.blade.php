@extends('layouts.admin')

@section('title', 'Tambah Perangkat Desa')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Perangkat Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Cari data dari database penduduk atau input manual</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Formulir Data Perangkat Desa</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Gunakan fitur cari untuk mempercepat pengisian data</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.pemerintah.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Hidden ID Penduduk --}}
        <input type="hidden" name="penduduk_id" id="penduduk_id" value="{{ old('penduduk_id') }}">

        <div class="p-6 space-y-8">

            {{-- TOP ROW: Foto + Cari Penduduk --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                {{-- FOTO PROFIL --}}
                <div class="flex flex-col items-center gap-3">
                    <div id="foto_preview_wrapper" class="relative w-32 h-32 rounded-2xl bg-gray-100 dark:bg-slate-700 border-2 border-dashed border-gray-300 dark:border-slate-600 overflow-hidden flex items-center justify-center group cursor-pointer transition-all hover:border-emerald-400"
                        onclick="document.getElementById('foto_input').click()">
                        <img id="foto_preview_img" src="#" alt="Preview" class="w-full h-full object-cover hidden rounded-2xl" />
                        <div id="foto_placeholder" class="flex flex-col items-center gap-1 text-gray-400 dark:text-slate-500 pointer-events-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[10px] font-medium">Foto Profil</span>
                        </div>
                        <div class="absolute inset-0 bg-emerald-600/70 opacity-0 group-hover:opacity-100 transition-all rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="file" name="foto" id="foto_input" accept="image/*" class="hidden">
                    <div class="text-center">
                        <p class="text-xs font-medium text-gray-600 dark:text-slate-400">Klik untuk unggah foto</p>
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-0.5">PNG, JPG • Maks. 2MB</p>
                    </div>
                </div>

                {{-- FITUR CARI PENDUDUK & KETERANGAN --}}
                <div class="md:col-span-2 flex flex-col gap-4">
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl">
                        <label class="block text-sm font-bold text-emerald-700 dark:text-emerald-400 mb-2">Cari Dari Database Penduduk (Opsional)</label>
                        <div class="relative">
                            <input type="text" id="search_penduduk" placeholder="Ketik NIK atau Nama Warga..."
                                class="w-full px-4 py-3 rounded-xl border-2 border-emerald-200 dark:border-emerald-800 bg-white dark:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            <div id="results" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-xl max-h-60 overflow-y-auto hidden"></div>
                        </div>
                        <p class="text-[10px] text-emerald-600 mt-2">Jika data ditemukan, formulir identitas di bawah akan terisi otomatis.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Keterangan Umum</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)..." class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-slate-700">

            {{-- SEKSI 1: DATA IDENTITAS --}}
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span> Informasi Identitas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="md:col-span-2 lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="field_nama" value="{{ old('nama') }}" required placeholder="Nama lengkap..."
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">NIK</label>
                        <input type="text" name="nik" id="field_nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="field_jk" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="field_tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="field_tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Agama</label>
                        <select name="agama" id="field_agama" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="">-- Pilih --</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $agm)
                                <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" placeholder="Contoh: S1 Hukum"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Pangkat / Golongan</label>
                        <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}" placeholder="Contoh: Penata Muda / III.a"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-slate-700">

            {{-- SEKSI 2: DATA JABATAN & SK --}}
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-blue-500 rounded-full"></span> Jabatan & Masa Bakti
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <select name="jabatan_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="" disabled selected>-- Pilih Jabatan --</option>
                            @isset($jabatans)
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->nama }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">NIAP (Perangkat Desa)</label>
                        <input type="text" name="niap" value="{{ old('niap') }}" placeholder="Nomor Induk Aparatur"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">NIP (PNS Jika Ada)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">No SK Pengangkatan</label>
                        <input type="text" name="no_sk" value="{{ old('no_sk') }}" placeholder="Contoh: 141/05/SK/2024"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal SK</label>
                        <input type="date" name="tanggal_sk" value="{{ old('tanggal_sk') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Periode Mulai</label>
                        <input type="date" name="periode_mulai" value="{{ old('periode_mulai') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Periode Selesai</label>
                        <input type="date" name="periode_selesai" value="{{ old('periode_selesai') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-slate-700">

            {{-- SEKSI 3: STATUS & PEMBERHENTIAN --}}
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-amber-500 rounded-full"></span> Status & Pemberhentian
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ old('urutan', '0') }}" min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">No SK Pemberhentian</label>
                        <input type="text" name="nomor_keputusan_pemberhentian" value="{{ old('nomor_keputusan_pemberhentian') }}" placeholder="Opsional"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Pemberhentian</label>
                        <input type="date" name="tanggal_keputusan_pemberhentian" value="{{ old('tanggal_keputusan_pemberhentian') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perangkat
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // ── Foto Preview ──────────────────────────────────────────────
    const fotoInput       = document.getElementById('foto_input');
    const fotoPreviewImg  = document.getElementById('foto_preview_img');
    const fotoPlaceholder = document.getElementById('foto_placeholder');

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            fotoPreviewImg.src = e.target.result;
            fotoPreviewImg.classList.remove('hidden');
            fotoPlaceholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    // ── Live Search Penduduk ──────────────────────────────────────
    const searchInput = document.getElementById('search_penduduk');
    const resultsBox  = document.getElementById('results');

    searchInput.addEventListener('input', function() {
        let query = this.value;
        if (query.length < 2) {
            resultsBox.classList.add('hidden');
            return;
        }

        fetch(`{{ route('admin.layanan-surat.cetak.liveSearchNik') }}?keyword=${query}`)
            .then(response => response.json())
            .then(data => {
                resultsBox.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        let div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-emerald-50 dark:hover:bg-slate-700 cursor-pointer border-b dark:border-slate-700 last:border-0';
                        div.innerHTML = `
                            <div class="font-bold text-sm dark:text-white">${item.nama}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${item.nik}</div>
                        `;
                        div.addEventListener('click', () => fillForm(item.nik));
                        resultsBox.appendChild(div);
                    });
                    resultsBox.classList.remove('hidden');
                } else {
                    resultsBox.classList.add('hidden');
                }
            });
    });

    function fillForm(nik) {
        fetch(`/admin/layanan-surat/cetak/get-data-by-nik/${nik}`)
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    const p = res.penduduk;
                    document.getElementById('penduduk_id').value = p.id;
                    document.getElementById('field_nama').value = p.nama;
                    document.getElementById('field_nik').value = p.nik;
                    document.getElementById('field_jk').value = p.jenis_kelamin;
                    document.getElementById('field_tempat_lahir').value = p.tempat_lahir;
                    document.getElementById('field_tanggal_lahir').value = p.tanggal_lahir_format || p.tanggal_lahir;
                    document.getElementById('field_agama').value = p.agama_teks || p.agama;
                    
                    // Beri efek highlight agar user tahu field berubah
                    const fields = ['field_nama', 'field_nik', 'field_jk', 'field_tempat_lahir', 'field_tanggal_lahir', 'field_agama'];
                    fields.forEach(f => {
                        document.getElementById(f).classList.add('bg-emerald-50', 'border-emerald-500');
                    });

                    resultsBox.classList.add('hidden');
                    searchInput.value = p.nama;
                }
            });
    }

    // Tutup box hasil jika klik di luar
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.classList.add('hidden');
        }
    });
</script>
@endsection