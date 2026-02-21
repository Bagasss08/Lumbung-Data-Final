@extends('layouts.admin')

@section('title', 'Detail Keluarga')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Detail Keluarga</h2>
            <p class="text-sm text-slate-500">Informasi lengkap keluarga {{ $keluarga->no_kk }}</p>
        </div>
        <a href="{{ route('admin.keluarga') }}"
           class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- No. KK -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">No. Kartu Keluarga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->no_kk }}</p>
            </div>

            <!-- Kepala Keluarga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kepala Keluarga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    @if($keluarga->getKepalaKeluarga())
                        {{ $keluarga->getKepalaKeluarga()->nama }}
                    @else
                        Belum ditentukan
                    @endif
                </p>
            </div>

            <!-- Wilayah -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Wilayah</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    RT {{ $keluarga->wilayah->rt }} / RW {{ $keluarga->wilayah->rw }} - {{ $keluarga->wilayah->dusun }}
                </p>
            </div>

            <!-- Tanggal Terdaftar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Terdaftar</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->tgl_terdaftar->format('d/m/Y') }}</p>
            </div>



            <!-- Klasifikasi Ekonomi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Klasifikasi Ekonomi</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->klasifikasi_ekonomi ? ucfirst($keluarga->klasifikasi_ekonomi) : '-' }}</p>
            </div>

            <!-- Jenis Bantuan Aktif -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Bantuan Aktif</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->jenis_bantuan_aktif ?? '-' }}</p>
            </div>

            <!-- Jumlah Anggota -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Anggota Keluarga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->anggota->count() }} orang</p>
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->alamat ?? '-' }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.keluarga.edit', $keluarga) }}"
               class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition duration-200">
                Edit Keluarga
            </a>
            <a href="{{ route('admin.keluarga') }}"
               class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg font-semibold transition duration-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- Anggota Keluarga -->
    @if($keluarga->anggota->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Anggota Keluarga</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-100">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">NIK</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Hubungan Keluarga</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Rumah Tangga</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($keluarga->anggota as $index => $anggota)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $anggota->nik }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $anggota->nama }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            @if($anggota->pivot->hubungan_keluarga == 'kepala_keluarga')
                                Kepala Keluarga
                            @else
                                {{ ucfirst(str_replace('_', ' ', $anggota->pivot->hubungan_keluarga)) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            @php
                                $currentRumahTangga = $anggota->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();
                            @endphp
                            @if($currentRumahTangga)
                                {{ $currentRumahTangga->no_rumah_tangga }}
                                <br>
                                <small class="text-gray-500">{{ ucfirst(str_replace('_', ' ', $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}</small>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.penduduk.show', $anggota) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
