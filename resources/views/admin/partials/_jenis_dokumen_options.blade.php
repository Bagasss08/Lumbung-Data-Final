{{-- 
    Partial: _jenis_dokumen_options.blade.php 
    Lokasi: resources/views/admin/partials/_jenis_dokumen_options.blade.php 
    Dipakai di: penduduk-dokumen.blade.php (modal Tambah & Edit) 
--}}
<option value="">-- Pilih Jenis Dokumen --</option>
<option value="Surat Pengantar RT/RW"                 {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat Pengantar RT/RW') ? 'selected' : '' }}>Surat Pengantar RT/RW</option>
<option value="Fotokopi KK"                           {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Fotokopi KK') ? 'selected' : '' }}>Fotokopi KK</option>
<option value="Fotokopi Surat Nikah/Akta Nikah/Kutipan Akta Perkawinan" {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Fotokopi Surat Nikah/Akta Nikah/Kutipan Akta Perkawinan') ? 'selected' : '' }}>Fotokopi Surat Nikah/Akta Nikah/Kutipan Akta Perkawinan</option>
<option value="Fotokopi Akta Kelahiran/Surat Kelahiran bagi keluarga yang mempunyai anak" {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Fotokopi Akta Kelahiran/Surat Kelahiran bagi keluarga yang mempunyai anak') ? 'selected' : '' }}>Fotokopi Akta Kelahiran/Surat Kelahiran bagi keluarga yang mempunyai anak</option>
<option value="Surat Pindah Datang dari tempat asal"  {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat Pindah Datang dari tempat asal') ? 'selected' : '' }}>Surat Pindah Datang dari tempat asal</option>
<option value="Surat Keterangan Kematian dari Rumah Sakit, Rumah Bersalin Puskesmas, atau visum Dokter" {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat Keterangan Kematian dari Rumah Sakit, Rumah Bersalin Puskesmas, atau visum Dokter') ? 'selected' : '' }}>Surat Keterangan Kematian dari Rumah Sakit, Rumah Bersalin Puskesmas, atau visum Dokter</option>
<option value="Surat Keterangan Cerai"                {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat Keterangan Cerai') ? 'selected' : '' }}>Surat Keterangan Cerai</option>
<option value="Fotokopi Ijasah Terakhir"              {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Fotokopi Ijasah Terakhir') ? 'selected' : '' }}>Fotokopi Ijasah Terakhir</option>
<option value="SK. PNS/KARIP/SK. TNI – POLRI"         {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'SK. PNS/KARIP/SK. TNI – POLRI') ? 'selected' : '' }}>SK. PNS/KARIP/SK. TNI – POLRI</option>
<option value="Surat Keterangan Kematian dari Kepala Desa/Kelurahan" {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat Keterangan Kematian dari Kepala Desa/Kelurahan') ? 'selected' : '' }}>Surat Keterangan Kematian dari Kepala Desa/Kelurahan</option>
<option value="Surat imigrasi / STMD (Surat Tanda Melapor Diri)" {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Surat imigrasi / STMD (Surat Tanda Melapor Diri)') ? 'selected' : '' }}>Surat imigrasi / STMD (Surat Tanda Melapor Diri)</option>
<option value="Lain-lain"                             {{ (old('jenis_dokumen', $selectedJenis ?? '') == 'Lain-lain') ? 'selected' : '' }}>Lain-lain</option>
