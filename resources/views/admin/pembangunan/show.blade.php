@extends('layouts.admin')

@section('title', 'Detail Pembangunan')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-6">
    <a href="{{ route('admin.pembangunan.index') }}" class="hover:text-emerald-600">Pembangunan</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900 truncate max-w-xs">{{ $pembangunan->nama }}</span>
</nav>

@php
$progres = $pembangunan->dokumentasis->isNotEmpty()
? $pembangunan->dokumentasis->last()->persentase
: 0;
$total = $pembangunan->total_anggaran;
@endphp

{{-- Flash message --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-3.5">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri: Info Kegiatan ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $pembangunan->nama }}</h2>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @if($pembangunan->sasaran)
                        <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-700 font-medium">
                            {{ $pembangunan->sasaran->nama }}
                        </span>
                        @endif
                        @if($pembangunan->bidang)
                        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">
                            {{ $pembangunan->bidang->nama }}
                        </span>
                        @endif
                        <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">
                            TA {{ $pembangunan->tahun_anggaran }}
                        </span>
                        {!! $pembangunan->status_badge !!}
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('admin.pembangunan.edit', $pembangunan) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            {{-- Progres bar --}}
            <div class="mb-5">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-sm font-medium text-gray-600">Progres Pelaksanaan</span>
                    <span class="text-2xl font-bold {{ $progres >= 100 ? 'text-emerald-600' : 'text-blue-600' }}">
                        {{ $progres }}%
                    </span>
                </div>
                <div class="h-4 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700
                        {{ $progres >= 100 ? 'bg-gradient-to-r from-emerald-400 to-emerald-600' : 'bg-gradient-to-r from-blue-400 to-indigo-600' }}"
                        style="width: {{ $progres }}%"></div>
                </div>
                @if($progres >= 100)
                <p class="mt-1.5 text-xs text-emerald-600 font-medium">✓ Kegiatan selesai 100% — dapat dilaporkan di
                    Buku Inventaris Hasil Pembangunan</p>
                @endif
            </div>

            {{-- Detail info --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Pelaksana</p>
                    <p class="font-medium text-gray-800">{{ $pembangunan->pelaksana ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Sumber Dana</p>
                    <p class="font-medium text-gray-800">{{ $pembangunan->sumberDana?->nama ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Volume</p>
                    <p class="font-medium text-gray-800">
                        {{ $pembangunan->volume ? number_format($pembangunan->volume, 0, ',', '.') . ' ' .
                        $pembangunan->satuan : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Durasi</p>
                    <p class="font-medium text-gray-800">{{ $pembangunan->waktu ? $pembangunan->waktu . ' hari' : '-' }}
                    </p>
                </div>
                @if($pembangunan->mulai_pelaksanaan)
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Tanggal Mulai</p>
                    <p class="font-medium text-gray-800">{{ $pembangunan->mulai_pelaksanaan->translatedFormat('d F Y')
                        }}</p>
                </div>
                @endif
                @if($pembangunan->akhir_pelaksanaan)
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Tanggal Selesai</p>
                    <p class="font-medium text-gray-800">{{ $pembangunan->akhir_pelaksanaan->translatedFormat('d F Y')
                        }}</p>
                </div>
                @endif
                @if($pembangunan->lokasi)
                <div class="col-span-2">
                    <p class="text-xs text-gray-500 mb-0.5">Lokasi</p>
                    <p class="font-medium text-gray-800">
                        Dusun {{ $pembangunan->lokasi->dusun }}, RW {{ $pembangunan->lokasi->rw }}, RT {{
                        $pembangunan->lokasi->rt }}
                    </p>
                </div>
                @endif
                @if($pembangunan->lat && $pembangunan->lng)
                <div class="col-span-2">
                    <p class="text-xs text-gray-500 mb-0.5">Koordinat</p>
                    <p class="font-medium text-gray-800 font-mono text-xs">{{ $pembangunan->lat }}, {{ $pembangunan->lng
                        }}</p>
                </div>
                @endif
            </div>

            @if($pembangunan->dokumentasi)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Uraian Kegiatan</p>
                <p class="text-sm text-gray-700">{{ $pembangunan->dokumentasi }}</p>
            </div>
            @endif
        </div>

        {{-- ── Rincian Anggaran (Multi-sumber) ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Rincian Anggaran</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach([
                    ['label' => 'Dana Pemerintah (APBN/DD)', 'value' => $pembangunan->dana_pemerintah, 'color' =>
                    'blue'],
                    ['label' => 'Dana Provinsi', 'value' => $pembangunan->dana_provinsi, 'color' => 'purple'],
                    ['label' => 'Dana Kab/Kota', 'value' => $pembangunan->dana_kabkota, 'color' => 'indigo'],
                    ['label' => 'Swadaya Masyarakat', 'value' => $pembangunan->swadaya, 'color' => 'emerald'],
                    ['label' => 'Sumber Lain', 'value' => $pembangunan->sumber_lain, 'color' => 'gray'],
                    ] as $row)
                    @if($row['value'] > 0)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-600">{{ $row['label'] }}</span>
                        <span class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($row['value'], 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-between bg-amber-50 rounded-xl px-4 py-3">
                    <span class="text-sm font-bold text-gray-800">Total Anggaran</span>
                    <span class="text-xl font-bold text-amber-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- ── Dokumentasi & Progres ── --}}
        {{-- Sesuai OpenSID: progres ada di pembangunan_ref_dokumentasi.persentase --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ showForm: false }">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Dokumentasi & Progres</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Progres pembangunan diperbarui setiap menambah dokumentasi
                    </p>
                </div>
                <button @click="showForm = !showForm"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Dokumentasi
                </button>
            </div>

            {{-- Form tambah dokumentasi --}}
            <div x-show="showForm" x-collapse class="px-6 py-5 bg-emerald-50 border-b border-emerald-100">
                <form method="POST" action="{{ route('admin.pembangunan.dokumentasi.store', $pembangunan) }}"
                    enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Judul <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Progres Minggu 1"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Persentase Progres <span class="text-red-500">*</span>
                            <span class="font-normal text-gray-400 ml-1">— disimpan di tabel dokumentasi</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="persentase" required min="0" max="100" value="{{ $progres }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <span class="text-sm font-bold text-gray-600 shrink-0">%</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Foto</label>
                        <input type="file" name="foto" accept="image/*"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Uraian</label>
                        <textarea name="uraian" rows="2" placeholder="Keterangan dokumentasi..."
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none"></textarea>
                    </div>
                    <div class="md:col-span-2 flex justify-end gap-3">
                        <button type="button" @click="showForm = false"
                            class="px-4 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700">Simpan</button>
                    </div>
                </form>
            </div>

            {{-- Daftar dokumentasi --}}
            <div class="p-6">
                @forelse($pembangunan->dokumentasis as $dok)
                <div class="flex gap-4 pb-5 mb-5 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0">
                    {{-- Foto --}}
                    <div class="w-24 h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        @if($dok->foto)
                        <img src="{{ $dok->foto_url }}" alt="{{ $dok->judul }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h4 class="font-medium text-gray-900 text-sm truncate">{{ $dok->judul }}</h4>
                            {!! $dok->persentase_badge !!}
                        </div>
                        <p class="text-xs text-gray-500 mb-1.5">
                            {{ $dok->tanggal?->translatedFormat('d F Y') ?? '-' }}
                        </p>
                        @if($dok->uraian)
                        <p class="text-xs text-gray-600 line-clamp-2">{{ $dok->uraian }}</p>
                        @endif
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full">
                                <div class="h-full rounded-full {{ $dok->persentase >= 100 ? 'bg-emerald-500' : 'bg-blue-500' }}"
                                    style="width: {{ $dok->persentase }}%"></div>
                            </div>
                        </div>
                    </div>
                    {{-- Hapus --}}
                    <form method="POST"
                        action="{{ route('admin.pembangunan.dokumentasi.destroy', [$pembangunan, $dok]) }}"
                        onsubmit="return confirm('Hapus dokumentasi ini?')" class="shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-300 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-sm text-gray-400">Belum ada dokumentasi. Klik "Tambah Dokumentasi" untuk menambah
                        foto dan memperbarui progres.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Kolom Kanan: Foto Utama + Peta ── --}}
    <div class="space-y-5">
        {{-- Foto utama --}}
        @if($pembangunan->foto)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <img src="{{ $pembangunan->foto_url }}" alt="{{ $pembangunan->nama }}" class="w-full h-52 object-cover">
            <div class="px-4 py-3">
                <p class="text-xs text-gray-500">Foto Utama Kegiatan</p>
            </div>
        </div>
        @endif

        {{-- Koordinat peta --}}
        @if($pembangunan->lat && $pembangunan->lng)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Lokasi di Peta</h3>
            </div>
            <div id="map" class="w-full h-52 bg-gray-100"></div>
            <div class="px-5 py-3 text-xs text-gray-500 font-mono">
                {{ $pembangunan->lat }}, {{ $pembangunan->lng }}
            </div>
        </div>
        @endif

        {{-- Ringkasan cepat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Ringkasan Kegiatan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Bidang</span>
                    <span class="font-medium text-right text-xs max-w-[160px]">{{ $pembangunan->bidang?->nama ?? '-'
                        }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Sasaran</span>
                    <span class="font-medium">{{ $pembangunan->sasaran?->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Volume</span>
                    <span class="font-medium">{{ $pembangunan->volume ? $pembangunan->volume . ' ' .
                        $pembangunan->satuan : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Durasi</span>
                    <span class="font-medium">{{ $pembangunan->waktu ? $pembangunan->waktu . ' hari' : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Dokumen</span>
                    <span class="font-bold text-emerald-700">{{ $pembangunan->dokumentasis->count() }} entri</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@if($pembangunan->lat && $pembangunan->lng)
@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $pembangunan->lat }};
    const lng = {{ $pembangunan->lng }};
    const map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map)
      .bindPopup('<strong>{{ addslashes($pembangunan->nama) }}</strong>').openPopup();
});
</script>
@endsection
@endif