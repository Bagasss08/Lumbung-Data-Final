@extends('layouts.admin')

@section('title', 'Edit Pengaturan Surat')

@section('content')
<div class="card">
    <div class="card-body">

        {{-- Alert Error jika Validasi Gagal --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <h5 class="mb-0">Daftar Surat</h5>
            <small class="text-muted">Edit Pengaturan Surat: <strong>{{ $template->judul }}</strong></small>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link" href="#">Umum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Template</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Form Isian</a>
            </li>
        </ul>

        <form method="POST" action="{{ route('admin.layanan-surat.template-surat.update', $template->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Judul Template --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul Template</label>
                    <input type="text" name="judul" value="{{ old('judul', $template->judul) }}" class="form-control" required>
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="aktif" {{ old('status', $template->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="noaktif" {{ old('status', $template->status) == 'noaktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                {{-- Kode Klasifikasi DROPDOWN --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kode Klasifikasi</label>
                    <select name="kode_klasifikasi" class="form-select" required>
                        <option value="">-- Pilih Klasifikasi Surat --</option>
                        @if(isset($klasifikasis))
                            @foreach($klasifikasis as $klasifikasi)
                                <option value="{{ $klasifikasi->kode }}" {{ old('kode_klasifikasi', $template->kode_klasifikasi) == $klasifikasi->kode ? 'selected' : '' }}>
                                    {{ $klasifikasi->kode }} - {{ $klasifikasi->nama_klasifikasi }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Lampiran (Ganti format_nomor) --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lampiran</label>
                    <input type="text" name="lampiran" value="{{ old('lampiran', $template->lampiran) }}" class="form-control" placeholder="Contoh: 1 (Satu) Berkas">
                </div>
            </div>

            {{-- --- BAGIAN PERSYARATAN SURAT --- --}}
            <div class="mb-4 p-3 border rounded bg-light">
                <label class="form-label fw-bold d-block mb-3">Persyaratan Surat (Ceklis yang dibutuhkan)</label>
                
                <div class="row">
                    @if(isset($persyaratans) && count($persyaratans) > 0)
                        @php
                            // Mengambil ID persyaratan yang sudah dipilih sebelumnya
                            $persyaratanTerpilih = old('persyaratan', $template->persyaratan->pluck('id')->toArray());
                        @endphp

                        @foreach($persyaratans as $syarat)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="persyaratan[]" 
                                           value="{{ $syarat->id }}" id="syarat_{{ $syarat->id }}"
                                           {{ in_array($syarat->id, $persyaratanTerpilih) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="syarat_{{ $syarat->id }}">
                                        {{ $syarat->nama_persyaratan ?? $syarat->nama }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-muted">
                            <em>Belum ada master data persyaratan. Silakan tambahkan di menu Pengaturan Persyaratan.</em>
                        </div>
                    @endif
                </div>
            </div>
            {{-- --- AKHIR BAGIAN PERSYARATAN SURAT --- --}}

            {{-- Editor TinyMCE --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Isi Template Surat</label>
                <textarea id="editor" name="konten_template" rows="20">{!! old('konten_template', $template->konten_template) !!}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <div class="gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        💾 Update dan Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
{{-- Memanggil TinyMCE Lokal --}}
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 600,
        menubar: 'file edit view insert format tools table',
        plugins: 'preview searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat | fullscreen preview',
        branding: false,
        promotion: false,
        license_key: 'gpl',
        
        // Memastikan isi TinyMCE masuk ke textarea sebelum disubmit
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
</script>
@endpush