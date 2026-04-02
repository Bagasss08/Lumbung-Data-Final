{{-- Modal Impor BIP --}}
<div x-data="{ show: false, fileName: '', dragging: false }" @buka-modal-import-bip.window="show = true" x-show="show" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="show = false"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Import BIP</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Upload file BIP (Excel/CSV)</p>
                </div>
            </div>
            <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.penduduk.import-bip') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Mode Import</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex items-start gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                        <input type="radio" name="mode" value="skip" checked class="mt-0.5 accent-emerald-600">
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Lewati Duplikat</p>
                            <p class="text-xs text-gray-500 mt-0.5">NIK BIP yang sudah ada dilewati</p>
                        </div>
                    </label>
                    <label class="relative flex items-start gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-amber-300 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                        <input type="radio" name="mode" value="overwrite" class="mt-0.5 accent-amber-600">
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Timpa Data</p>
                            <p class="text-xs text-gray-500 mt-0.5">NIK BIP yang sama diperbarui</p>
                        </div>
                    </label>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Pilih File BIP</label>
                <label for="bip-file" class="flex flex-col items-center justify-center gap-2 w-full px-4 py-8 border-2 border-dashed rounded-xl cursor-pointer transition-colors" :class="dragging ? 'border-emerald-400 bg-emerald-50' : 'border-gray-300 hover:border-emerald-400 hover:bg-gray-50'" @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false" @drop.prevent="dragging = false; const f = $event.dataTransfer.files[0]; if (f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-center">
                        <p class="text-sm font-medium text-emerald-600" x-text="fileName || 'Klik untuk pilih file'"></p>
                        <p class="text-xs text-gray-400 mt-1">atau drag & drop di sini</p>
                        <p class="text-xs text-gray-400">CSV, XLS, XLSX — maks. 10 MB</p>
                    </div>
                    <input id="bip-file" x-ref="fileInput" name="file" type="file" accept=".csv,.xls,.xlsx" required class="sr-only" @change="fileName = $event.target.files[0]?.name || ''">
                </label>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" @click="show = false" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Import BIP
                </button>
            </div>
        </form>
    </div>
</div>
