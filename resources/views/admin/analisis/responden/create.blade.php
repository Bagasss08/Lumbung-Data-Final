@extends('layouts.admin')

@section('title', 'Input Data Responden')

@section('content')
<div class="max-w-3xl">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.analisis.index') }}" class="hover:text-emerald-600">Analisis</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.analisis.show', $analisi) }}" class="hover:text-emerald-600">{{ $analisi->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.analisis.responden.index', $analisi) }}" class="hover:text-emerald-600">Responden</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Input Data</span>
    </div>

    {{-- ── Info Periode ── --}}
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <div class="text-sm">
            <span class="font-semibold text-emerald-800">Periode: {{ $periode->nama }}</span>
            @if($periode->tanggal_mulai)
            <span class="text-emerald-600 ml-2">
                ({{ $periode->tanggal_mulai->format('d M Y') }}
                @if($periode->tanggal_selesai) – {{ $periode->tanggal_selesai->format('d M Y') }} @endif)
            </span>
            @endif
        </div>
    </div>

    <form action="{{ route('admin.analisis.responden.store', $analisi) }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="id_periode" value="{{ $periode->id }}">

        {{-- ── Pilih Subjek ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-bold text-gray-800 mb-4">Identitas {{ $analisi->subjek_label }}</h4>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Pilih {{ $analisi->subjek_label }} <span class="text-red-500">*</span>
                </label>
                <select name="id_subjek" required
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 @error('id_subjek') border-red-400 @enderror">
                    <option value="">-- Pilih {{ $analisi->subjek_label }} --</option>
                    @foreach($subjekList as $subjek)
                    <option value="{{ $subjek['id'] }}" {{ old('id_subjek') == $subjek['id'] ? 'selected' : '' }}>
                        {{ $subjek['label'] }}
                    </option>
                    @endforeach
                </select>
                @error('id_subjek')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── Form Indikator ── --}}
        @forelse($indikator as $idx => $ind)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-3 mb-4">
                <span
                    class="w-7 h-7 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-bold flex items-center justify-center flex-shrink-0 mt-0.5">
                    {{ $idx + 1 }}
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $ind->pertanyaan }}</p>
                    <span class="text-xs text-gray-400 mt-0.5 inline-block">{{ $ind->jenis_label }}</span>
                </div>
            </div>

            @switch($ind->jenis)
            @case('OPTION')
            <div class="space-y-2 ml-10">
                @foreach($ind->jawaban as $jaw)
                <label
                    class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:border-emerald-300 hover:bg-emerald-50/40 cursor-pointer transition-all group">
                    <input type="checkbox" name="jawaban[{{ $ind->id }}][]" value="{{ $jaw->id }}" {{ in_array($jaw->id,
                    old('jawaban.'.$ind->id, [])) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-emerald-500 border-gray-300 focus:ring-emerald-400">
                    <span class="flex-1 text-sm text-gray-700 group-hover:text-gray-900">{{ $jaw->jawaban }}</span>
                    <span class="text-xs text-emerald-600 font-semibold">{{ $jaw->nilai }} poin</span>
                </label>
                @endforeach
            </div>
            @break
            @case('RADIO')
            <div class="space-y-2 ml-10">
                @foreach($ind->jawaban as $jaw)
                <label
                    class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:border-emerald-300 hover:bg-emerald-50/40 cursor-pointer transition-all group">
                    <input type="radio" name="jawaban[{{ $ind->id }}]" value="{{ $jaw->id }}" {{
                        old('jawaban.'.$ind->id) == $jaw->id ? 'checked' : '' }}
                    class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-400">
                    <span class="flex-1 text-sm text-gray-700 group-hover:text-gray-900">{{ $jaw->jawaban }}</span>
                    <span class="text-xs text-emerald-600 font-semibold">{{ $jaw->nilai }} poin</span>
                </label>
                @endforeach
            </div>
            @break
            @case('TEXT')
            <div class="ml-10">
                <input type="text" name="jawaban[{{ $ind->id }}]" value="{{ old('jawaban.'.$ind->id) }}"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            @break
            @case('TEXTAREA')
            <div class="ml-10">
                <textarea name="jawaban[{{ $ind->id }}]" rows="3"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none">{{ old('jawaban.'.$ind->id) }}</textarea>
            </div>
            @break
            @case('NUMBER')
            <div class="ml-10">
                <input type="number" name="jawaban[{{ $ind->id }}]" value="{{ old('jawaban.'.$ind->id) }}" step="0.01"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            @break
            @case('DATE')
            <div class="ml-10">
                <input type="date" name="jawaban[{{ $ind->id }}]" value="{{ old('jawaban.'.$ind->id) }}"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            @break
            @endswitch
        </div>
        @empty
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Belum ada indikator aktif. Tambahkan indikator terlebih dahulu.
        </div>
        @endforelse

        {{-- ── Tombol Simpan ── --}}
        @if($indikator->isNotEmpty())
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.analisis.responden.index', [$analisi, 'id_periode' => $periode->id]) }}"
                class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md transition-all hover:-translate-y-0.5">
                Simpan & Hitung Skor
            </button>
        </div>
        @endif
    </form>

</div>
@endsection
