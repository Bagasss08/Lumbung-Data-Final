@extends('layouts.admin')

@section('title', 'Pengaturan Surat')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Pengaturan Surat</h1>
                <p class="text-sm text-slate-500">Konfigurasi template dan pengaturan surat</p>
            </div>

            <button
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white text-sm font-bold rounded-xl shadow-md transition"
                onclick="openModal()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Template
            </button>
        </div>

        <!-- SETTINGS -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 mb-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Pengaturan Umum</h3>

            <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nomor Surat Otomatis</label>
                        <div class="flex items-center">
                            <input type="checkbox" id="auto-number"
                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 mr-2">
                            <label for="auto-number" class="text-sm text-slate-600">Aktifkan penomoran otomatis</label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Format Nomor Surat</label>
                        <input type="text" value="001/DS/2024"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Contoh: 001/DS/YYYY">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Tanda Tangan Default</label>
                        <select
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option>Kepala Desa</option>
                            <option>Sekretaris Desa</option>
                            <option>Kepala Urusan</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Footer Surat</label>
                        <textarea
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            rows="3"
                            placeholder="Teks footer surat">Demikian surat ini dibuat untuk dapat digunakan sebagaimana mestinya.</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Logo Desa</label>
                        <div class="flex items-center">
                            <input type="checkbox" id="show-logo"
                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 mr-2" checked>
                            <label for="show-logo" class="text-sm text-slate-600">Tampilkan logo desa di header</label>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Simpan
                            Pengaturan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TEMPLATE TABLE -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Template Surat</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Nama Template</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Kategori</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">File</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Status</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($templates) && $templates->count())
                            @foreach($templates as $t)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">{{ $t->nama_template }}</td>
                                <td class="py-3 px-4">{{ $t->jenis_surat ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.layanan-surat.downloadTemplate', $t->id) }}"
                                        target="_blank" class="text-sm text-emerald-600 hover:underline">{{
                                        $t->original_name }}</a>
                                </td>
                                <td class="py-3 px-4">
                                    @if($t->status)
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktif</span>
                                    @else
                                    <span
                                        class="px-2 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Non-aktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ Storage::url($t->path) }}" target="_blank"
                                            class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Download">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v9m0-9l-3 3m3-3l3 3M12 3v9" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="#"
                                            onsubmit="return confirm('Fitur hapus belum diaktifkan');">
                                            @csrf
                                            <button type="button" class="p-1 text-red-600 hover:bg-red-50 rounded"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="py-4 px-4 text-center text-slate-500">Belum ada template.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Tambah Template Surat</h3>

                <form method="POST" action="{{ route('admin.layanan-surat.storeTemplate') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Nama Template</label>
                            <input name="nama_template" type="text"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Masukkan nama template" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Kategori</label>
                            <select name="jenis_surat"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih kategori --</option>
                                <option value="Keterangan">Keterangan</option>
                                <option value="Pengantar">Pengantar</option>
                                <option value="Undangan">Undangan</option>
                                <option value="Kuasa">Kuasa</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Upload Template</label>
                            <input name="template_file" type="file"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                accept=".doc,.docx,.pdf" required>
                        </div>

                        <div class="flex items-center">
                            <input name="status" type="checkbox" id="status" value="1"
                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 mr-2" checked>
                            <label for="status" class="text-sm text-slate-600">Aktifkan template ini</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition"
                            onclick="closeModal()">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Simpan
                            Template</button>
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