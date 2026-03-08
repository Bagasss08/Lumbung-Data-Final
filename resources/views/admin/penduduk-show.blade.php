@extends('layouts.admin')

@section('title', 'Detail Penduduk')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Informasi lengkap data penduduk</p>
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
            <a href="{{ route('admin.penduduk') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Penduduk
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Detail</span>
        </nav>
        <div class="flex gap-2">
            <a href="{{ route('admin.penduduk.edit', $penduduk) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.penduduk') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
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

        {{-- Foto / Avatar --}}
        <div class="w-32 h-32 rounded-2xl overflow-hidden bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-100 dark:border-emerald-800 flex items-center justify-center">
            <span class="text-4xl font-bold text-emerald-500 dark:text-emerald-400">
                {{ strtoupper(substr($penduduk->nama, 0, 2)) }}
            </span>
        </div>

        {{-- Nama & Info --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ $penduduk->nama }}</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 font-mono mt-0.5">{{ $penduduk->nik }}</p>
            <div class="flex flex-wrap items-center justify-center gap-2 mt-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $penduduk->jenis_kelamin == 'L' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300' }}">
                    {{ $penduduk->jenis_kelamin == 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $penduduk->status_hidup == 'hidup' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                    {{ ucfirst($penduduk->status_hidup) }}
                </span>
                @if($penduduk->golongan_darah)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                    Gol. {{ $penduduk->golongan_darah }}
                </span>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Detail Info ────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Identitas --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-emerald-100 dark:bg-emerald-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                Identitas Dasar
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Tempat, Tgl Lahir</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Agama</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->agama }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Kewarganegaraan</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->kewarganegaraan }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Alamat</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->alamat ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Keluarga & Wilayah --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-blue-100 dark:bg-blue-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                Keluarga & Wilayah
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Keluarga (KK)</dt>
                    @php $currentKeluarga = $penduduk->keluargas()->withPivot('hubungan_keluarga')->first(); @endphp
                    @if($currentKeluarga)
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5 font-mono">{{ $currentKeluarga->no_kk }}</dd>
                    <dd class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $currentKeluarga->getKepalaKeluarga()->nama ?? 'N/A' }}</dd>
                    <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                        {{ ucfirst(str_replace('_', ' ', $currentKeluarga->pivot->hubungan_keluarga)) }}
                    </span>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Belum ada keluarga</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Rumah Tangga</dt>
                    @php $currentRumahTangga = $penduduk->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first(); @endphp
                    @if($currentRumahTangga)
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5 font-mono">{{ $currentRumahTangga->no_rumah_tangga }}</dd>
                    <dd class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $currentRumahTangga->kepalaRumahTangga()->nama ?? 'N/A' }}</dd>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Belum ada rumah tangga</dd>
                    @endif
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Wilayah</dt>
                    @if($penduduk->wilayah)
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        RT {{ $penduduk->wilayah->rt }} / RW {{ $penduduk->wilayah->rw }}
                        <span class="text-gray-500 dark:text-slate-400 font-normal">— {{ $penduduk->wilayah->dusun }}</span>
                    </dd>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Belum ada wilayah</dd>
                    @endif
                </div>
            </dl>
        </div>

        {{-- Status & Pendidikan --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-purple-100 dark:bg-purple-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                Status & Pendidikan
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Status Kawin</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->status_kawin }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Pendidikan</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $penduduk->pendidikan ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Pekerjaan</dt>
                    <dd class="mt-0.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $penduduk->pekerjaan == 'bekerja' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400' }}">
                            {{ $penduduk->pekerjaan == 'bekerja' ? 'Bekerja' : 'Tidak Bekerja' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Kontak --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-pink-100 dark:bg-pink-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                Kontak
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">No. Telepon</dt>
                    @if($penduduk->no_telp)
                    <dd class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5">
                        <a href="tel:{{ $penduduk->no_telp }}" class="hover:underline">{{ $penduduk->no_telp }}</a>
                    </dd>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">—</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Email</dt>
                    @if($penduduk->email)
                    <dd class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5">
                        <a href="mailto:{{ $penduduk->email }}" class="hover:underline truncate block">{{ $penduduk->email }}</a>
                    </dd>
                    @else
                    <dd class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">—</dd>
                    @endif
                </div>
            </dl>
        </div>

        {{-- Metadata --}}
        <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex flex-wrap items-center gap-4 text-xs text-gray-400 dark:text-slate-500">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dibuat: {{ $penduduk->created_at->format('d M Y H:i') }}
            </div>
            @if($penduduk->updated_at != $penduduk->created_at)
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Diperbarui: {{ $penduduk->updated_at->format('d M Y H:i') }}
            </div>
            @endif
        </div>

    </div>
</div>

@include('admin.partials.modal-hapus')
@endsection

