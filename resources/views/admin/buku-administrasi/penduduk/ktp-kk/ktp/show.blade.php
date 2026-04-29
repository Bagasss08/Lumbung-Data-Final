@extends('layouts.admin')
@section('title', 'Detail Penduduk')

@section('content')
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <p class="text-lg font-semibold text-gray-700">Detail Penduduk</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $ktp->nama }}</h2>
                <p class="text-sm font-mono text-gray-500 mt-1">NIK: {{ $ktp->nik }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $ktp->status_hidup === 'hidup' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                {{ ucfirst($ktp->status_hidup) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-sm">
            @php
            $fields = [
                'Jenis Kelamin'     => $ktp->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                'Tempat, Tgl Lahir' => $ktp->tempat_lahir . ', ' . $ktp->tanggal_lahir->format('d/m/Y'),
                'Golongan Darah'    => $ktp->golongan_darah ?? '-',
                'Agama'             => $ktp->agama,
                'Pendidikan'        => $ktp->pendidikan ?? '-',
                'Pekerjaan'         => $ktp->pekerjaan ?? '-',
                'Status Kawin'      => ucwords(str_replace('_', ' ', $ktp->status_kawin)),
                'Kewarganegaraan'   => $ktp->kewarganegaraan,
                'Alamat'            => $ktp->alamat,
                'No. Telepon'       => $ktp->no_telp ?? '-',
                'Email'             => $ktp->email ?? '-',
                'Wilayah'           => $ktp->wilayah?->nama ?? '-',
            ];
            @endphp
            @foreach($fields as $label => $value)
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">{{ $label }}</p>
                <p class="text-gray-800">{{ $value }}</p>
            </div>
            @endforeach
        </div>

        @if($ktp->keluarga)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <p class="text-gray-400 text-xs uppercase tracking-wider mb-2">Kartu Keluarga</p>
            <div class="flex items-center gap-3 text-sm">
                <span class="font-mono text-gray-700">{{ $ktp->keluarga->no_kk }}</span>
                <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $ktp->label_shdk }}</span>
                <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.kk.show', $ktp->keluarga) }}" class="text-indigo-600 hover:underline text-xs">Lihat KK →</a>
            </div>
        </div>
        @endif
    </div>

    <div class="flex justify-end gap-3 mt-4">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.ktp.edit', $ktp) }}"
           class="px-5 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors">Edit</a>
    </div>
@endsection