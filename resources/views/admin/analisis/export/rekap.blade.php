<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi {{ $analisi->nama }} – {{ $periode->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-800 p-8">

    {{-- Print Button --}}
    <div class="no-print flex justify-end gap-3 mb-6">
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600 shadow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
            class="px-4 py-2.5 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">
            Tutup
        </button>
    </div>

    {{-- ── Kop Surat ── --}}
    <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
        <h1 class="text-xl font-bold uppercase tracking-wide">Rekapitulasi Hasil Analisis</h1>
        <h2 class="text-lg font-bold text-emerald-700 mt-1">{{ strtoupper($analisi->nama) }}</h2>
        <p class="text-sm text-gray-600 mt-1">
            Periode: {{ $periode->nama }}
            @if($periode->tanggal_mulai) · {{ $periode->tanggal_mulai->format('d M Y') }} @endif
            @if($periode->tanggal_selesai) – {{ $periode->tanggal_selesai->format('d M Y') }} @endif
        </p>
        <p class="text-xs text-gray-400 mt-1">Dicetak: {{ now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>

    {{-- ── Ringkasan Statistik ── --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="border border-gray-200 rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-gray-800">{{ $totalResponden }}</div>
            <div class="text-xs text-gray-500 mt-1">Total Responden</div>
        </div>
        <div class="border border-gray-200 rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-emerald-600">{{ number_format($rerataSkor, 1) }}</div>
            <div class="text-xs text-gray-500 mt-1">Rerata Skor</div>
        </div>
        <div class="border border-gray-200 rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-gray-800">{{ $klasifikasi->count() }}</div>
            <div class="text-xs text-gray-500 mt-1">Kategori Klasifikasi</div>
        </div>
    </div>

    {{-- ── Distribusi Klasifikasi ── --}}
    @if($klasifikasi->isNotEmpty())
    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">Distribusi Berdasarkan Klasifikasi</h3>
    <div class="grid grid-cols-2 sm:grid-cols-{{ min($klasifikasi->count(), 4) }} gap-3 mb-8">
        @foreach($klasifikasi as $klas)
        @php $jml = $distribusi[$klas->nama] ?? 0; @endphp
        <div class="rounded-xl p-4 border-2" style="border-color: {{ $klas->warna ?? '#10b981' }}">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-3 h-3 rounded-full" style="background-color: {{ $klas->warna ?? '#10b981' }}"></div>
                <span class="text-xs font-semibold text-gray-700">{{ $klas->nama }}</span>
            </div>
            <div class="text-2xl font-bold text-gray-800">{{ $jml }}</div>
            <div class="text-xs text-gray-400">
                {{ $totalResponden > 0 ? number_format($jml / $totalResponden * 100, 1) : 0 }}%
                · Skor {{ $klas->skor_min }}–{{ $klas->skor_max }}
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Tabel Responden ── --}}
    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">Daftar Responden</h3>
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="bg-emerald-600 text-white">
                <th class="border border-emerald-500 px-3 py-2 text-left w-8">No</th>
                <th class="border border-emerald-500 px-3 py-2 text-left">Subjek</th>
                <th class="border border-emerald-500 px-3 py-2 text-center">Total Skor</th>
                <th class="border border-emerald-500 px-3 py-2 text-center">Kategori</th>
                <th class="border border-emerald-500 px-3 py-2 text-center">Tanggal Survei</th>
            </tr>
        </thead>
        <tbody>
            @foreach($responden as $i => $resp)
            @php
            $klas2 = $klasifikasi->first(fn($k) => $k->nama === $resp->kategori_hasil);
            @endphp
            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                <td class="border border-gray-200 px-3 py-2 text-center text-gray-500">{{ $i + 1 }}</td>
                <td class="border border-gray-200 px-3 py-2 font-medium">{{ $resp->nama_subjek }}</td>
                <td class="border border-gray-200 px-3 py-2 text-center font-bold">{{ number_format($resp->total_skor,
                    1) }}</td>
                <td class="border border-gray-200 px-3 py-2 text-center">
                    @if($resp->kategori_hasil)
                    <span class="px-2 py-0.5 rounded text-xs font-semibold text-white"
                        style="background-color: {{ $klas2?->warna ?? '#6b7280' }}">
                        {{ $resp->kategori_hasil }}
                    </span>
                    @else
                    <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="border border-gray-200 px-3 py-2 text-center text-gray-500 text-xs">
                    {{ $resp->tgl_survei?->format('d/m/Y') ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-8 pt-4 border-t border-gray-200 text-xs text-gray-400 text-center">
        Dokumen ini digenerate otomatis oleh Sistem Lumbung Data · {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>