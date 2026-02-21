@extends('layouts.admin')

@section('title', 'Detail Rumah Tangga')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.rumah-tangga.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <a href="{{ route('admin.rumah-tangga.edit', $rumahTangga) }}"
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
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white">{{ $rumahTangga->no_rumah_tangga }}</h2>
                    <p class="text-emerald-50 text-sm mt-1">Kepala Rumah Tangga: {{ $rumahTangga->kepala_rumah_tangga_name }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm border border-white/30">
                            {{ $rumahTangga->status == 'aktif' ? 'Aktif' : 'Pindah' }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm border border-white/30">
                            {{ $rumahTangga->jumlah_anggota }} Anggota
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
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Kepala Rumah Tangga</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $rumahTangga->kepala_rumah_tangga_name }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Tanggal Terdaftar</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($rumahTangga->tgl_terdaftar)
                                {{ $rumahTangga->tgl_terdaftar->format('d F Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Jumlah Anggota</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $rumahTangga->jumlah_anggota }} orang</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Wilayah & Ekonomi -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Informasi Wilayah & Ekonomi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Wilayah</p>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($rumahTangga->wilayah)
                            RT {{ $rumahTangga->wilayah->rt }} / RW {{ $rumahTangga->wilayah->rw }} - {{
                            $rumahTangga->wilayah->dusun }}
                            @else
                            <span class="text-gray-400">Belum ada wilayah</span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-1">Klasifikasi Ekonomi</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $rumahTangga->klasifikasi_ekonomi ? ucfirst($rumahTangga->klasifikasi_ekonomi) : '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 md:col-span-2">
                        <p class="text-xs font-medium text-gray-500 mb-1">Jenis Bantuan Aktif</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $rumahTangga->jenis_bantuan_aktif ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-pink-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Alamat Lengkap
                </h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">{{ $rumahTangga->alamat ?? '-' }}</p>
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
                        <span>Dibuat: {{ $rumahTangga->created_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($rumahTangga->updated_at != $rumahTangga->created_at)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Diperbarui: {{ $rumahTangga->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Rumah Tangga -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Anggota Rumah Tangga</h3>
                <a href="{{ route('admin.rumah-tangga-anggota.index', $rumahTangga) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Kelola Anggota
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hubungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($rumahTangga->anggota as $index => $anggota)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $anggota->nik }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $anggota->nama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($anggota->pivot->hubungan_rumah_tangga == 'kepala_rumah_tangga') bg-emerald-100 text-emerald-800
                                @elseif($anggota->pivot->hubungan_rumah_tangga == 'istri' || $anggota->pivot->hubungan_rumah_tangga == 'suami') bg-pink-100 text-pink-800
                                @elseif($anggota->pivot->hubungan_rumah_tangga == 'anak') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $anggota->pivot->hubungan_rumah_tangga)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-900">Belum ada anggota rumah tangga</p>
                                <p class="text-sm text-gray-500 mt-1">Klik "Kelola Anggota" untuk menambahkan anggota</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
