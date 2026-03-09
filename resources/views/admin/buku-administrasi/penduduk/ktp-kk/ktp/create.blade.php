@extends('layouts.admin')
@section('title', 'Tambah Data Penduduk')

@section('content')
    <div class="flex items-center gap-2 mb-1">
        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <p class="text-lg font-semibold text-gray-700">Tambah Data Penduduk</p>
    </div>
    <p class="text-sm text-gray-400 mb-6 ml-7">Isi form berikut untuk mendaftarkan penduduk baru</p>

    <form action="{{ route('admin.buku-administrasi.penduduk.ktp-kk.ktp.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">

            {{-- NIK & Nama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 @error('nik') border-red-400 @enderror"/>
                    @error('nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 @error('nama') border-red-400 @enderror"/>
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Tempat & Tgl Lahir --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"/>
                </div>
            </div>

            {{-- JK, Gol Darah, Agama --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
                    <select name="golongan_darah" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        @foreach(['A','B','AB','O','-'] as $gd)
                        <option value="{{ $gd }}" @selected(old('golongan_darah') === $gd)>{{ $gd }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                    <select name="agama" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $a)
                        <option value="{{ $a }}" @selected(old('agama') === $a)>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Pendidikan, Pekerjaan, Kewarganegaraan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <select name="pendidikan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        @foreach(['Tidak/Belum Sekolah','Belum Tamat SD','Tamat SD','SLTP','SLTA','Diploma','Sarjana','Pascasarjana'] as $p)
                        <option value="{{ $p }}" @selected(old('pendidikan') === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kewarganegaraan <span class="text-red-500">*</span></label>
                    <select name="kewarganegaraan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="WNI" @selected(old('kewarganegaraan','WNI') === 'WNI')>WNI</option>
                        <option value="WNA" @selected(old('kewarganegaraan') === 'WNA')>WNA</option>
                    </select>
                </div>
            </div>

            {{-- Status Kawin & Status Hidup --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Kawin <span class="text-red-500">*</span></label>
                    <select name="status_kawin" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        @foreach(['belum_kawin','kawin','cerai_hidup','cerai_mati'] as $s)
                        <option value="{{ $s }}" @selected(old('status_kawin') === $s)>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Hidup <span class="text-red-500">*</span></label>
                    <select name="status_hidup" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="hidup" @selected(old('status_hidup','hidup') === 'hidup')>Hidup</option>
                        <option value="meninggal" @selected(old('status_hidup') === 'meninggal')>Meninggal</option>
                    </select>
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">{{ old('alamat') }}</textarea>
            </div>

            {{-- Kontak --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500"/>
                </div>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.ktp.index') }}"
               class="px-5 py-2 text-sm border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg transition-colors">Simpan</button>
        </div>
    </form>
@endsection