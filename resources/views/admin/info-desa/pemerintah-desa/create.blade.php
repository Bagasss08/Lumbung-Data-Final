@extends('layouts.admin')

@section('title', 'Tambah Perangkat Desa')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div>
        <nav class="text-xs text-gray-500 mb-1">
            <a href="{{ route('admin.pemerintah-desa.index') }}" class="hover:text-emerald-600">Pemerintah Desa</a>
            <span class="mx-1">›</span>
            <span class="text-emerald-600 font-medium">Tambah Perangkat</span>
        </nav>
        <p class="text-sm text-gray-500">Isi formulir di bawah untuk menambahkan data perangkat desa</p>
    </div>

    <form action="{{ route('admin.pemerintah-desa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.info-desa.pemerintah-desa._form')

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.pemerintah-desa.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow hover:brightness-105 transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Data
                </span>
            </button>
        </div>

    </form>
</div>
@endsection

@stack('scripts')