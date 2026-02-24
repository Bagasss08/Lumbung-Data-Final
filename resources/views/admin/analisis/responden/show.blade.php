@extends('layouts.admin')

@section('title', 'Detail Responden')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.analisis.index') }}" class="hover:text-emerald-600">Analisis</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.analisis.responden.index', $analisi) }}" class="hover:text-emerald-600">{{
            $analisi->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Detail Responden</span>
    </div>

    {{-- ── Summary Card ── --}}
    @php
    $klas = $analisi->klasifikasi->first(fn($k) => $k->nama === $responden->kategori_hasil);
    @endphp
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm text-white/70 mb-1">Subjek · {{ $analisi->subjek_label }}</p>
                <h2 class="text-2xl font-bold">{{ $responden->nama_subjek }}</h2>
                <p class="text-sm text-white/70 mt-1">
                    Periode: <strong class="text-white">{{ $responden->periode->nama }}</strong>
                    @if($responden->tgl_survei)
                    · Tanggal: <strong class="text-white">{{ $responden->tgl_survei->format('d M Y') }}</strong>
                    @endif
                </p>
            </div>
            <div class="text-right flex-shrink-0">
                <div class="text-3xl font-bold">{{ number_format($responden->total_skor, 1) }}</div>
                <div class="text-xs text-white/70">Total Skor</div>
                @if($responden->kategori_hasil)
                <div class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-semibold text-white"
                    style="background-color: {{ $klas?->warna ? $klas->warna.'33' : 'rgba(255,255,255,0.2)' }}; border: 1px solid {{ $klas?->warna ?? '#fff' }}33">
                    {{ $responden->kategori_hasil }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Jawaban Detail ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h4 class="font-bold text-gray-800">Detail Jawaban</h4>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($indikator as $idx => $ind)
            @php
            $rj = $responden->responJawaban->where('id_indikator', $ind->id)->first();
            @endphp
            <div class="px-6 py-4">
                <div class="flex items-start gap-3">
                    <span
                        class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">
                        {{ $idx + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">{{ $ind->pertanyaan }}</p>
                        <div class="mt-2 flex items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                @if(!$rj)
                                <span class="text-gray-400 italic">Tidak dijawab</span>
                                @elseif($ind->isChoice())
                                <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg font-medium">
                                    {{ $rj->jawaban?->jawaban ?? '-' }}
                                </span>
                                @else
                                <span class="bg-gray-50 text-gray-700 px-3 py-1 rounded-lg">
                                    {{ $rj->jawaban_teks ?? '-' }}
                                </span>
                                @endif
                            </div>
                            @if($rj && $rj->nilai != 0)
                            <span class="text-xs font-semibold text-emerald-600 flex-shrink-0">
                                +{{ $rj->nilai }} poin
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-700">Total Skor</span>
            <span class="text-xl font-bold text-emerald-600">{{ number_format($responden->total_skor, 1) }}</span>
        </div>
    </div>

    {{-- ── Tombol Kembali ── --}}
    <div class="flex justify-start">
        <a href="{{ route('admin.analisis.responden.index', [$analisi, 'id_periode' => $responden->id_periode]) }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

</div>
@endsection