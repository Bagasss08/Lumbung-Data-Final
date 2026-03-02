@extends('layouts.admin')

@section('title', 'Edit Pengaturan Surat')

@section('content')
<div class="card">
    <div class="card-body">

        {{-- Header --}}
        <div class="mb-3">
            <h5 class="mb-0">Daftar Surat</h5>
            <small class="text-muted">Edit Pengaturan Surat</small>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3">
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

        <a href="{{ route('template-surat.index') }}" class="btn btn-info btn-sm mb-3">
            ← Kembali Ke Daftar Surat
        </a>

        <form method="POST" action="{{ route('template-surat.update', $template->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Template</label>
                <input 
                    type="text" 
                    name="judul" 
                    value="{{ $template->judul }}" 
                    class="form-control" 
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Template Surat</label>
                <textarea id="editor" name="konten_template" rows="20">
{!! $template->konten_template !!}
                </textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('template-surat.index') }}" class="btn btn-danger">
                    ❌ Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    💾 Update dan Simpan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/vukod3pizqgpsnkcywuv6m8chh9d0lzz4x6bbtm6e6vdmo4b/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 520,
        menubar: 'file edit view insert format tools table',
        plugins: 'preview searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat | fullscreen preview',
        branding: false,
    });
</script>
@endpush   