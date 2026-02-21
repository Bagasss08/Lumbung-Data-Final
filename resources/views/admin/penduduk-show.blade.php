@extends('layouts.admin')

@section('title', 'Detail Penduduk')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.penduduk') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <a href="{{ route('admin.penduduk.edit', $penduduk) }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Data
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header with Profile -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-8">
            <div class="flex items-center gap-4">
                <div
                    class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30">
                    <span class="text-3xl font-bold text-white">
                        {{ strtoupper(substr($penduduk->nama, 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white">{{ $penduduk->nama }}</h2>
                    <p class="text-emerald-50 text-sm mt-1">NIK: {{ $penduduk->nik }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm border border-white/30">
                            {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm border border-white/30">
                            {{ ucfirst($penduduk->status_hidup) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="p-6">
            <!-- Informasi Dasar -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d F Y') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Golongan Darah</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->golongan_darah ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Agama</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->agama }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Kewarganegaraan</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->kewarganegaraan }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Keluarga & Wilayah -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    Informasi Keluarga & Wilayah
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Keluarga</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @php
                                $currentKeluarga = $penduduk->keluargas()->withPivot('hubungan_keluarga')->first();
                            @endphp
                            @if($currentKeluarga)
                            {{ $currentKeluarga->no_kk }}
                            <span class="text-gray-500 font-normal">
                                ({{ $currentKeluarga->getKepalaKeluarga()->nama ?? 'N/A' }})
                            </span>
                            <br>
                            <span class="text-xs text-gray-600">
                                Hubungan: {{ ucfirst(str_replace('_', ' ', $currentKeluarga->pivot->hubungan_keluarga)) }}
                            </span>
                            @else
                            <span class="text-gray-400">Belum ada keluarga</span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Rumah Tangga</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @php
                                $currentRumahTangga = $penduduk->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();
                            @endphp
                            @if($currentRumahTangga)
                            {{ $currentRumahTangga->no_rumah_tangga }}
                            <span class="text-gray-500 font-normal">
                                ({{ $currentRumahTangga->kepalaRumahTangga()->nama ?? 'N/A' }})
                            </span>
                            <br>
                            <span class="text-xs text-gray-600">
                                Hubungan: {{ ucfirst(str_replace('_', ' ', $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}
                            </span>
                            @else
                            <span class="text-gray-400">Belum ada rumah tangga</span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Wilayah</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($penduduk->wilayah)
                            RT {{ $penduduk->wilayah->rt }} / RW {{ $penduduk->wilayah->rw }} - {{
                            $penduduk->wilayah->dusun }}
                            @else
                            <span class="text-gray-400">Belum ada wilayah</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status & Pendidikan -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    Status & Pendidikan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Status Kawin</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->status_kawin }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Pendidikan Terakhir</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->pendidikan ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Pekerjaan</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $penduduk->pekerjaan == 'bekerja' ? 'Bekerja' : 'Tidak Bekerja' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kontak & Alamat -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-pink-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    Kontak & Alamat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">No. Telepon</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($penduduk->no_telp)
                            <a href="tel:{{ $penduduk->no_telp }}" class="text-emerald-600 hover:text-emerald-700">
                                {{ $penduduk->no_telp }}
                            </a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Email</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($penduduk->email)
                            <a href="mailto:{{ $penduduk->email }}" class="text-emerald-600 hover:text-emerald-700">
                                {{ $penduduk->email }}
                            </a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Alamat Lengkap</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $penduduk->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex items-center gap-6 text-xs text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Dibuat: {{ $penduduk->created_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($penduduk->updated_at != $penduduk->created_at)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Diperbarui: {{ $penduduk->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection