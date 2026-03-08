@extends('layouts.admin')

@section('title', 'Detail Keluarga')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Keluarga</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Informasi lengkap data keluarga</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.keluarga') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Keluarga
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Detail</span>
        </nav>
        <div class="flex gap-2">
            <a href="{{ route('admin.keluarga.edit', $keluarga) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.keluarga') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors border border-gray-200 dark:border-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kartu Profil ──────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 flex flex-col items-center text-center gap-4">

        {{-- Icon / Avatar --}}
        <div class="w-32 h-32 rounded-2xl overflow-hidden bg-blue-50 dark:bg-blue-900/30 border-2 border-blue-100 dark:border-blue-800 flex items-center justify-center">
            <svg class="w-14 h-14 text-blue-400 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>

        {{-- No KK & Info --}}
        <div>
            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium mb-1">No. Kartu Keluarga</p>
            <h2 class="text-lg font-bold text-gray-900 dark:text-slate-100 font-mono">{{ $keluarga->no_kk }}</h2>
            @if($keluarga->getKepalaKeluarga())
            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ $keluarga->getKepalaKeluarga()->nama }}</p>
            @endif
            <div class="flex flex-wrap items-center justify-center gap-2 mt-3">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    {{ $keluarga->anggota->count() }} Anggota
                </span>
                @if($keluarga->klasifikasi_ekonomi)
                @php
                    $badge = match($keluarga->klasifikasi_ekonomi) {
                        'miskin' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                        'rentan' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                        'mampu'  => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                        default  => 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400',
                    };
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                    {{ ucfirst($keluarga->klasifikasi_ekonomi) }}
                </span>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Detail Info ────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Informasi Keluarga --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-blue-100 dark:bg-blue-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                Informasi Keluarga
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">No. Kartu Keluarga</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5 font-mono">{{ $keluarga->no_kk }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Kepala Keluarga</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        @if($keluarga->getKepalaKeluarga())
                            {{ $keluarga->getKepalaKeluarga()->nama }}
                        @else
                            <span class="text-gray-400 dark:text-slate-500 italic font-normal">Belum ditentukan</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Tanggal Terdaftar</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $keluarga->tgl_terdaftar->format('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Wilayah</dt>
                    @if($keluarga->wilayah)
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        RT {{ $keluarga->wilayah->rt }} / RW {{ $keluarga->wilayah->rw }}
                        <span class="text-gray-500 dark:text-slate-400 font-normal">— {{ $keluarga->wilayah->dusun }}</span>
                    </dd>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">—</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Klasifikasi Ekonomi</dt>
                    <dd class="mt-0.5">
                        @if($keluarga->klasifikasi_ekonomi)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                            {{ ucfirst($keluarga->klasifikasi_ekonomi) }}
                        </span>
                        @else
                        <span class="text-sm text-gray-400 dark:text-slate-500">—</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Jenis Bantuan Aktif</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $keluarga->jenis_bantuan_aktif ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Alamat Lengkap</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $keluarga->alamat ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Anggota Keluarga --}}
        @if($keluarga->anggota->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-emerald-100 dark:bg-emerald-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider">Anggota Keluarga</h3>
                <span class="ml-auto inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 dark:bg-slate-700 text-xs font-semibold text-gray-600 dark:text-slate-300">
                    {{ $keluarga->anggota->count() }}
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">No</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden sm:table-cell">NIK</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Kelamin</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Hubungan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Rumah Tangga</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($keluarga->anggota as $index => $anggota)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                            <td class="px-5 py-4 text-gray-400 dark:text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 text-sm font-mono text-gray-600 dark:text-slate-400 hidden sm:table-cell">{{ $anggota->nik }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900 dark:text-slate-100">{{ $anggota->nama }}</td>
                            <td class="px-5 py-4 text-sm hidden md:table-cell">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $anggota->jenis_kelamin == 'L' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' : 'bg-pink-100 dark:bg-pink-900/40 text-pink-700 dark:text-pink-300' }}">
                                    {{ $anggota->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400">
                                @if($anggota->pivot->hubungan_keluarga == 'kepala_keluarga')
                                    <span class="font-medium text-emerald-700 dark:text-emerald-400">Kepala Keluarga</span>
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $anggota->pivot->hubungan_keluarga)) }}
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm hidden lg:table-cell">
                                @php $currentRumahTangga = $anggota->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first(); @endphp
                                @if($currentRumahTangga)
                                    <div class="text-gray-800 dark:text-slate-200 font-medium">{{ $currentRumahTangga->no_rumah_tangga }}</div>
                                    <div class="text-xs text-gray-400 dark:text-slate-500">{{ ucfirst(str_replace('_', ' ', $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}</div>
                                @else
                                    <span class="text-gray-400 dark:text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.penduduk.show', $anggota) }}"
                                        title="Lihat Detail Penduduk"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all duration-150 hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Metadata --}}
        <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex flex-wrap items-center gap-4 text-xs text-gray-400 dark:text-slate-500">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dibuat: {{ $keluarga->created_at->format('d M Y H:i') }}
            </div>
            @if($keluarga->updated_at != $keluarga->created_at)
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Diperbarui: {{ $keluarga->updated_at->format('d M Y H:i') }}
            </div>
            @endif
        </div>

    </div>
</div>

@include('admin.partials.modal-hapus')
@endsection