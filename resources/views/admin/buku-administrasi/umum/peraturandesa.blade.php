@extends('layouts.admin')

@section('title', 'Buku Peraturan di Desa')

@section('content')

@include('admin.partials.modal-hapus')

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <p class="text-lg font-semibold text-gray-700 mb-1">Buku Peraturan di Desa</p>
            <p class="text-sm text-gray-400">Kelola dan pantau peraturan desa dengan mudah</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Peraturan</label>
                <select name="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    <option value="Peraturan Desa" {{ request('jenis') == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                    <option value="Peraturan Kepala Desa" {{ request('jenis') == 'Peraturan Kepala Desa' ? 'selected' : '' }}>Peraturan Kepala Desa</option>
                </select>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            @if(request()->hasAny(['status', 'jenis', 'tahun']))
                <div>
                    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Peraturan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No./Tgl Ditetapkan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Uraian Singkat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dimuat Pada</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($data_peraturan as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $data_peraturan->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-800">{{ $item->judul }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $item->jenis_peraturan }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <div class="font-medium">{{ $item->nomor_ditetapkan }}</div>
                                <div class="text-xs text-gray-400">{{ $item->tanggal_ditetapkan ? $item->tanggal_ditetapkan->format('d M Y') : '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                {{ Str::limit($item->uraian_singkat, 50) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($item->is_aktif)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $item->dimuat_pada ? $item->dimuat_pada->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.show', $item->id) }}" 
                                       class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.edit', $item->id) }}" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button type="button" @click="$dispatch('buka-modal-hapus', {
                                            action: '{{ route('admin.buku-administrasi.umum.peraturan-desa.destroy', $item->id) }}',
                                            nama: '{{ addslashes($item->judul) }}'
                                        })" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum Ada Data</p>
                                    <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Data" untuk menambahkan peraturan desa baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($data_peraturan->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    @if($data_peraturan->total() > 0)
                        Menampilkan <span class="font-medium">{{ $data_peraturan->firstItem() }}</span> 
                        sampai <span class="font-medium">{{ $data_peraturan->lastItem() }}</span> 
                        dari <span class="font-medium">{{ $data_peraturan->total() }}</span> entri
                    @else
                        Tidak ada data untuk ditampilkan
                    @endif
                </div>
                <div>
                    {{ $data_peraturan->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Script -->
    <script>
        function deleteItem(id, title) {
            if (confirm(`Apakah Anda yakin ingin menghapus peraturan:\n"${title}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.buku-administrasi.umum.peraturan-desa.index") }}/' + id;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

@endsection

