@extends('layouts.admin')

@section('title', $analisi->nama)

@section('content')
<div class="space-y-6" x-data="{ tab: 'indikator' }">

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- ── Header Card ── --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <a href="{{ route('admin.analisis.index') }}"
                    class="mt-1 p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs bg-white/20 px-2 py-0.5 rounded font-mono">{{ $analisi->kode }}</span>
                        @if($analisi->lock)
                        <span
                            class="text-xs bg-amber-400/30 text-amber-100 px-2 py-0.5 rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Dikunci
                        </span>
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold">{{ $analisi->nama }}</h2>
                    @if($analisi->deskripsi)
                    <p class="text-sm text-white/70 mt-1">{{ $analisi->deskripsi }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-2 text-sm text-white/80">
                        <span>Subjek: <strong class="text-white">{{ $analisi->subjek_label }}</strong></span>
                        @if($analisi->periode)<span>· Periode: <strong class="text-white">{{ $analisi->periode
                                }}</strong></span>@endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.analisis.edit', $analisi) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.analisis.responden.index', $analisi) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white text-emerald-700 hover:bg-emerald-50 rounded-xl text-sm font-semibold transition-colors shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Data Responden
                </a>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="bg-white/10 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold">{{ $analisi->indikator->count() }}</div>
                <div class="text-xs text-white/70 mt-0.5">Indikator</div>
            </div>
            <div class="bg-white/10 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold">{{ number_format($totalResponden) }}</div>
                <div class="text-xs text-white/70 mt-0.5">Responden</div>
            </div>
            <div class="bg-white/10 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold">{{ number_format($rerataSkor, 1) }}</div>
                <div class="text-xs text-white/70 mt-0.5">Rerata Skor</div>
            </div>
        </div>
    </div>

    {{-- ── Lock Banner ── --}}
    @if($analisi->lock)
    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="text-sm font-medium">Analisis ini dikunci. Indikator dan jawaban tidak dapat diubah.</span>
        <form action="{{ route('admin.analisis.toggle-lock', $analisi) }}" method="POST" class="ml-auto">
            @csrf
            <button type="submit" class="text-xs font-semibold underline hover:text-amber-900">Buka Kunci</button>
        </form>
    </div>
    @endif

    {{-- ── Tabs ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex border-b border-gray-100 overflow-x-auto">
            @foreach([
            ['indikator', 'Indikator', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0
            002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['periode', 'Periode', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002
            2z'],
            ['klasifikasi','Klasifikasi', 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0
            01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ] as [$key, $label, $icon])
            <button @click="tab = '{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'border-b-2 border-emerald-500 text-emerald-600 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-6 py-4 text-sm transition-colors whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                </svg>
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- ── Tab: Indikator ── --}}
        <div x-show="tab === 'indikator'" x-cloak class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold text-gray-800">Daftar Indikator</h4>
                @if(!$analisi->lock)
                <button onclick="document.getElementById('modal-indikator').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Indikator
                </button>
                @endif
            </div>

            @forelse($analisi->indikator as $idx => $ind)
            <div class="border border-gray-100 rounded-xl p-4 hover:border-emerald-200 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full font-medium">
                                {{ $ind->jenis_label }}
                            </span>
                            @if(!$ind->aktif)
                            <span class="text-xs px-2 py-0.5 bg-red-100 text-red-600 rounded-full">Non-aktif</span>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-800">{{ $ind->pertanyaan }}</p>

                        {{-- Opsi Jawaban --}}
                        @if($ind->isChoice() && $ind->jawaban->isNotEmpty())
                        <div class="mt-3 space-y-1.5">
                            @foreach($ind->jawaban as $jaw)
                            <div class="flex items-center justify-between bg-gray-50 px-3 py-1.5 rounded-lg">
                                <span class="text-xs text-gray-600">{{ $jaw->jawaban }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold text-emerald-600">Skor: {{ $jaw->nilai }}</span>
                                    @if(!$analisi->lock)
                                    <form
                                        action="{{ route('admin.analisis.indikator.jawaban.destroy', [$analisi, $ind, $jaw]) }}"
                                        method="POST" onsubmit="return confirm('Hapus opsi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Tambah Jawaban (hanya jenis pilihan) --}}
                        @if($ind->isChoice() && !$analisi->lock)
                        <details class="mt-3">
                            <summary class="text-xs text-emerald-600 cursor-pointer hover:text-emerald-700 font-medium">
                                + Tambah Opsi Jawaban
                            </summary>
                            <form action="{{ route('admin.analisis.indikator.jawaban.store', [$analisi, $ind]) }}"
                                method="POST" class="mt-2 flex gap-2">
                                @csrf
                                <input type="text" name="jawaban" placeholder="Teks jawaban" required
                                    class="flex-1 px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                <input type="number" name="nilai" placeholder="Skor" step="0.01" required
                                    class="w-20 px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                <button type="submit"
                                    class="px-3 py-1.5 bg-emerald-500 text-white text-xs rounded-lg hover:bg-emerald-600">
                                    Simpan
                                </button>
                            </form>
                        </details>
                        @endif
                    </div>

                    @if(!$analisi->lock)
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <form action="{{ route('admin.analisis.indikator.destroy', [$analisi, $ind]) }}" method="POST"
                            onsubmit="return confirm('Hapus indikator ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-sm">Belum ada indikator</p>
            </div>
            @endforelse
        </div>

        {{-- ── Tab: Periode ── --}}
        <div x-show="tab === 'periode'" x-cloak class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold text-gray-800">Daftar Periode</h4>
                <button onclick="document.getElementById('modal-periode').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Periode
                </button>
            </div>

            @forelse($analisi->periodeList as $per)
            <div
                class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3 hover:border-emerald-200 transition-colors">
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $per->nama }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $per->tanggal_mulai?->format('d M Y') ?? '-' }}
                        @if($per->tanggal_selesai) — {{ $per->tanggal_selesai->format('d M Y') }} @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    @if($per->aktif)
                    <span
                        class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">Aktif</span>
                    @else
                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Tidak Aktif</span>
                    @endif
                    <a href="{{ route('admin.analisis.responden.index', [$analisi, 'id_periode' => $per->id]) }}"
                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                        {{ $per->responden()->count() }} responden
                    </a>
                    <form action="{{ route('admin.analisis.periode.destroy', [$analisi, $per]) }}" method="POST"
                        onsubmit="return confirm('Hapus periode ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400">
                <p class="text-sm">Belum ada periode</p>
            </div>
            @endforelse
        </div>

        {{-- ── Tab: Klasifikasi ── --}}
        <div x-show="tab === 'klasifikasi'" x-cloak class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold text-gray-800">Klasifikasi Hasil</h4>
                <button onclick="document.getElementById('modal-klasifikasi').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Klasifikasi
                </button>
            </div>
            <p class="text-xs text-gray-400">Tentukan rentang skor untuk mengkategorikan hasil analisis.</p>

            @forelse($analisi->klasifikasi as $klas)
            <div
                class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3 hover:border-emerald-200 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 rounded-full flex-shrink-0"
                        style="background-color: {{ $klas->warna ?? '#10b981' }}"></div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $klas->nama }}</p>
                        <p class="text-xs text-gray-400">Skor: {{ $klas->skor_min }} – {{ $klas->skor_max }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono text-gray-400">{{ $klas->warna }}</span>
                    <form action="{{ route('admin.analisis.klasifikasi.destroy', [$analisi, $klas]) }}" method="POST"
                        onsubmit="return confirm('Hapus klasifikasi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400">
                <p class="text-sm">Belum ada klasifikasi</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ══ MODAL: Tambah Indikator ══════════════════════════════════════════════ --}}
<div id="modal-indikator"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Tambah Indikator</h3>
            <button onclick="document.getElementById('modal-indikator').classList.add('hidden')"
                class="p-1.5 text-gray-400 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.analisis.indikator.store', $analisi) }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pertanyaan/Indikator <span
                        class="text-red-500">*</span></label>
                <textarea name="pertanyaan" rows="3" required
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none"
                    placeholder="Tuliskan pertanyaan atau indikator..."></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Jawaban</label>
                    <select name="jenis"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <option value="OPTION">Pilihan Ganda</option>
                        <option value="RADIO">Pilihan Tunggal</option>
                        <option value="TEXT">Teks Singkat</option>
                        <option value="TEXTAREA">Teks Panjang</option>
                        <option value="NUMBER">Angka</option>
                        <option value="DATE">Tanggal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
                    <input type="number" name="urutan" min="1" value="{{ $analisi->indikator->count() + 1 }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="aktif" id="aktif-ind" value="1" checked
                    class="w-4 h-4 rounded text-emerald-500 border-gray-300 focus:ring-emerald-400">
                <label for="aktif-ind" class="text-sm text-gray-700">Indikator aktif</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-indikator').classList.add('hidden')"
                    class="px-5 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL: Tambah Periode ═══════════════════════════════════════════════ --}}
<div id="modal-periode"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Tambah Periode</h3>
            <button onclick="document.getElementById('modal-periode').classList.add('hidden')"
                class="p-1.5 text-gray-400 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.analisis.periode.store', $analisi) }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Periode <span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama" required placeholder="Contoh: Semester 1 2024"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="aktif" id="aktif-per" value="1" checked
                    class="w-4 h-4 rounded text-emerald-500 border-gray-300">
                <label for="aktif-per" class="text-sm text-gray-700">Periode aktif</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-periode').classList.add('hidden')"
                    class="px-5 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL: Tambah Klasifikasi ════════════════════════════════════════════ --}}
<div id="modal-klasifikasi"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Tambah Klasifikasi</h3>
            <button onclick="document.getElementById('modal-klasifikasi').classList.add('hidden')"
                class="p-1.5 text-gray-400 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.analisis.klasifikasi.store', $analisi) }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Klasifikasi <span
                        class="text-red-500">*</span></label>
                <input type="text" name="nama" required placeholder="Contoh: Sangat Miskin"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Skor Min <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="skor_min" step="0.01" required placeholder="0"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Skor Max <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="skor_max" step="0.01" required placeholder="100"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Warna</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="warna" value="#10b981"
                            class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                        <span class="text-xs text-gray-400">Klik untuk pilih warna</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
                    <input type="number" name="urutan" min="1" value="{{ $analisi->klasifikasi->count() + 1 }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-klasifikasi').classList.add('hidden')"
                    class="px-5 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    // Tutup modal saat klik backdrop
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
</script>
@endsection
@endsection
