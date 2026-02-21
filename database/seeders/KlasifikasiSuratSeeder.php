<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KlasifikasiSurat;

class KlasifikasiSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $klasifikasiSurat = [
            [
                'kode' => '001',
                'nama_klasifikasi' => 'Surat Keterangan Domisili',
                'kategori' => 'kependudukan',
                'retensi_aktif' => 5,
                'retensi_inaktif' => 10,
                'status' => true,
                'keterangan' => 'Surat keterangan tempat tinggal penduduk',
            ],
            [
                'kode' => '002',
                'nama_klasifikasi' => 'Surat Keterangan Lahir',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan kelahiran penduduk',
            ],
            [
                'kode' => '003',
                'nama_klasifikasi' => 'Surat Keterangan Meninggal',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan kematian penduduk',
            ],
            [
                'kode' => '004',
                'nama_klasifikasi' => 'Surat Keterangan Pindah',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan pindah penduduk',
            ],
            [
                'kode' => '005',
                'nama_klasifikasi' => 'Surat Keterangan Usaha',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan usaha penduduk',
            ],
            [
                'kode' => '006',
                'nama_klasifikasi' => 'Surat Keterangan Tidak Mampu',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan tidak mampu untuk bantuan',
            ],
            [
                'kode' => '007',
                'nama_klasifikasi' => 'Surat Keterangan Belum Menikah',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan status belum menikah',
            ],
            [
                'kode' => '008',
                'nama_klasifikasi' => 'Surat Keterangan Janda/Duda',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan status janda atau duda',
            ],
            [
                'kode' => '009',
                'nama_klasifikasi' => 'Surat Keterangan Ahli Waris',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan ahli waris',
            ],
            [
                'kode' => '010',
                'nama_klasifikasi' => 'Surat Keterangan Pengantar Nikah',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat pengantar untuk pernikahan',
            ],
            [
                'kode' => '011',
                'nama_klasifikasi' => 'Surat Keterangan Izin Keramaian',
                'kategori' => 'administrasi',
                'retensi_aktif' => '3 tahun',
                'retensi_inaktif' => '5 tahun',
                'status' => true,
                'keterangan' => 'Surat izin penyelenggaraan keramaian',
            ],
            [
                'kode' => '012',
                'nama_klasifikasi' => 'Surat Keterangan Izin Mendirikan Bangunan',
                'kategori' => 'pembangunan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat izin mendirikan bangunan',
            ],
            [
                'kode' => '013',
                'nama_klasifikasi' => 'Surat Keterangan Rekomendasi Bantuan',
                'kategori' => 'keuangan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat rekomendasi untuk mendapatkan bantuan',
            ],
            [
                'kode' => '014',
                'nama_klasifikasi' => 'Surat Keterangan Penghasilan',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan penghasilan penduduk',
            ],
            [
                'kode' => '015',
                'nama_klasifikasi' => 'Surat Keterangan Kematian',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan kematian penduduk',
            ],
            [
                'kode' => '016',
                'nama_klasifikasi' => 'Surat Keterangan Kehilangan',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan kehilangan barang',
            ],
            [
                'kode' => '017',
                'nama_klasifikasi' => 'Surat Keterangan Bersih Diri',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan bersih diri dari narkoba',
            ],
            [
                'kode' => '018',
                'nama_klasifikasi' => 'Surat Keterangan Catatan Kepolisian',
                'kategori' => 'kependudukan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan catatan kepolisian',
            ],
            [
                'kode' => '019',
                'nama_klasifikasi' => 'Surat Keterangan Izin Usaha',
                'kategori' => 'keuangan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat izin usaha mikro',
            ],
            [
                'kode' => '020',
                'nama_klasifikasi' => 'Surat Keterangan Tanah',
                'kategori' => 'pembangunan',
                'retensi_aktif' => '5 tahun',
                'retensi_inaktif' => '10 tahun',
                'status' => true,
                'keterangan' => 'Surat keterangan status tanah',
            ],
        ];

        foreach ($klasifikasiSurat as $data) {
            KlasifikasiSurat::create($data);
        }
    }
}
