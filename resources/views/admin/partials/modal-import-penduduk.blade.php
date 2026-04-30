{{--
PARTIAL: resources/views/admin/partials/modal-import-penduduk.blade.php

CARA PAKAI — include sekali di halaman penduduk:
@include('admin.partials.modal-import-penduduk')

CARA TRIGGER dari tombol:
<button type="button" @click="$dispatch('buka-modal-import')">Import Data</button>
--}}

{{-- ============================================================
     FLASH: Ringkasan hasil import + error baris
     Letakkan ini di luar modal agar tetap terlihat setelah redirect
     ============================================================ --}}
@if (session('success') || session('import_summary') || $errors->has('file') || $errors->has('import_rows'))
    <div x-data="{ open: true }" x-show="open" x-transition
        class="fixed bottom-4 right-4 z-[60] w-full max-w-sm space-y-2">

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="flex items-start gap-3 bg-white border border-emerald-200 rounded-xl shadow-lg p-4">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">Import Berhasil</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- Ringkasan + error baris (sebagian gagal) --}}
        @if (session('import_summary'))
            <div class="bg-white border border-amber-200 rounded-xl shadow-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">Import Selesai (dengan peringatan)</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ session('import_summary') }}</p>
                    </div>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('import_rows'))
                    <div class="mt-3 max-h-40 overflow-y-auto space-y-1 pl-11">
                        @foreach ($errors->get('import_rows') as $rowErrors)
                            @foreach ((array) $rowErrors as $msg)
                                <p class="text-xs text-amber-700 bg-amber-50 rounded px-2 py-1">⚠ {{ $msg }}</p>
                            @endforeach
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- Error validasi file (format tidak sesuai / upload gagal) --}}
        @if ($errors->has('file'))
            <div x-data="{ showModal: true }" x-init="$dispatch('buka-modal-import')"
                class="bg-white border border-red-200 rounded-xl shadow-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">Import Gagal</p>
                        @foreach ($errors->get('file') as $msg)
                            <p class="text-xs text-red-600 mt-0.5">{{ $msg }}</p>
                        @endforeach
                    </div>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
@endif

{{-- ============================================================
     MODAL IMPORT
     ============================================================ --}}
<div x-data="{
        show: false,
        fileName: '',
        dragging: false,
        loading: false,
    }" @buka-modal-import.window="show = true" x-show="show" x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="show = false"></div>

    {{-- Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Import Data Penduduk</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Upload file Excel atau CSV</p>
                </div>
            </div>
            <button type="button" @click="show = false"
                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <form action="{{ route('admin.penduduk.import') }}" method="POST" enctype="multipart/form-data"
            class="px-6 py-5 space-y-4" @submit="loading = true">
            @csrf

            {{-- Mode Import --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Mode Import</label>
                <div class="grid grid-cols-2 gap-3">
                    <label
                        class="relative flex items-start gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                        <input type="radio" name="mode" value="skip" checked class="mt-0.5 accent-emerald-600">
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Lewati Duplikat</p>
                            <p class="text-xs text-gray-500 mt-0.5">NIK yang sudah ada dilewati</p>
                        </div>
                    </label>
                    <label
                        class="relative flex items-start gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-amber-300 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                        <input type="radio" name="mode" value="overwrite" class="mt-0.5 accent-amber-600">
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Timpa Data</p>
                            <p class="text-xs text-gray-500 mt-0.5">NIK yang sama diperbarui</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Drop Zone --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Pilih File</label>
                <label for="import-file-upload"
                    class="flex flex-col items-center justify-center gap-2 w-full px-4 py-8 border-2 border-dashed rounded-xl cursor-pointer transition-colors"
                    :class="dragging ? 'border-emerald-400 bg-emerald-50' : 'border-gray-300 hover:border-emerald-400 hover:bg-gray-50'"
                    @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false" @drop.prevent="
                        dragging = false;
                        const f = $event.dataTransfer.files[0];
                        if (f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                    ">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-center">
                        <p class="text-sm font-medium text-emerald-600" x-text="fileName || 'Klik untuk pilih file'">
                        </p>
                        <p class="text-xs text-gray-400 mt-1">atau drag & drop di sini</p>
                        <p class="text-xs text-gray-400">CSV, XLS, XLSX — maks. 10 MB</p>
                    </div>
                    <input id="import-file-upload" x-ref="fileInput" name="file" type="file" accept=".csv,.xls,.xlsx"
                        required class="sr-only" @change="fileName = $event.target.files[0]?.name || ''">
                </label>

                {{-- Error file --}}
                @error('file')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Info + Template --}}
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <p class="text-xs text-blue-800">Pastikan format file sesuai template. Kolom wajib:</p>
                    <p class="text-xs text-blue-700 font-mono mt-0.5 leading-relaxed">
                        nik · nama · jenis_kelamin · tempat_lahir · tanggal_lahir · agama · shdk · warganegaraan ·
                        golongan_darah · nama_ayah · nama_ibu · dusun · rw · rt · status_kawin
                    </p>
                    <a href="{{ route('admin.penduduk.template') }}"
                        class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-blue-700 hover:text-blue-900 underline underline-offset-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Template Excel
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="button" @click="show = false" :disabled="loading"
                    class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors disabled:opacity-50">
                    Batal
                </button>
                <button type="submit" :disabled="loading"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-400 text-white rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <template x-if="!loading">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                    </template>
                    <template x-if="loading">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4z"></path>
                        </svg>
                    </template>
                    <span x-text="loading ? 'Memproses...' : 'Import Data'"></span>
                </button>
            </div>
        </form>
    </div>
</div>