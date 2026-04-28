    @extends('layouts.admin')

    @section('title', 'Impor Data Penduduk')

    @section('content')

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Impor Data Penduduk</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Import data penduduk dari file Excel</p>
            </div>
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('admin.penduduk') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Data Penduduk
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Impor Penduduk</span>
            </nav>
        </div>

        {{-- MODAL PERINGATAN (Alpine JS) --}}
        <div x-data="{ showWarning: false, formEl: null }" @keydown.escape.window="showWarning = false">

            {{-- Overlay --}}
            <div x-show="showWarning" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="showWarning = false" style="display:none"></div>

            {{-- Dialog Peringatan --}}
            <div x-show="showWarning" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md text-center px-8 py-8"
                    @click.stop>
                    {{-- Ikon Peringatan --}}
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 rounded-full border-4 border-amber-400 flex items-center justify-center">
                            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 dark:text-slate-100 mb-3">Peringatan</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed mb-6">
                        Fitur impor hanya akan memperbaharui data penduduk yang sudah ada saja. Dan tidak akan menambah data
                        penduduk baru. Jika akan menambah data baru, ganti status data penduduk menjadi tidak lengkap.
                    </p>

                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="showWarning = false"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="button" @click="showWarning = false; $nextTick(() => formEl && formEl.submit())"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            </div>

            {{-- CARD UTAMA --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">


                {{-- Tombol Kembali --}}
                <div class="px-6 pt-6 pb-4 border-b border-gray-100 dark:border-slate-700">
                    <a href="{{ route('admin.penduduk') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali Ke Data Penduduk
                    </a>
                </div>

                <div class="px-6 py-6 space-y-5">

                    {{-- Peringatan Penting --}}
                    <div
                        class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg">
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-1">
                            ⚠️ Penting: fitur ini tidak dimaksudkan untuk Restore data penduduk dan Mengubah struktur dan
                            keanggotaan keluarga
                        </p>
                        <p class="text-sm text-amber-700 dark:text-amber-400">
                            Fitur ini dimaksudkan untuk memasukkan data penduduk awal dan data susulan serta mengubah data
                            penduduk yang sudah ada secara masal
                        </p>
                    </div>

                    {{-- Panduan Mempersiapkan Data --}}
                    <div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 mb-3">
                            Mempersiapkan data dengan bentuk excel untuk Impor ke dalam database SID :
                        </h3>
                        <ol class="list-decimal list-outside ml-5 space-y-2 text-sm text-gray-600 dark:text-slate-300">
                            <li>
                                Pastikan format data yang akan diImpor sudah sesuai dengan aturan Impor data:
                                <ul class="list-disc list-outside ml-5 mt-1.5 space-y-1 text-gray-500 dark:text-slate-400">
                                    <li>Boleh menggunakan tanda ' (petik satu) dalam penggunaan nama</li>
                                    <li>Kolom Nama, Dusun, RW, RT dan NIK harus diisi. Tanda '-' bisa dipakai di mana RW
                                        atau RT
                                        tidak diketahui atau tidak ada</li>
                                    <li>Data Penduduk yang dapat menampilkan data RT/RW/Dusun pada tabel Kependudukan adalah
                                        Status Hubungan Dalam Keluarga = Kepala Keluarga atau penduduk yang memiliki Kepala
                                        Keluarga</li>
                                    <li>NIK harus bilangan dengan 16 angka atau 0 untuk menunjukkan belum ada NIK</li>
                                    <li>Kolom NIK merupakan data identitas wajib yang harus diisi</li>
                                    <li>Nama, Nama Ayah dan Nama Ibu harus huruf/sesuai validasi input nama</li>
                                    <li>Kolom Nama, Nama Ayah dan Nama Ibu merupakan data identitas wajib yang harus diisi
                                    </li>
                                    <li>Tanggal Lahir harus berupa tanggal</li>
                                    <li>Kolom Tanggal Lahir merupakan data identitas wajib yang harus diisi</li>
                                    <li>Kolom PASPORT dan KITAS harus diisi. Tanda '-' bisa dipakai di mana PASPORT atau
                                        KITAS
                                        tidak diketahui atau tidak ada</li>
                                    <li>Selain data identitas wajib (NIK), kolom data tidak harus terurut ataupun lengkap.
                                        Sebagai contoh, dapat digunakan untuk mengubah nomor telepon saja secara masal</li>
                                    <li>Data penduduk baru yang ditambah juga wajib berisi Nama, No KK, SHDK (status
                                        hubungan
                                        dalam keluarga), Alamat, Dusun, RW, RT, Jenis Kelamin, Tempat Lahir, Agama,
                                        Pendidikan,
                                        Pekerjaan, Golongan Darah, Status Kawin dan Kewarganegaraan</li>
                                    <li>Terdapat beberapa data yang terwakili dengan Kode Nomor yang dapat diisi dengan kode
                                        nomor ataupun tulisan seperti Jenis Kelamin, SHDK, Agama, Pendidikan, Pekerjaan,
                                        Golongan Darah, Status Kawin dan Kewarganegaraan. Selengkapnya dapat dilihat pada
                                        berkas
                                        <strong>Aturan dan contoh format</strong>
                                    </li>
                                    <li><strong>Penduduk baru tidak dapat ditambahkan apabila data dinyatakan sudah
                                            lengkap</strong></li>
                                </ul>
                            </li>
                            <li>Simpan (Save) berkas Excel sebagai .xlsx</li>
                            <li>Pastikan format excel ber-ekstensi .xlsx (format Excel versi 2007 ke atas)</li>
                            <li>
                                Data yang dibutuhkan untuk Impor dengan memenuhi urutan format dan aturan data pada tautan
                                di
                                bawah ini :
                                <div class="mt-2">
                                    <a href="{{ route('admin.penduduk.impor.template') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Aturan dan Contoh Format Data
                                    </a>
                                </div>
                            </li>
                        </ol>
                    </div>

                    {{-- Catatan Tambahan --}}
                    <div
                        class="p-3 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-600 dark:text-slate-300 space-y-1">
                        <p>Berkas pada tautan tersebut dapat dipergunakan untuk memasukkan data penduduk. Klik 'Enable
                            Macros'
                            pada waktu membuka berkas tersebut.</p>
                        <p>Batas maksimal pengunggahan berkas <strong>2 MB</strong></p>
                        <p>Proses ini akan membutuhkan waktu beberapa menit, menyesuaikan dengan spesifikasi komputer server
                            SID
                            dan sambungan internet yang tersedia.</p>
                    </div>

                    {{-- Form Upload --}}
                    <form id="form-impor-penduduk" x-ref="formImpor" method="POST"
                        action="{{ route('admin.penduduk.impor.proses') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="mode" value="skip">

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-slate-200 whitespace-nowrap">
                                Pilih File .xlsx:
                            </label>

                            <div class="flex items-center" x-data="{ fileName: '' }">
                                <input type="text" readonly :value="fileName || ''"
                                    placeholder="Belum ada file dipilih"
                                    class="w-64 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-l-lg bg-gray-50 dark:bg-slate-700 text-sm text-gray-600 dark:text-slate-300 cursor-default">

                                {{-- Ganti label jadi button --}}
                                <button type="button" @click="$refs.fileInput.click()"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-r-lg cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Browse
                                </button>

                                {{-- Input file dipisah, dipanggil via ref --}}
                                <input type="file" x-ref="fileInput" name="file_impor" accept=".xlsx"
                                    class="sr-only" tabindex="-1"
                                    @change="fileName = $event.target.files[0]?.name ?? ''">
                            </div>

                            {{-- Tombol → set formEl ke form INI (bukan form hidden) lalu tampilkan warning --}}
                            <button type="button" @click="formEl = $refs.formImpor; showWarning = true"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Impor Data Penduduk
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>{{-- /x-data peringatan --}}

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const fileInput = document.querySelector('input[type="file"][name="file_impor"]');
                    if (fileInput) {
                        fileInput.addEventListener('change', function() {
                            // Copy file ke hidden form
                            const dt = new DataTransfer();
                            if (this.files[0]) dt.items.add(this.files[0]);
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'file';
                            hiddenInput.name = 'file_impor';
                            // Approach lain: pakai satu form saja
                        });
                    }

                    // Patch: gunakan satu form saja, tombol trigger warning mengambil form utama
                    const mainForm = document.getElementById('form-impor-penduduk');
                    document.querySelectorAll('[\\@click]').forEach(function() {}); // handled by Alpine
                });
            </script>
        @endpush

    @endsection
