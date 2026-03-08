@extends('layouts.admin')
@section('title', 'Tambah Status Desa')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400 mb-6">
    <a href="{{ route('admin.status-desa.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Status Desa</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900 dark:text-slate-100">Tambah Data</span>
</nav>

@include('admin.info-desa.status-desa._form')
@endsection
