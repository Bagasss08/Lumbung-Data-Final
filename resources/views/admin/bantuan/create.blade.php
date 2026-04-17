@extends('layouts.admin')

@section('title', 'Tambah Program Bantuan')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Program Bantuan</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Tambahkan program baru dengan data yang lengkap.</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm text-gray-400 dark:text-slate-500">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.bantuan.index') }}"
                class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Daftar Program Bantuan</a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

        <div
            class="px-5 py-5 border-b border-gray-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-semibold text-gray-700 dark:text-slate-200">Form Tambah Program Bantuan</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Isi detail program bantuan yang akan
                    ditayangkan.</p>
            </div>
            <a href="{{ route('admin.bantuan.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="p-6" x-data="{
            nama: '{{ addslashes(old('nama', $bantuan->nama ?? '')) }}',
            sasaran: '{{ old('sasaran', $bantuan->sasaran ?? '') }}',
            sasaranLabel: '{{ old('sasaran', $bantuan->sasaran ?? '') == 1 ? 'Penduduk' : (old('sasaran', $bantuan->sasaran ?? '') == 2 ? 'Keluarga' : '') }}',
            sasaranOpen: false,
            sasaranSearch: '',
            sasaranOptions: [
                { value: '1', label: 'Penduduk' },
                { value: '2', label: 'Keluarga' },
            ],
            asalDana: '{{ addslashes(old('asal_dana', $bantuan->asal_dana ?? '')) }}',
            asalDanaLabel: '{{ addslashes(old('asal_dana', $bantuan->asal_dana ?? '')) }}',
            asalDanaOpen: false,
            asalDanaSearch: '',
            asalDanaOptions: [
                { value: 'Pusat', label: 'Pusat' },
                { value: 'Provinsi', label: 'Provinsi' },
                { value: 'Kab/Kota', label: 'Kab/Kota' },
                { value: 'Dana Desa', label: 'Dana Desa' },
                { value: 'Lain-lain (Hibah)', label: 'Lain-lain (Hibah)' },
            ],
            publikasi: '{{ old('publikasi', $bantuan->publikasi ?? '1') }}',
            publikasiLabel: '{{ old('publikasi', '1') == '0' ? 'Tidak Aktif' : 'Aktif' }}',
            publikasiOpen: false,
            publikasiSearch: '',
            publikasiOptions: [
                { value: '1', label: 'Aktif' },
                { value: '0', label: 'Tidak Aktif' },
            ],
            tanggalMulai: '{{ old('tanggal_mulai', date('Y-m-d')) }}',
            tanggalSelesai: '{{ old('tanggal_selesai', date('Y-m-d')) }}',
            status: '{{ old('status', $bantuan->status ?? '1') }}',
            errors: {},
            get filteredSasaran() {
                if (!this.sasaranSearch) return this.sasaranOptions;
                return this.sasaranOptions.filter(o => o.label.toLowerCase().includes(this.sasaranSearch.toLowerCase()));
            },
            get filteredAsalDana() {
                if (!this.asalDanaSearch) return this.asalDanaOptions;
                return this.asalDanaOptions.filter(o => o.label.toLowerCase().includes(this.asalDanaSearch.toLowerCase()));
            },
            get filteredPublikasi() {
                if (!this.publikasiSearch) return this.publikasiOptions;
                return this.publikasiOptions.filter(o => o.label.toLowerCase().includes(this.publikasiSearch.toLowerCase()));
            },
            chooseSasaran(opt) {
                this.sasaran = opt.value;
                this.sasaranLabel = opt.label;
                this.sasaranOpen = false;
                this.sasaranSearch = '';
                this.errors.sasaran = null;
            },
            chooseAsalDana(opt) {
                this.asalDana = opt.value;
                this.asalDanaLabel = opt.label;
                this.asalDanaOpen = false;
                this.asalDanaSearch = '';
            },
            choosePublikasi(opt) {
                this.publikasi = opt.value;
                this.publikasiLabel = opt.label;
                this.publikasiOpen = false;
                this.publikasiSearch = '';
            },
            validate() {
                this.errors = {};
                if (!this.nama || !this.nama.trim()) {
                    this.errors.nama = 'Nama program wajib diisi.';
                }
                if (!this.sasaran) {
                    this.errors.sasaran = 'Sasaran program wajib dipilih.';
                }
                return Object.keys(this.errors).length === 0;
            },
            handleSubmit() {
                if (this.validate()) {
                    $refs.form.submit();
                }
            }
        }">
            <form x-ref="form" @submit.prevent="handleSubmit()" action="{{ route('admin.bantuan.store') }}"
                method="POST">
                @csrf
                @include('admin.bantuan._form')

                {{-- Ganti blok tombol aksi --}}
                <div class="mt-6 flex flex-col sm:flex-row sm:justify-between gap-3">
                    <a href="{{ route('admin.bantuan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
