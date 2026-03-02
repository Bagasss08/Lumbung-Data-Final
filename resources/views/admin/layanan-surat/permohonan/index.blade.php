@extends('layouts.admin')

@section('title', 'Permohonan Surat')

@section('content')
@php
    // Menghitung statistik untuk Summary Cards secara dinamis
    $statMenunggu = \App\Models\SuratPermohonan::whereIn('status', ['belum lengkap', 'sedang diperiksa', 'menunggu tandatangan'])->count();
    $statDisetujui = \App\Models\SuratPermohonan::whereIn('status', ['siap diambil', 'sudah diambil'])->count();
    $statDitolak = \App\Models\SuratPermohonan::where('status', 'dibatalkan')->count();
    $statTotal = \App\Models\SuratPermohonan::count();
@endphp

<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Permohonan Surat</h1>
                <p class="text-sm text-slate-500">Kelola permohonan surat dari warga secara real-time</p>
            </div>

            <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white text-sm font-bold rounded-xl shadow-md transition" onclick="openModal()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Permohonan
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Menunggu / Diproses</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $statMenunggu }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Siap / Selesai</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $statDisetujui }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Dibatalkan</p>
                        <p class="text-2xl font-bold text-red-600">{{ $statDitolak }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Total Pengajuan</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $statTotal }}</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.layanan-surat.permohonan.index') }}" method="GET" class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6 flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status Permohonan</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="belum lengkap" {{ request('status') == 'belum lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                    <option value="sedang diperiksa" {{ request('status') == 'sedang diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                    <option value="menunggu tandatangan" {{ request('status') == 'menunggu tandatangan' ? 'selected' : '' }}>Menunggu Tandatangan</option>
                    <option value="siap diambil" {{ request('status') == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="sudah diambil" {{ request('status') == 'sudah diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            
            <div class="w-full md:w-2/4">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Cari Pemohon</label>
                <div class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition" placeholder="Cari NIK atau Nama Penduduk...">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-r-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </div>
        </form>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-slate-600">No.</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Pemohon</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Jenis Surat</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Waktu Pengajuan</th>
                            <th class="py-4 px-6 font-semibold text-slate-600 text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-slate-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($permohonan as $key => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-6 text-slate-600">{{ $permohonan->firstItem() + $key }}</td>
                            <td class="py-3 px-6">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $item->penduduk->nama ?? 'Tidak Diketahui' }}</p>
                                    <p class="text-xs text-slate-500">NIK: {{ $item->penduduk->nik ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-slate-700 font-medium">
                                {{ $item->jenisSurat->nama_jenis_surat ?? 'Lainnya' }}
                            </td>
                            <td class="py-3 px-6 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}<br>
                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                @php
                                    $bg = 'bg-slate-100'; $text = 'text-slate-700';
                                    if($item->status == 'belum lengkap') { $bg = 'bg-red-100'; $text = 'text-red-700'; }
                                    elseif($item->status == 'sedang diperiksa') { $bg = 'bg-yellow-100'; $text = 'text-yellow-700'; }
                                    elseif($item->status == 'menunggu tandatangan') { $bg = 'bg-blue-100'; $text = 'text-blue-700'; }
                                    elseif($item->status == 'siap diambil') { $bg = 'bg-emerald-100'; $text = 'text-emerald-700'; }
                                    elseif($item->status == 'sudah diambil') { $bg = 'bg-green-100'; $text = 'text-green-700'; }
                                    elseif($item->status == 'dibatalkan') { $bg = 'bg-rose-100'; $text = 'text-rose-700'; }
                                @endphp
                                <span class="px-3 py-1 {{ $bg }} {{ $text }} rounded-full text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.layanan-surat.permohonan.show', $item->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="Lihat & Kelola Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>Belum ada data permohonan surat.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($permohonan->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $permohonan->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

<div id="modal" class="fixed inset-0 bg-slate-900 bg-opacity-50 hidden z-50 backdrop-blur-sm transition-opacity">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full border border-slate-100">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Tambah Permohonan (Manual)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <form>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">NIK Pemohon</label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Masukkan 16 Digit NIK">
                        </div>

                        @php
                            // Ambil jenis surat untuk select box di modal
                            $jenisSuratList = \App\Models\JenisSurat::all();
                        @endphp

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Jenis Surat</label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                @foreach($jenisSuratList as $js)
                                    <option value="{{ $js->id }}">{{ $js->nama_jenis_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Keperluan</label>
                            <textarea class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" rows="3" placeholder="Jelaskan keperluan surat..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Upload Dokumen Pendukung (Opsional)</label>
                            <input type="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" multiple>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition" onclick="closeModal()">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection