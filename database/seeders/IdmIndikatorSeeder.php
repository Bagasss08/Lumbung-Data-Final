<?php

namespace Database\Seeders;

use App\Models\IdmIndikator;
use Illuminate\Database\Seeder;

class IdmIndikatorSeeder extends Seeder
{
    /**
     * 60 Indikator IDM resmi (Kemendes PDTT).
     * * Cara menjalankan:
     * TAHUN=2025 php artisan db:seed --class=IdmIndikatorSeeder
     */

    private int $tahun;

    public function run(): void
    {
        // Mengambil tahun dari env 'TAHUN', default ke tahun sekarang jika tidak diisi
        $envTahun = getenv('TAHUN');
        $this->tahun = $envTahun ? (int)$envTahun : (int)date('Y');

        // Proteksi duplikasi data tahun yang sama
        if (IdmIndikator::where('tahun', $this->tahun)->exists()) {
            if ($this->command) {
                $this->command->warn("Data IDM tahun {$this->tahun} sudah ada, seeder dilewati.");
            }
            return;
        }

        $indikator = $this->dataIndikator();

        foreach ($indikator as $row) {
            IdmIndikator::create(array_merge($row, [
                'tahun' => $this->tahun,
                'skor'  => 0,
            ]));
        }

        if ($this->command) {
            $this->command->info("✔ Berhasil! " . count($indikator) . " indikator IDM tahun {$this->tahun} telah dimasukkan.");
        }
    }

    private function dataIndikator(): array
    {
        return [
            // ════════════════════════════════════════════════
            // IKS – Indeks Ketahanan Sosial (30 indikator)
            // ════════════════════════════════════════════════
            ['no_urut' => 1, 'dimensi' => 'IKS', 'nama_indikator' => 'Pelayanan Kesehatan (Polindes/Poskesdes/Posbindu)', 'keterangan' => 'Ketersediaan dan akses warga ke pos pelayanan kesehatan desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembangunan/revitalisasi Polindes, Poskesdes, atau Posbindu.'],
            ['no_urut' => 2, 'dimensi' => 'IKS', 'nama_indikator' => 'Pelayanan Kesehatan (Puskesmas/Klinik)', 'keterangan' => 'Ketersediaan dan akses warga ke puskesmas atau klinik.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Advokasi pembangunan puskesmas/klinik atau perbaikan akses jalan.'],
            ['no_urut' => 3, 'dimensi' => 'IKS', 'nama_indikator' => 'Tenaga Kesehatan (Dokter/Bidan/Perawat)', 'keterangan' => 'Ketersediaan tenaga medis yang menetap atau rutin berpraktik.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Koordinasi Dinas Kesehatan untuk penempatan nakes.'],
            ['no_urut' => 4, 'dimensi' => 'IKS', 'nama_indikator' => 'Keberfungsian Posyandu', 'keterangan' => 'Posyandu aktif melayani gizi, imunisasi, dan tumbuh kembang.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Revitalisasi posyandu, pelatihan kader, dan penyediaan PMT.'],
            ['no_urut' => 5, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Air Bersih dan Air Minum Layak', 'keterangan' => 'Persentase rumah tangga mengakses sumber air minum layak.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembangunan sarana air bersih, sumur bor, atau pipanisasi.'],
            ['no_urut' => 6, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Sanitasi Layak (Jamban Keluarga)', 'keterangan' => 'Persentase rumah tangga memiliki dan menggunakan jamban layak.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program STBM, bantuan jamban, dan sosialisasi PHBS.'],
            ['no_urut' => 7, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Listrik', 'keterangan' => 'Persentase rumah tangga yang memiliki akses listrik.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Koordinasi PLN atau pembangunan energi terbarukan (PLTS).'],
            ['no_urut' => 8, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Informasi dan Komunikasi (Telepon/Internet)', 'keterangan' => 'Persentase rumah tangga akses telepon seluler atau internet.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Fasilitasi tower BTS, wifi desa, atau titik internet publik.'],
            ['no_urut' => 9, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan dan Akses ke PAUD/TK', 'keterangan' => 'Ketersediaan lembaga PAUD/TK dalam jangkauan desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pendirian PAUD/TK desa atau bantuan operasional.'],
            ['no_urut' => 10, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan dan Akses ke SD/MI', 'keterangan' => 'Ketersediaan SD/MI dalam jangkauan desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Fasilitasi antar-jemput siswa atau perbaikan akses jalan sekolah.'],
            ['no_urut' => 11, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan dan Akses ke SMP/MTs', 'keterangan' => 'Ketersediaan SMP/MTs dalam jangkauan desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Bantuan beasiswa atau transportasi siswa menengah pertama.'],
            ['no_urut' => 12, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan dan Akses ke SMA/MA/SMK', 'keterangan' => 'Ketersediaan SMA/MA/SMK dalam jangkauan desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Advokasi pendirian SMA atau fasilitas asrama siswa.'],
            ['no_urut' => 13, 'dimensi' => 'IKS', 'nama_indikator' => 'Pendidikan Kesetaraan (Paket A/B/C)', 'keterangan' => 'Ketersediaan program Kejar Paket di desa atau PKBM.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembentukan/aktivasi PKBM desa.'],
            ['no_urut' => 14, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Pengetahuan (Taman Baca/Perpustakaan)', 'keterangan' => 'Keberadaan perpustakaan desa atau taman baca aktif.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembangunan perpustakaan desa dan pengadaan koleksi buku.'],
            ['no_urut' => 15, 'dimensi' => 'IKS', 'nama_indikator' => 'Solidaritas Sosial (Gotong Royong)', 'keterangan' => 'Tingkat partisipasi warga dalam kegiatan keswadayaan.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program pemberdayaan masyarakat dan penguatan RT/RW.'],
            ['no_urut' => 16, 'dimensi' => 'IKS', 'nama_indikator' => 'Toleransi dan Kerukunan Sosial', 'keterangan' => 'Kondisi kerukunan antarwarga dan antarkelompok.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Forum dialog warga dan kegiatan budaya bersama.'],
            ['no_urut' => 17, 'dimensi' => 'IKS', 'nama_indikator' => 'Rasa Aman Warga (Keamanan)', 'keterangan' => 'Tingkat keamanan dan ketertiban umum di desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Penguatan LINMAS, siskamling, dan pembangunan pos ronda.'],
            ['no_urut' => 18, 'dimensi' => 'IKS', 'nama_indikator' => 'Kesejahteraan Sosial (Penerima Bansos)', 'keterangan' => 'Cakupan warga penerima program bantuan sosial.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pemutakhiran data DTKS agar bantuan tepat sasaran.'],
            ['no_urut' => 19, 'dimensi' => 'IKS', 'nama_indikator' => 'Penyandang Masalah Kesejahteraan Sosial (PMKS)', 'keterangan' => 'Penanganan lansia, difabel, dan anak terlantar.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program perlindungan sosial dan pendataan PMKS.'],
            ['no_urut' => 20, 'dimensi' => 'IKS', 'nama_indikator' => 'Jaminan Sosial Kesehatan (JKN/KIS)', 'keterangan' => 'Cakupan warga yang memiliki jaminan kesehatan.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Fasilitasi kepesertaan JKN dan sosialisasi KIS.'],
            ['no_urut' => 21, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses ke Pelayanan Pemerintahan', 'keterangan' => 'Kemudahan warga mengakses layanan adminduk.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Digitalisasi layanan desa dan peningkatan kapasitas perangkat.'],
            ['no_urut' => 22, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan Permukiman Layak', 'keterangan' => 'Persentase rumah layak huni di desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program RTLH (Rehabilitasi Rumah Tidak Layak Huni).'],
            ['no_urut' => 23, 'dimensi' => 'IKS', 'nama_indikator' => 'Kesehatan Masyarakat – Gizi (Stunting)', 'keterangan' => 'Angka prevalensi stunting balita di desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program konvergensi stunting dan penguatan PMT.'],
            ['no_urut' => 24, 'dimensi' => 'IKS', 'nama_indikator' => 'Kesehatan Masyarakat – Kematian Bayi', 'keterangan' => 'Angka kematian bayi dan ibu melahirkan.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Penguatan ANC terpadu dan kemitraan bidan desa.'],
            ['no_urut' => 25, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan Tempat Ibadah', 'keterangan' => 'Ketersediaan tempat ibadah yang memadai.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Rehabilitasi atau pembangunan sarana ibadah.'],
            ['no_urut' => 26, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan Fasilitas Olahraga', 'keterangan' => 'Ketersediaan lapangan atau fasilitas olahraga.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembangunan lapangan olahraga multifungsi.'],
            ['no_urut' => 27, 'dimensi' => 'IKS', 'nama_indikator' => 'Ketersediaan Ruang Publik/Taman', 'keterangan' => 'Ketersediaan ruang terbuka publik/taman bermain.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pembangunan taman desa atau Alun-alun desa.'],
            ['no_urut' => 28, 'dimensi' => 'IKS', 'nama_indikator' => 'Keberadaan Kelompok Kegiatan Masyarakat', 'keterangan' => 'Keaktifan PKK, Karang Taruna, dan LPMD.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Penguatan kapasitas organisasi kemasyarakatan desa.'],
            ['no_urut' => 29, 'dimensi' => 'IKS', 'nama_indikator' => 'Akses Tenaga Kerja ke Luar Desa', 'keterangan' => 'Kemudahan warga mengakses pasar kerja luar desa.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Pelatihan keterampilan kerja dan info bursa kerja.'],
            ['no_urut' => 30, 'dimensi' => 'IKS', 'nama_indikator' => 'Penanganan Warga Miskin Ekstrem', 'keterangan' => 'Upaya desa mengentaskan kemiskinan ekstrem.', 'nilai_tambah' => 0.00666667, 'kegiatan_dilakukan' => 'Program BLT-DD dan Padat Karya Tunai Desa.'],

            // ════════════════════════════════════════════════
            // IKE – Indeks Ketahanan Ekonomi (15 indikator)
            // ════════════════════════════════════════════════
            ['no_urut' => 31, 'dimensi' => 'IKE', 'nama_indikator' => 'Keragaman Produksi Masyarakat Desa', 'keterangan' => 'Variasi jenis produk/komoditas ekonomi warga.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Diversifikasi usaha dan pengembangan produk lokal.'],
            ['no_urut' => 32, 'dimensi' => 'IKE', 'nama_indikator' => 'Pusat Pelayanan Perdagangan (Pasar)', 'keterangan' => 'Keberadaan pasar desa atau pusat perdagangan aktif.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan atau revitalisasi pasar desa.'],
            ['no_urut' => 33, 'dimensi' => 'IKE', 'nama_indikator' => 'Akses Distribusi/Logistik', 'keterangan' => 'Kemudahan distribusi produk desa ke pasar.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Perbaikan jalan lingkungan dan fasilitasi logistik.'],
            ['no_urut' => 34, 'dimensi' => 'IKE', 'nama_indikator' => 'Akses Lembaga Keuangan (Bank/BUMDes)', 'keterangan' => 'Ketersediaan lembaga keuangan formal di desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Penguatan permodalan BUMDes.'],
            ['no_urut' => 35, 'dimensi' => 'IKE', 'nama_indikator' => 'Lembaga Ekonomi (Koperasi/Poktan)', 'keterangan' => 'Keberfungsian koperasi atau kelompok tani.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pelatihan manajemen koperasi dan kelompok tani.'],
            ['no_urut' => 36, 'dimensi' => 'IKE', 'nama_indikator' => 'Keterbukaan Wilayah (Jalan Utama)', 'keterangan' => 'Kondisi aksesibilitas jalan utama penghubung desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Peningkatan jalan desa menjadi aspal/beton.'],
            ['no_urut' => 37, 'dimensi' => 'IKE', 'nama_indikator' => 'Aksesibilitas Transportasi', 'keterangan' => 'Ketersediaan moda transportasi umum di desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Fasilitasi trayek angkutan pedesaan.'],
            ['no_urut' => 38, 'dimensi' => 'IKE', 'nama_indikator' => 'Aktivitas Usaha Ekonomi Produktif', 'keterangan' => 'Tingkat keaktifan UMKM oleh warga desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Bantuan alat produksi bagi kelompok usaha.'],
            ['no_urut' => 39, 'dimensi' => 'IKE', 'nama_indikator' => 'Fasilitas Energi (BBM/Agen)', 'keterangan' => 'Ketersediaan akses bahan bakar dan energi.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan Pertashop atau pangkalan gas desa.'],
            ['no_urut' => 40, 'dimensi' => 'IKE', 'nama_indikator' => 'Potensi dan Kapasitas Pariwisata', 'keterangan' => 'Keberadaan dan pengelolaan potensi wisata.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pengembangan sarpras wisata dan Pokdarwis.'],
            ['no_urut' => 41, 'dimensi' => 'IKE', 'nama_indikator' => 'Produk Unggulan Desa (OVOP)', 'keterangan' => 'Keberadaan produk khas yang dipasarkan luas.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Branding dan promosi produk unggulan desa.'],
            ['no_urut' => 42, 'dimensi' => 'IKE', 'nama_indikator' => 'Lahan Pertanian/Perkebunan Produktif', 'keterangan' => 'Pemanfaatan optimal lahan pertanian.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Rehabilitasi jaringan irigasi tersier.'],
            ['no_urut' => 43, 'dimensi' => 'IKE', 'nama_indikator' => 'Aksesibilitas Listrik untuk Usaha', 'keterangan' => 'Daya listrik memadai untuk industri rumah tangga.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Koordinasi penambahan trafo listrik industri.'],
            ['no_urut' => 44, 'dimensi' => 'IKE', 'nama_indikator' => 'Pemanfaatan Teknologi Informasi Ekonomi', 'keterangan' => 'Penggunaan digital marketing oleh UMKM.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pelatihan marketplace dan pembuatan konten promosi.'],
            ['no_urut' => 45, 'dimensi' => 'IKE', 'nama_indikator' => 'Pendapatan Asli Desa (PADes)', 'keterangan' => 'Besaran pendapatan yang dikelola desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Optimalisasi unit usaha BUMDes.'],

            // ════════════════════════════════════════════════
            // IKL – Indeks Ketahanan Lingkungan (15 indikator)
            // ════════════════════════════════════════════════
            ['no_urut' => 46, 'dimensi' => 'IKL', 'nama_indikator' => 'Kualitas Lingkungan (Sampah)', 'keterangan' => 'Pengelolaan sampah rumah tangga dan desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan TPS3R dan bank sampah desa.'],
            ['no_urut' => 47, 'dimensi' => 'IKL', 'nama_indikator' => 'Sumber Daya Alam (Pemanfaatan)', 'keterangan' => 'Pemanfaatan SDA desa secara berkelanjutan.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pemetaan wilayah kelola SDA desa.'],
            ['no_urut' => 48, 'dimensi' => 'IKL', 'nama_indikator' => 'Bencana Alam (Risiko Mitigasi)', 'keterangan' => 'Tingkat risiko bencana dan mitigasi desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Penyusunan peta risiko bencana desa.'],
            ['no_urut' => 49, 'dimensi' => 'IKL', 'nama_indikator' => 'Tanggap dan Siaga Bencana', 'keterangan' => 'Kapasitas warga merespons kejadian bencana.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pelatihan relawan dan simulasi kebencanaan.'],
            ['no_urut' => 50, 'dimensi' => 'IKL', 'nama_indikator' => 'Kerusakan Lingkungan (Degradasi)', 'keterangan' => 'Tingkat kerusakan lahan atau deforestasi.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Program penghijauan dan reboisasi lahan kritis.'],
            ['no_urut' => 51, 'dimensi' => 'IKL', 'nama_indikator' => 'Pencemaran Air', 'keterangan' => 'Kondisi kebersihan sumber air dari polusi.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Perlindungan mata air dan pembersihan sungai.'],
            ['no_urut' => 52, 'dimensi' => 'IKL', 'nama_indikator' => 'Pencemaran Udara', 'keterangan' => 'Kualitas udara desa dari polusi dan asap.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Sosialisasi larangan membakar sampah sembarangan.'],
            ['no_urut' => 53, 'dimensi' => 'IKL', 'nama_indikator' => 'Drainase dan Pengendalian Banjir', 'keterangan' => 'Kualitas sistem drainase pengendali banjir.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan drainase dan sumur resapan.'],
            ['no_urut' => 54, 'dimensi' => 'IKL', 'nama_indikator' => 'Penggunaan Energi Terbarukan', 'keterangan' => 'Pemanfaatan biogas, solar cell, dll.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan instalasi biogas atau PLTS.'],
            ['no_urut' => 55, 'dimensi' => 'IKL', 'nama_indikator' => 'Keberfungsian Hutan Desa/Adat', 'keterangan' => 'Pengelolaan hutan desa secara lestari.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Fasilitasi legalitas dan penjagaan hutan desa.'],
            ['no_urut' => 56, 'dimensi' => 'IKL', 'nama_indikator' => 'Perlindungan Mata Air dan DAS', 'keterangan' => 'Upaya perlindungan daerah aliran sungai.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Penanaman pohon di sepanjang sempadan sungai.'],
            ['no_urut' => 57, 'dimensi' => 'IKL', 'nama_indikator' => 'Pengelolaan Limbah Padat/Cair', 'keterangan' => 'Pengelolaan limbah domestik yang aman.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan IPAL komunal atau septik tank.'],
            ['no_urut' => 58, 'dimensi' => 'IKL', 'nama_indikator' => 'Ruang Terbuka Hijau (RTH)', 'keterangan' => 'Proporsi ruang terbuka hijau di desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Penataan taman dan jalur hijau jalan desa.'],
            ['no_urut' => 59, 'dimensi' => 'IKL', 'nama_indikator' => 'Ketahanan Pangan (Lumbung)', 'keterangan' => 'Ketersediaan cadangan pangan desa.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Pembangunan lumbung pangan dan pengisian stok.'],
            ['no_urut' => 60, 'dimensi' => 'IKL', 'nama_indikator' => 'Peraturan Desa Lingkungan Hidup', 'keterangan' => 'Keberadaan Perdes pelindung lingkungan.', 'nilai_tambah' => 0.02, 'kegiatan_dilakukan' => 'Penyusunan dan penetapan Perdes Lingkungan Hidup.'],
        ];
    }
}