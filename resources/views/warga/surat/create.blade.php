@extends('layouts.app')

@section('title', 'Buat Permohonan Surat')

@section('content')
<div class="bg-slate-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        <div class="mb-6">
            <a href="{{ route('warga.surat.index') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Riwayat
            </a>
        </div>

        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold">Formulir Permohonan Surat</h1>
                <p class="mt-2 text-emerald-100 text-base max-w-2xl">Pilih jenis surat, unggah dokumen persyaratan yang wajib, dan lengkapi keterangan agar permohonan Anda cepat diproses oleh admin.</p>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 transform skew-x-12"></div>
        </div>

        <div class="space-y-6">

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$penduduk)
            <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-2xl text-yellow-800 text-sm">
                Akun Anda belum terhubung dengan data kependudukan. Silakan hubungi administrator.
            </div>
        @else

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h1 class="text-xl font-bold text-slate-800">Formulir Pengajuan Surat</h1>
                <p class="text-slate-500 text-sm mt-1">Silakan pilih pemohon, jenis surat, dan lengkapi keterangan pengajuan.</p>
            </div>

            <form action="{{ route('warga.surat.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                {{-- ============================================================
                     BAGIAN 1 — PILIH PEMOHON
                     Gunakan <input type="radio"> di luar <label> agar event
                     tidak terpicu dua kali oleh browser + JS secara bersamaan.
                     ============================================================ --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Surat Untuk Siapa?</label>

                    {{-- Kumpulkan semua anggota: diri sendiri di index 0, anggota KK berikutnya --}}
                    @php
                        $semuaAnggota = collect([$penduduk])->merge($anggotaKk);
                        $defaultId    = old('penduduk_id', $penduduk->id);
                    @endphp

                    <div class="space-y-3" id="container_pemohon">
                        @foreach($semuaAnggota as $index => $anggota)
                            @php $isSelected = (string)$defaultId === (string)$anggota->id; @endphp

                            <div class="pemohon-wrapper">
                                {{-- Radio di LUAR label agar tidak double-fire --}}
                                <input
                                    type="radio"
                                    name="penduduk_id"
                                    id="pemohon_{{ $anggota->id }}"
                                    value="{{ $anggota->id }}"
                                    class="sr-only pemohon-radio"
                                    {{ $isSelected ? 'checked' : '' }}
                                    data-nama="{{ $anggota->nama }}"
                                    data-nik="{{ $anggota->nik ?? '-' }}"
                                >
                                <label
                                    for="pemohon_{{ $anggota->id }}"
                                    class="pemohon-card flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition select-none
                                           {{ $isSelected ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-emerald-300 bg-white' }}"
                                >
                                    {{-- Ikon avatar --}}
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                                {{ $index === 0 ? 'bg-emerald-100' : 'bg-slate-100' }}">
                                        @if($index === 0)
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Info nama & NIK --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ $anggota->nama }}</p>
                                        <p class="text-xs text-slate-500">
                                            NIK: {{ $anggota->nik ?? '-' }}
                                            @if($index === 0)
                                                &bull; <span class="text-emerald-600 font-semibold">Diri Sendiri</span>
                                            @elseif($anggota->kk_level)
                                                &bull; <span class="font-medium">{{ \App\Models\Penduduk::SHDK_LABEL[$anggota->kk_level] ?? 'Anggota KK' }}</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Indikator centang --}}
                                    <div class="check-circle flex-shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition
                                                {{ $isSelected ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300 bg-white' }}">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ============================================================
                     BAGIAN 2 — INFO PEMOHON TERPILIH (diupdate via JS)
                     ============================================================ --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-4">
                    <div class="mt-0.5 flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-sm text-blue-700">
                        <p class="font-bold text-blue-800 mb-1">Data Pemohon</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-0.5">
                            <p><span class="font-medium">Nama&nbsp;:</span> <span id="info_nama">{{ $penduduk->nama }}</span></p>
                            <p><span class="font-medium">NIK&nbsp;&nbsp;&nbsp;:</span> <span id="info_nik">{{ $penduduk->nik ?? '-' }}</span></p>
                        </div>
                    </div>
                </div>

                {{-- ============================================================
                     BAGIAN 3 — PILIH JENIS SURAT
                     ============================================================ --}}
                <div class="space-y-4">
                    <div>
                        <label for="surat_template_id" class="block text-sm font-bold text-slate-700 mb-2">Pilih Jenis Surat</label>
                        <select name="surat_template_id" id="surat_template_id"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                required>
                            <option value="">-- Pilih Surat --</option>
                            @foreach($suratTemplates as $template)
                                <option value="{{ $template->id }}"
                                    {{ old('surat_template_id') == $template->id ? 'selected' : '' }}
                                    data-persyaratan='@json($template->persyaratan->map(fn($item) => ['id' => $item->id, 'nama' => $item->nama]))'>
                                    {{ $template->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Box persyaratan — muncul otomatis saat template dipilih --}}
                    <div id="wrapper_persyaratan" class="hidden">
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-xs font-bold text-amber-800 uppercase tracking-wider">Persyaratan Dokumen</h4>
                                    <p class="text-xs text-amber-700">Unggah setiap dokumen yang dibutuhkan sesuai persyaratan surat yang dipilih.</p>
                                </div>
                            </div>

                            <ul id="list_persyaratan" class="text-sm text-amber-700 leading-relaxed list-disc list-inside space-y-1"></ul>

                            <div id="upload_fields" class="mt-4 grid grid-cols-1 gap-4"></div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700">
                        <p class="font-semibold">Catatan Penting</p>
                        <p class="mt-1">Semua dokumen persyaratan di atas wajib diunggah. Jika surat belum memiliki persyaratan khusus, unggah minimal satu dokumen pendukung utama.</p>
                    </div>

                    <div>
                        <label for="keperluan" class="block text-sm font-bold text-slate-700 mb-2">Keperluan / Keterangan</label>
                        <textarea name="keperluan" id="keperluan" rows="4"
                                  class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none"
                                  placeholder="Contoh: Digunakan untuk melamar pekerjaan di PT..."
                                  required>{{ old('keperluan') }}</textarea>
                    </div>
                </div>


                {{-- ============================================================
                     TOMBOL AKSI
                     ============================================================ --}}
                <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('warga.surat.index') }}"
                       class="px-6 py-2.5 rounded-xl text-slate-600 font-medium hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition transform hover:-translate-y-0.5">
                        Kirim Permohonan
                    </button>
                </div>

            </form>
        </div>

        @endif {{-- end if $penduduk --}}
    </div>
</div>

<script>
(function () {

    // ===========================================================
    // FIX UTAMA: Dengarkan event "change" pada <input type="radio">
    // bukan event "click" pada <label>.
    // Klik label → browser ceklis radio → radio terpicu "change" → JS jalan.
    // Tidak ada double-fire karena JS tidak menyentuh radio secara manual.
    // ===========================================================

    function updateCardStyle(radio) {
        // Reset semua kartu dulu
        document.querySelectorAll('.pemohon-radio').forEach(function (r) {
            var label  = document.querySelector('label[for="' + r.id + '"]');
            var circle = label.querySelector('.check-circle');
            label.classList.remove('border-emerald-500', 'bg-emerald-50');
            label.classList.add('border-slate-200', 'bg-white');
            circle.classList.remove('border-emerald-500', 'bg-emerald-500');
            circle.classList.add('border-slate-300', 'bg-white');
        });

        // Aktifkan kartu yang terpilih
        var activeLabel  = document.querySelector('label[for="' + radio.id + '"]');
        var activeCircle = activeLabel.querySelector('.check-circle');
        activeLabel.classList.add('border-emerald-500', 'bg-emerald-50');
        activeLabel.classList.remove('border-slate-200', 'bg-white');
        activeCircle.classList.add('border-emerald-500', 'bg-emerald-500');
        activeCircle.classList.remove('border-slate-300', 'bg-white');

        // Update info pemohon
        document.getElementById('info_nama').textContent = radio.dataset.nama;
        document.getElementById('info_nik').textContent  = radio.dataset.nik;
    }

    // Daftarkan listener "change" pada setiap radio
    document.querySelectorAll('.pemohon-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.checked) {
                updateCardStyle(this);
            }
        });
    });

    // Inisialisasi tampilan kartu sesuai radio yang sudah diceklis saat halaman muat
    // (bisa karena default, bisa karena old() dari validasi gagal)
    var checkedRadio = document.querySelector('.pemohon-radio:checked');
    if (checkedRadio) {
        updateCardStyle(checkedRadio);
    }

    // ===========================================================
    // Persyaratan otomatis saat jenis surat dipilih
    // ===========================================================
    var selectTemplate = document.getElementById('surat_template_id');

    function createUploadField(item) {
        var wrapper = document.createElement('div');
        wrapper.className = 'space-y-2';

        var label = document.createElement('label');
        label.setAttribute('for', 'dokumen_persyaratan_' + item.id);
        label.className = 'block text-sm font-semibold text-slate-700';
        label.innerHTML = item.nama + ' <span class="text-red-500">*</span>';

        var input = document.createElement('input');
        input.type = 'file';
        input.name = 'dokumen_persyaratan[' + item.id + ']';
        input.id = 'dokumen_persyaratan_' + item.id;
        input.accept = '.jpg,.jpeg,.png,.pdf';
        input.required = true;
        input.className = 'w-full text-sm text-slate-700 border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none';

        var helper = document.createElement('p');
        helper.className = 'text-xs text-slate-500';
        helper.textContent = 'Unggah file dokumen persyaratan ini. Maksimal 2MB per file.';

        wrapper.appendChild(label);
        wrapper.appendChild(input);
        wrapper.appendChild(helper);

        return wrapper;
    }

    function refreshPersyaratan() {
        var opt = selectTemplate.options[selectTemplate.selectedIndex];
        var raw = opt ? opt.getAttribute('data-persyaratan') : '[]';
        var wrapper = document.getElementById('wrapper_persyaratan');
        var display = document.getElementById('list_persyaratan');
        var uploadFields = document.getElementById('upload_fields');
        var requirements = [];

        try {
            requirements = raw ? JSON.parse(raw) : [];
        } catch (e) {
            requirements = [];
        }

        uploadFields.innerHTML = '';

        if (opt && opt.value !== '') {
            wrapper.classList.remove('hidden');

            if (requirements.length > 0) {
                display.innerHTML = requirements.map(function (item) {
                    return '<li>' + item.nama + '</li>';
                }).join('');

                requirements.forEach(function (item) {
                    uploadFields.appendChild(createUploadField(item));
                });
            } else {
                display.innerHTML = '<li>Tidak ada persyaratan khusus untuk jenis surat ini. Unggah minimal satu dokumen pendukung utama.</li>';
                uploadFields.appendChild(createUploadField({ id: 'general', nama: 'Dokumen Pendukung Utama' }));
            }
        } else {
            wrapper.classList.add('hidden');
            display.innerHTML = '';
        }
    }

    selectTemplate.addEventListener('change', refreshPersyaratan);

    // Jalankan saat muat halaman jika ada pilihan old()
    if (selectTemplate.value !== '') {
        refreshPersyaratan();
    }

})();
</script>
@endsection
