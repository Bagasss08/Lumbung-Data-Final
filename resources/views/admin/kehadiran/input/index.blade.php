@extends('layouts.admin')

@section('title', 'Input Kehadiran')

@section('content')
<div class="space-y-5" x-data="inputKehadiran()">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Input Kehadiran</h3>
            <p class="text-sm text-gray-500 mt-0.5">Input manual harian atau import dari mesin fingerprint</p>
        </div>
        <a href="{{ route('admin.kehadiran.rekapitulasi.index') }}"
            class="inline-flex items-center gap-2 text-sm text-emerald-600 hover:text-emerald-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Lihat Rekapitulasi
        </a>
    </div>

    @if(session('success'))
    <div
        class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl text-sm">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl text-sm">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- TAB SWITCHER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1.5 flex gap-1">
        <button @click="tab = 'manual'"
            :class="tab==='manual' ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Input Manual
        </button>
        <button @click="tab = 'fingerprint'"
            :class="tab==='fingerprint' ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
            </svg>
            Import Fingerprint
        </button>
    </div>

    {{-- ======================================================== --}}
    {{-- TAB MANUAL --}}
    {{-- ======================================================== --}}
    <div x-show="tab === 'manual'" x-transition>
        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
            <form method="GET" action="{{ route('admin.kehadiran.input.index') }}"
                class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[160px]">
                    <label
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                </div>
                <div class="flex-[2] min-w-[220px]">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Shift / Jam
                        Kerja</label>
                    <select name="jam_kerja_id"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white">
                        <option value="">-- Tanpa shift --</option>
                        @foreach($jamKerjas as $jk)
                        <option value="{{ $jk->id }}" {{ $jamKerjaId==$jk->id ? 'selected' : '' }}>
                            {{ $jk->nama_shift }}
                            ({{ \Carbon\Carbon::parse($jk->jam_masuk)->format('H:i') }}–{{
                            \Carbon\Carbon::parse($jk->jam_keluar)->format('H:i') }},
                            tol. {{ $jk->toleransi_menit }}m)
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="h-10 px-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- Banner hari libur / weekend --}}
        @if($hariLibur)
        <div
            class="flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl text-sm mb-4">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Tanggal ini adalah <strong>{{ $hariLibur->nama }}</strong>. Status default diset ke
                <strong>Libur</strong>.</span>
        </div>
        @elseif($isWeekend)
        <div
            class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm mb-4">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l') }}</strong> — akhir pekan. Status
                default diset ke <strong>Libur</strong>.</span>
        </div>
        @endif

        {{-- Form tabel kehadiran --}}
        <form action="{{ route('admin.kehadiran.input.simpan-manual') }}" method="POST">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="jam_kerja_id" value="{{ $jamKerjaId }}">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Toolbar --}}
                <div class="flex items-center justify-between px-5 py-3.5 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                        @if($jamKerja)
                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-lg font-medium">
                            {{ $jamKerja->nama_shift }}
                        </span>
                        @endif
                        <span class="text-xs text-gray-400">{{ $perangkats->count() }} perangkat</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="setSemuaStatus('hadir')"
                            class="h-8 px-3 text-xs bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 font-medium">Semua
                            Hadir</button>
                        <button type="button" onclick="setSemuaStatus('libur')"
                            class="h-8 px-3 text-xs bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 font-medium">Semua
                            Libur</button>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-white">
                                <th
                                    class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    #</th>
                                <th
                                    class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Perangkat</th>
                                <th
                                    class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jabatan</th>
                                <th
                                    class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jam Masuk</th>
                                <th
                                    class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jam Keluar</th>
                                <th
                                    class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                                <th
                                    class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($perangkats as $i => $p)
                            @php
                            $k = $kehadiranAda[$p->id] ?? null;
                            $defaultStatus = ($hariLibur || $isWeekend) ? 'libur' : 'hadir';
                            $curStatus = $k?->status ?? $defaultStatus;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors" id="row-{{ $p->id }}">
                                <td class="px-5 py-3.5 text-xs text-gray-400 font-medium">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}"
                                            class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                                        @else
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($p->nama, 0, 2)) }}
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm leading-tight">{{ $p->nama }}
                                            </p>
                                            @if($p->nik)
                                            <p class="text-[10px] text-gray-400 font-mono">{{ $p->nik }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" name="kehadiran[{{ $i }}][perangkat_id]" value="{{ $p->id }}">
                                </td>
                                <td class="px-4 py-3.5 text-xs text-gray-500 max-w-[140px]">
                                    {{ $p->jabatan?->nama ?? '-' }}
                                </td>
                                <td class="px-3 py-3.5">
                                    <input type="time" name="kehadiran[{{ $i }}][jam_masuk]"
                                        value="{{ $k?->jam_masuk_aktual ? \Carbon\Carbon::parse($k->jam_masuk_aktual)->format('H:i') : '' }}"
                                        class="w-24 px-2 py-1.5 rounded-lg border border-gray-200 focus:border-emerald-400 text-xs outline-none text-center font-mono">
                                </td>
                                <td class="px-3 py-3.5">
                                    <input type="time" name="kehadiran[{{ $i }}][jam_keluar]"
                                        value="{{ $k?->jam_keluar_aktual ? \Carbon\Carbon::parse($k->jam_keluar_aktual)->format('H:i') : '' }}"
                                        class="w-24 px-2 py-1.5 rounded-lg border border-gray-200 focus:border-emerald-400 text-xs outline-none text-center font-mono">
                                </td>
                                <td class="px-3 py-3.5">
                                    @php
                                    $statusColors =
                                    ['hadir'=>'emerald','terlambat'=>'amber','izin'=>'blue','sakit'=>'cyan','alpa'=>'red','dinas_luar'=>'purple','cuti'=>'indigo','libur'=>'gray'];
                                    @endphp
                                    <select name="kehadiran[{{ $i }}][status]"
                                        class="status-select w-full px-2 py-1.5 rounded-lg border border-gray-200 focus:border-emerald-400 text-xs outline-none bg-white"
                                        onchange="updateRowColor(this)">
                                        @foreach(['hadir'=>'Hadir','terlambat'=>'Terlambat','izin'=>'Izin','sakit'=>'Sakit','alpa'=>'Alpa','dinas_luar'=>'Dinas
                                        Luar','cuti'=>'Cuti','libur'=>'Libur'] as $val => $lbl)
                                        <option value="{{ $val }}" {{ $curStatus===$val ? 'selected' : '' }}>{{ $lbl }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-3 py-3.5">
                                    <input type="text" name="kehadiran[{{ $i }}][keterangan]"
                                        value="{{ $k?->keterangan ?? '' }}" placeholder="Opsional..."
                                        class="w-full min-w-[120px] px-2 py-1.5 rounded-lg border border-gray-200 focus:border-emerald-400 text-xs outline-none">
                                </td>
                                <td class="px-3 py-3.5 text-center">
                                    @if($k)
                                    <button type="button" onclick="hapusKehadiran({{ $p->id }}, '{{ $tanggal }}', this)"
                                        class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                                    Tidak ada perangkat desa aktif.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($perangkats->count() > 0)
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4">
                    <p class="text-xs text-gray-400">
                        Status <strong class="text-amber-600">Terlambat</strong> dihitung otomatis saat simpan
                        berdasarkan jam masuk + toleransi shift.
                    </p>
                    <button type="submit"
                        class="inline-flex items-center gap-2 h-10 px-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Semua
                    </button>
                </div>
                @endif
            </div>
        </form>
    </div>

    {{-- ======================================================== --}}
    {{-- TAB FINGERPRINT --}}
    {{-- ======================================================== --}}
    <div x-show="tab === 'fingerprint'" x-transition>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Panel kiri: Upload --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h4 class="font-semibold text-gray-800 mb-0.5">Upload File Absensi</h4>
                    <p class="text-xs text-gray-500 mb-4">CSV / TXT dari mesin ZKTeco, Fingerspot, dll</p>

                    <div class="space-y-3">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" id="fp_tanggal" value="{{ $tanggal }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Shift
                                / Jam Kerja</label>
                            <select id="fp_jam_kerja_id"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 text-sm outline-none bg-white">
                                <option value="">-- Tanpa shift --</option>
                                @foreach($jamKerjas as $jk)
                                <option value="{{ $jk->id }}" {{ $jamKerjaId==$jk->id ? 'selected' : '' }}>
                                    {{ $jk->nama_shift }} (tol. {{ $jk->toleransi_menit }}m)
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">File</label>
                            <div id="dropzone"
                                class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/50 transition-all"
                                onclick="document.getElementById('fp_file').click()">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p id="dropzoneLabel" class="text-sm text-gray-400">Klik untuk pilih file</p>
                                <p class="text-xs text-gray-300 mt-0.5">CSV, TXT — maks 5MB</p>
                            </div>
                            <input type="file" id="fp_file" accept=".csv,.txt" class="hidden"
                                onchange="onFileSelected(this)">
                        </div>
                        <button onclick="previewFingerprint()"
                            class="w-full h-10 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all">
                            Preview Data
                        </button>
                    </div>
                </div>

                {{-- Panduan format --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-800 space-y-2">
                    <p class="font-semibold text-blue-700">📋 Format yang Didukung</p>
                    <div>
                        <p class="font-medium">ZKTeco</p><code
                            class="text-[10px] bg-blue-100 px-1.5 py-0.5 rounded block mt-0.5">NIK,Nama,Tanggal,Jam,Status</code>
                    </div>
                    <div>
                        <p class="font-medium">Fingerspot</p><code
                            class="text-[10px] bg-blue-100 px-1.5 py-0.5 rounded block mt-0.5">ID[TAB]Tanggal[TAB]Jam</code>
                    </div>
                    <div>
                        <p class="font-medium">Format Umum</p><code
                            class="text-[10px] bg-blue-100 px-1.5 py-0.5 rounded block mt-0.5">NIK,Tanggal,JamMasuk,JamKeluar</code>
                    </div>
                    <p class="text-blue-600 pt-1">⚡ Mapping otomatis via NIK perangkat desa</p>
                </div>
            </div>

            {{-- Panel kanan: Preview hasil --}}
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 min-h-[400px] flex flex-col overflow-hidden">

                    <div id="fpIdle" class="flex-1 flex flex-col items-center justify-center py-16 text-gray-300">
                        <svg class="w-14 h-14 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                        <p class="text-sm text-gray-400">Upload file untuk melihat preview</p>
                    </div>

                    <div id="fpLoading" class="hidden flex-1 flex flex-col items-center justify-center py-16 gap-3">
                        <div
                            class="w-10 h-10 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin">
                        </div>
                        <p class="text-sm text-gray-500">Memproses file...</p>
                    </div>

                    <div id="fpError" class="hidden flex-1 flex-col items-center justify-center py-12 gap-3 px-6">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <p id="fpErrorMsg" class="text-sm text-red-600 font-medium text-center"></p>
                    </div>

                    <div id="fpResult" class="hidden flex flex-col flex-1">
                        {{-- Statistik --}}
                        <div class="px-5 py-3.5 bg-gray-50 border-b border-gray-100 flex items-center gap-6 flex-wrap">
                            <div class="text-center">
                                <p id="fpTotal" class="text-xl font-bold text-gray-800">-</p>
                                <p class="text-xs text-gray-500">Total</p>
                            </div>
                            <div class="text-center">
                                <p id="fpMatched" class="text-xl font-bold text-emerald-600">-</p>
                                <p class="text-xs text-gray-500">Cocok</p>
                            </div>
                            <div class="text-center">
                                <p id="fpUnmatched" class="text-xl font-bold text-red-500">-</p>
                                <p class="text-xs text-gray-500">Tidak dikenali</p>
                            </div>
                            <div class="ml-auto">
                                <button id="btnImportFP" onclick="importFingerprint()"
                                    class="inline-flex items-center gap-2 h-9 px-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all">
                                    Import ke Database
                                </button>
                            </div>
                        </div>
                        {{-- Tabel --}}
                        <div class="overflow-auto flex-1">
                            <table class="w-full text-xs">
                                <thead class="sticky top-0 bg-white border-b border-gray-100">
                                    <tr>
                                        <th class="text-left px-4 py-3 font-semibold text-gray-500 uppercase">NIK</th>
                                        <th class="text-left px-4 py-3 font-semibold text-gray-500 uppercase">Nama</th>
                                        <th class="text-center px-4 py-3 font-semibold text-gray-500 uppercase">Tanggal
                                        </th>
                                        <th class="text-center px-4 py-3 font-semibold text-gray-500 uppercase">Masuk
                                        </th>
                                        <th class="text-center px-4 py-3 font-semibold text-gray-500 uppercase">Keluar
                                        </th>
                                        <th class="text-center px-4 py-3 font-semibold text-gray-500 uppercase">Status
                                        </th>
                                        <th class="text-center px-4 py-3 font-semibold text-gray-500 uppercase">Mapping
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="fpTableBody" class="divide-y divide-gray-50"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Form tersembunyi untuk submit fingerprint --}}
        <form id="formImportFP" action="{{ route('admin.kehadiran.input.simpan-fingerprint') }}" method="POST"
            enctype="multipart/form-data" class="hidden">
            @csrf
            <input type="file" name="file" id="fp_file_submit">
            <input type="hidden" name="tanggal" id="fp_tanggal_submit">
            <input type="hidden" name="jam_kerja_id" id="fp_jam_kerja_submit">
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function inputKehadiran() {
    return { tab: 'manual' };
}

// Warna baris sesuai status
const rowBgMap = {
    hadir:'',terlambat:'bg-amber-50',izin:'bg-blue-50',
    sakit:'bg-cyan-50/50',alpa:'bg-red-50',dinas_luar:'bg-purple-50/50',
    cuti:'bg-indigo-50/50',libur:'bg-gray-50'
};
function updateRowColor(sel) {
    const row = sel.closest('tr');
    Object.values(rowBgMap).forEach(c => { if(c) row.classList.remove(c); });
    const bg = rowBgMap[sel.value];
    if (bg) row.classList.add(bg);
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.status-select').forEach(updateRowColor);
});

function setSemuaStatus(status) {
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.value = status;
        updateRowColor(sel);
    });
}

function hapusKehadiran(perangkatId, tanggal, btn) {
    if (!confirm('Hapus data kehadiran ini?')) return;
    fetch('{{ route("admin.kehadiran.input.hapus") }}', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},
        body: JSON.stringify({perangkat_id: perangkatId, tanggal: tanggal})
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) { btn.closest('td').innerHTML = ''; }
    });
}

// --- FINGERPRINT ---
function onFileSelected(input) {
    const lbl = document.getElementById('dropzoneLabel');
    if (input.files.length > 0) {
        lbl.textContent = '✓ ' + input.files[0].name;
        lbl.className = 'text-sm text-emerald-600 font-medium';
        document.getElementById('dropzone').classList.add('border-emerald-400', 'bg-emerald-50/50');
    }
}

function showFpState(state) {
    ['fpIdle','fpLoading','fpError','fpResult'].forEach(id => {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    });
    const target = document.getElementById(state);
    target.classList.remove('hidden');
    if (['fpIdle','fpLoading','fpError','fpResult'].includes(state)) {
        target.classList.add('flex');
    }
}

function previewFingerprint() {
    const file = document.getElementById('fp_file').files[0];
    if (!file) { alert('Pilih file terlebih dahulu.'); return; }

    showFpState('fpLoading');

    const fd = new FormData();
    fd.append('file', file);
    fd.append('jam_kerja_id', document.getElementById('fp_jam_kerja_id').value);
    fd.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("admin.kehadiran.input.preview-fingerprint") }}', {method:'POST', body:fd})
    .then(r => r.json())
    .then(res => {
        if (!res.success) {
            document.getElementById('fpErrorMsg').textContent = res.message;
            showFpState('fpError');
            return;
        }

        document.getElementById('fpTotal').textContent     = res.total;
        document.getElementById('fpMatched').textContent   = res.matched;
        document.getElementById('fpUnmatched').textContent = res.unmatched;

        const statusLabel = {hadir:'Hadir',terlambat:'Terlambat',izin:'Izin',sakit:'Sakit',alpa:'Alpa',dinas_luar:'Dinas Luar',cuti:'Cuti',libur:'Libur'};
        const statusColor = {hadir:'emerald',terlambat:'amber',izin:'blue',sakit:'cyan',alpa:'red',dinas_luar:'purple',cuti:'indigo',libur:'gray'};

        const tbody = document.getElementById('fpTableBody');
        tbody.innerHTML = '';
        res.data.forEach(row => {
            const found = row.status_mapping === 'found';
            const sc = statusColor[row.status_hasil] || 'gray';
            const tr = document.createElement('tr');
            tr.className = found ? 'hover:bg-gray-50' : 'bg-red-50/50';
            tr.innerHTML = `
                <td class="px-4 py-2.5 font-mono text-gray-600">${row.nik}</td>
                <td class="px-4 py-2.5">
                    <p class="font-medium text-gray-800">${found ? row.nama_perangkat : (row.nama_file||'-')}</p>
                    ${found ? `<p class="text-[10px] text-gray-400">${row.jabatan}</p>` : '<p class="text-[10px] text-red-400">NIK tidak terdaftar</p>'}
                </td>
                <td class="px-4 py-2.5 text-center text-gray-600">${row.tanggal||'-'}</td>
                <td class="px-4 py-2.5 text-center font-mono">${row.jam_masuk||'-'}</td>
                <td class="px-4 py-2.5 text-center font-mono">${row.jam_keluar||'-'}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-semibold bg-${sc}-50 text-${sc}-700">
                        ${statusLabel[row.status_hasil]||row.status_hasil}
                        ${row.menit_terlambat > 0 ? ` +${row.menit_terlambat}m` : ''}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-center">
                    ${found
                        ? '<span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-lg font-medium">✓ Cocok</span>'
                        : '<span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded-lg font-medium">✗ Tidak dikenali</span>'
                    }
                </td>`;
            tbody.appendChild(tr);
        });

        const btn = document.getElementById('btnImportFP');
        if (res.matched === 0) {
            btn.disabled = true;
            btn.textContent = 'Tidak ada data cocok';
            btn.className = btn.className + ' opacity-50 cursor-not-allowed';
        }

        showFpState('fpResult');
    })
    .catch(() => {
        document.getElementById('fpErrorMsg').textContent = 'Gagal menghubungi server.';
        showFpState('fpError');
    });
}

function importFingerprint() {
    if (!confirm('Import data ke database? Data yang sudah ada tidak akan ditimpa.')) return;
    const file = document.getElementById('fp_file').files[0];
    if (!file) return;

    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('fp_file_submit').files = dt.files;
    document.getElementById('fp_tanggal_submit').value   = document.getElementById('fp_tanggal').value;
    document.getElementById('fp_jam_kerja_submit').value = document.getElementById('fp_jam_kerja_id').value;
    document.getElementById('formImportFP').submit();
}
</script>
@endsection