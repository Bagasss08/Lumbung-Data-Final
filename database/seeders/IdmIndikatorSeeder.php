<?php

namespace Database\Seeders;

use App\Models\IdmIndikator;
use Illuminate\Database\Seeder;

class IdmIndikatorSeeder extends Seeder {
    /**
     * 60 Indikator IDM resmi (Kemendes PDTT).
     *
     * Struktur tiap item:
     *   no_urut, dimensi, nama_indikator,
     *   keterangan (kondisi ideal/deskripsi),
     *   nilai_tambah (kontribusi ke skor IDM jika maks)
     *
     * Cara pakai:
     *   php artisan db:seed --class=IdmIndikatorSeeder
     *   php artisan db:seed --class=IdmIndikatorSeeder --tahun=2025
     */

    // ── Ganti tahun sesuai kebutuhan, atau lewat env/argument ──
    private int $tahun;

    public function run(): void {
        // Ambil tahun dari opsi atau pakai tahun berjalan
        $this->tahun = (int) ($this->command?->option('tahun') ?? date('Y'));

        // Hindari duplikasi
        if (IdmIndikator::where('tahun', $this->tahun)->exists()) {
            $this->command?->warn("Data IDM tahun {$this->tahun} sudah ada, seeder dilewati.");
            return;
        }

        $indikator = $this->dataIndikator();

        foreach ($indikator as $row) {
            IdmIndikator::create(array_merge($row, [
                'tahun' => $this->tahun,
                'skor'  => 0,
            ]));
        }

        $this->command?->info("✔  " . count($indikator) . " indikator IDM tahun {$this->tahun} berhasil di-seed.");
    }

    // ──────────────────────────────────────────────────────────────────────
    // DATA 60 INDIKATOR RESMI IDM
    // Sumber: Permendes No.2 Tahun 2016 & pembaruan Kemendes PDTT
    // nilai_tambah = kontribusi per indikator jika skor = 5 (maks)
    // ──────────────────────────────────────────────────────────────────────
    private function dataIndikator(): array {
        return [

            // ════════════════════════════════════════════════
            // IKS – Indeks Ketahanan Sosial (30 indikator)
            // ════════════════════════════════════════════════

            // — Kesehatan —
            [
                'no_urut'          => 1,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Pelayanan Kesehatan (Polindes/Poskesdes/Posbindu)',
                'keterangan'       => 'Ketersediaan dan akses warga ke pos pelayanan kesehatan desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan/revitalisasi Polindes, Poskesdes, atau Posbindu.',
            ],
            [
                'no_urut'          => 2,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Pelayanan Kesehatan (Puskesmas/Klinik)',
                'keterangan'       => 'Ketersediaan dan akses warga ke puskesmas atau klinik.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Advokasi pembangunan puskesmas/klinik atau perbaikan akses jalan menuju fasilitas.',
            ],
            [
                'no_urut'          => 3,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Tenaga Kesehatan (Dokter/Bidan/Perawat)',
                'keterangan'       => 'Ketersediaan tenaga medis yang menetap atau rutin berpraktik di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Koordinasi dengan Dinas Kesehatan untuk penempatan nakes; fasilitasi klinik swasta.',
            ],
            [
                'no_urut'          => 4,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Keberfungsian Posyandu',
                'keterangan'       => 'Posyandu aktif dan melayani kegiatan gizi, imunisasi, dan pemantauan tumbuh kembang.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Revitalisasi posyandu, pelatihan kader, dan penyediaan PMT.',
            ],
            [
                'no_urut'          => 5,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Air Bersih dan Air Minum Layak',
                'keterangan'       => 'Persentase rumah tangga yang mengakses sumber air minum layak.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan sarana air bersih, sumur bor, atau sambungan PDAM.',
            ],
            [
                'no_urut'          => 6,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Sanitasi Layak (Jamban Keluarga)',
                'keterangan'       => 'Persentase rumah tangga yang memiliki dan menggunakan jamban layak.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Program STBM, bantuan jamban, dan sosialisasi PHBS.',
            ],
            [
                'no_urut'          => 7,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Listrik',
                'keterangan'       => 'Persentase rumah tangga yang memiliki akses listrik (PLN atau energi terbarukan).',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Koordinasi PLN, pembangunan PLTS atau PLTMH untuk daerah terpencil.',
            ],
            [
                'no_urut'          => 8,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Informasi dan Komunikasi (Telepon/Internet)',
                'keterangan'       => 'Persentase rumah tangga yang memiliki akses telepon seluler atau internet.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Fasilitasi tower BTS, wifi desa, atau titik akses internet publik.',
            ],

            // — Pendidikan —
            [
                'no_urut'          => 9,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan dan Akses ke PAUD/TK',
                'keterangan'       => 'Ketersediaan lembaga PAUD/TK dalam jangkauan desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pendirian PAUD/TK desa atau fasilitasi transportasi ke lembaga terdekat.',
            ],
            [
                'no_urut'          => 10,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan dan Akses ke SD/MI',
                'keterangan'       => 'Ketersediaan SD/MI dalam jangkauan desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Koordinasi Dinas Pendidikan; fasilitasi antar-jemput siswa.',
            ],
            [
                'no_urut'          => 11,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan dan Akses ke SMP/MTs',
                'keterangan'       => 'Ketersediaan SMP/MTs dalam jangkauan desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Advokasi pendirian SMP/MTs; fasilitasi beasiswa/transportasi.',
            ],
            [
                'no_urut'          => 12,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan dan Akses ke SMA/MA/SMK',
                'keterangan'       => 'Ketersediaan SMA/MA/SMK dalam jangkauan desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Advokasi pendirian SMA; fasilitasi beasiswa dan asrama siswa.',
            ],
            [
                'no_urut'          => 13,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Pendidikan Kesetaraan (Paket A/B/C)',
                'keterangan'       => 'Ketersediaan program Kejar Paket di desa atau PKBM terdekat.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembentukan/aktivasi PKBM desa; koordinasi dengan Dinas Pendidikan.',
            ],
            [
                'no_urut'          => 14,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Pengetahuan (Taman Baca/Perpustakaan)',
                'keterangan'       => 'Keberadaan perpustakaan desa, taman baca, atau sudut baca aktif.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan/revitalisasi perpustakaan desa; pengadaan koleksi buku.',
            ],

            // — Modal Sosial —
            [
                'no_urut'          => 15,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Solidaritas Sosial (Gotong Royong/Keswadayaan)',
                'keterangan'       => 'Tingkat partisipasi warga dalam kegiatan gotong royong dan keswadayaan.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Program pemberdayaan masyarakat dan penguatan kelembagaan desa.',
            ],
            [
                'no_urut'          => 16,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Toleransi dan Kerukunan Sosial',
                'keterangan'       => 'Kondisi kerukunan antarwarga, antaragama, dan antarkelompok di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Forum dialog antarwarga; kegiatan budaya dan keagamaan bersama.',
            ],
            [
                'no_urut'          => 17,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Rasa Aman Warga (Keamanan dan Ketertiban)',
                'keterangan'       => 'Tingkat keamanan dan ketertiban umum di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Penguatan LINMAS, siskamling, dan sistem pelaporan keamanan.',
            ],
            [
                'no_urut'          => 18,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Kesejahteraan Sosial (Penerima Bansos/PKH)',
                'keterangan'       => 'Cakupan warga penerima program bantuan sosial (PKH, BLT, dsb.).',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pemutakhiran data DTKS; fasilitasi pendaftaran penerima manfaat.',
            ],
            [
                'no_urut'          => 19,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Penyandang Masalah Kesejahteraan Sosial (PMKS)',
                'keterangan'       => 'Penanganan PMKS (lansia, difabel, anak terlantar) di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Program perlindungan sosial; pendataan dan pendampingan PMKS.',
            ],
            [
                'no_urut'          => 20,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Jaminan Sosial Kesehatan (JKN/KIS)',
                'keterangan'       => 'Cakupan warga yang memiliki jaminan kesehatan nasional.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Fasilitasi kepesertaan JKN; sosialisasi manfaat KIS kepada warga.',
            ],
            [
                'no_urut'          => 21,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses ke Pelayanan Pemerintahan',
                'keterangan'       => 'Kemudahan warga mengakses layanan adminduk dan layanan pemerintah desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Digitalisasi layanan desa; peningkatan kapasitas perangkat desa.',
            ],
            [
                'no_urut'          => 22,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan Permukiman Layak',
                'keterangan'       => 'Persentase rumah layak huni di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Program RTLH; fasilitasi bantuan material bangunan dari pemerintah.',
            ],
            [
                'no_urut'          => 23,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Kesehatan Masyarakat – Gizi (Prevalensi Stunting)',
                'keterangan'       => 'Angka prevalensi stunting balita di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Program konvergensi stunting; penguatan posyandu dan PMT.',
            ],
            [
                'no_urut'          => 24,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Kesehatan Masyarakat – Kematian Bayi',
                'keterangan'       => 'Angka kematian bayi dan ibu melahirkan di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Penguatan ANC terpadu; pengadaan ambulans desa; kemitraan bidan-dukun.',
            ],
            [
                'no_urut'          => 25,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan Tempat Ibadah',
                'keterangan'       => 'Ketersediaan tempat ibadah yang memadai bagi seluruh warga.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan/rehabilitasi tempat ibadah.',
            ],
            [
                'no_urut'          => 26,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan Fasilitas Olahraga',
                'keterangan'       => 'Ketersediaan lapangan/fasilitas olahraga umum di desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan lapangan olahraga multifungsi.',
            ],
            [
                'no_urut'          => 27,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Ketersediaan Ruang Publik/Taman Bermain',
                'keterangan'       => 'Ketersediaan ruang publik terbuka atau taman bermain anak.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pembangunan taman desa/ruang terbuka publik.',
            ],
            [
                'no_urut'          => 28,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Keberadaan Kelompok Kegiatan Masyarakat',
                'keterangan'       => 'Keberadaan organisasi/kelompok aktif (PKK, Karang Taruna, dll).',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Penguatan dan revitalisasi organisasi kemasyarakatan desa.',
            ],
            [
                'no_urut'          => 29,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Akses Tenaga Kerja ke Luar Desa',
                'keterangan'       => 'Kemudahan warga mengakses pasar kerja di luar desa.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Pelatihan keterampilan; bursa kerja; perbaikan akses transportasi.',
            ],
            [
                'no_urut'          => 30,
                'dimensi'          => 'IKS',
                'nama_indikator'   => 'Penanganan Warga Miskin Ekstrem',
                'keterangan'       => 'Upaya desa dalam mengentaskan kemiskinan ekstrem.',
                'nilai_tambah'     => 0.00666667,
                'kegiatan_dilakukan' => 'Verifikasi data kemiskinan ekstrem; program padat karya tunai desa.',
            ],

            // ════════════════════════════════════════════════
            // IKE – Indeks Ketahanan Ekonomi (15 indikator)
            // ════════════════════════════════════════════════

            [
                'no_urut'          => 31,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Keragaman Produksi Masyarakat Desa',
                'keterangan'       => 'Variasi jenis produk/komoditas yang dihasilkan warga desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Diversifikasi usaha; program pengembangan produk unggulan desa.',
            ],
            [
                'no_urut'          => 32,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Tersedianya Pusat Pelayanan Perdagangan (Pasar Desa)',
                'keterangan'       => 'Keberadaan pasar desa atau pusat perdagangan yang aktif.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan/revitalisasi pasar desa; pengaturan hari pasar.',
            ],
            [
                'no_urut'          => 33,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Akses Distribusi/Logistik',
                'keterangan'       => 'Kemudahan distribusi produk desa ke pasar eksternal.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Perbaikan jalan desa; fasilitasi kemitraan dengan pengepul/distributor.',
            ],
            [
                'no_urut'          => 34,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Akses Lembaga Keuangan (Bank/Koperasi/BUMDes)',
                'keterangan'       => 'Ketersediaan lembaga keuangan formal atau BUMDes yang aktif.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pendirian/penguatan BUMDes; fasilitasi akses kredit UMKM.',
            ],
            [
                'no_urut'          => 35,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Lembaga Ekonomi (Koperasi/Kelompok Tani/Nelayan)',
                'keterangan'       => 'Keberadaan dan keberfungsian lembaga ekonomi produktif di desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Penguatan koperasi; pembentukan gapoktan; pelatihan manajerial.',
            ],
            [
                'no_urut'          => 36,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Keterbukaan Wilayah (Kondisi Jalan Utama)',
                'keterangan'       => 'Kondisi dan aksesibilitas jalan utama yang menghubungkan desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan/peningkatan jalan desa; koordinasi pemda untuk jalan kabupaten.',
            ],
            [
                'no_urut'          => 37,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Aksesibilitas Transportasi',
                'keterangan'       => 'Ketersediaan moda transportasi umum yang melayani desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Fasilitasi angkutan pedesaan; pengembangan armada desa.',
            ],
            [
                'no_urut'          => 38,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Tingkat Aktivitas Masyarakat (Usaha Ekonomi Produktif)',
                'keterangan'       => 'Tingkat keaktifan usaha ekonomi produktif oleh warga desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pelatihan kewirausahaan; pendampingan UMKM; akses modal usaha.',
            ],
            [
                'no_urut'          => 39,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Keberadaan Fasilitas Energi (SPBU/Agen/Kios BBM)',
                'keterangan'       => 'Ketersediaan akses bahan bakar/energi di desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Fasilitasi Pertamina mitra desa; pengembangan energi alternatif.',
            ],
            [
                'no_urut'          => 40,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Potensi dan Kapasitas Pariwisata',
                'keterangan'       => 'Keberadaan dan pengembangan potensi wisata desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pengembangan desa wisata; pelatihan pengelolaan wisata.',
            ],
            [
                'no_urut'          => 41,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Produk Unggulan Desa (Satu Desa Satu Produk)',
                'keterangan'       => 'Keberadaan produk unggulan desa yang dipasarkan secara luas.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Fasilitasi branding dan pemasaran produk unggulan; hilirisasi produk.',
            ],
            [
                'no_urut'          => 42,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Lahan Pertanian/Perkebunan Produktif',
                'keterangan'       => 'Pemanfaatan optimal lahan pertanian/perkebunan desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Cetak sawah; rehabilitasi irigasi; program pertanian intensif.',
            ],
            [
                'no_urut'          => 43,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Aksesibilitas Listrik untuk Usaha',
                'keterangan'       => 'Ketersediaan daya listrik yang memadai untuk kegiatan usaha produktif.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Koordinasi PLN untuk peningkatan daya; fasilitasi PLTS komunal.',
            ],
            [
                'no_urut'          => 44,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Pemanfaatan Teknologi Informasi untuk Ekonomi',
                'keterangan'       => 'Penggunaan e-commerce/digital marketing oleh pelaku usaha desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pelatihan digital marketing; fasilitasi marketplace; internet desa.',
            ],
            [
                'no_urut'          => 45,
                'dimensi'          => 'IKE',
                'nama_indikator'   => 'Pendapatan Asli Desa (PADes)',
                'keterangan'       => 'Besaran dan pertumbuhan pendapatan asli yang dikelola desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Optimalisasi BUMDes; pengelolaan aset desa secara produktif.',
            ],

            // ════════════════════════════════════════════════
            // IKL – Indeks Ketahanan Lingkungan (15 indikator)
            // ════════════════════════════════════════════════

            [
                'no_urut'          => 46,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Kualitas Lingkungan (Kebersihan dan Pengelolaan Sampah)',
                'keterangan'       => 'Pengelolaan sampah rumah tangga dan kebersihan lingkungan desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan TPS3R; bank sampah; program 3R.',
            ],
            [
                'no_urut'          => 47,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Sumber Daya Alam (Potensi dan Pemanfaatan)',
                'keterangan'       => 'Pemanfaatan SDA desa secara berkelanjutan.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pemetaan potensi SDA; program pengelolaan SDA partisipatif.',
            ],
            [
                'no_urut'          => 48,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Bencana Alam (Risiko dan Mitigasi)',
                'keterangan'       => 'Tingkat risiko bencana dan kesiapan mitigasi desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Penyusunan Rencana Penanggulangan Bencana Desa; Destana.',
            ],
            [
                'no_urut'          => 49,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Tanggap dan Siaga Bencana',
                'keterangan'       => 'Kapasitas warga dan desa dalam merespons kejadian bencana.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pelatihan relawan; simulasi bencana; penyediaan alat peringatan dini.',
            ],
            [
                'no_urut'          => 50,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Kerusakan Lingkungan Hidup (Degradasi Lahan)',
                'keterangan'       => 'Tingkat kerusakan lahan, erosi, atau deforestasi di wilayah desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Penghijauan; reboisasi; pembuatan terasering.',
            ],
            [
                'no_urut'          => 51,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Pencemaran Air',
                'keterangan'       => 'Kondisi kebersihan sumber air (sungai, sumur, mata air) dari pencemaran.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Perlindungan mata air; pengolahan limbah; sosialisasi PHBS.',
            ],
            [
                'no_urut'          => 52,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Pencemaran Udara',
                'keterangan'       => 'Kondisi kualitas udara desa dari polusi dan asap.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pengendalian pembakaran; peningkatan ruang terbuka hijau.',
            ],
            [
                'no_urut'          => 53,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Drainase dan Pengendalian Banjir',
                'keterangan'       => 'Kualitas sistem drainase dan pengendalian banjir di desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan/normalisasi drainase; pembuatan embung/sumur resapan.',
            ],
            [
                'no_urut'          => 54,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Penggunaan Energi Terbarukan',
                'keterangan'       => 'Pemanfaatan energi terbarukan (biogas, PLTS, PLTMH) oleh warga desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan PLTS komunal; biogas kotoran ternak; kincir air.',
            ],
            [
                'no_urut'          => 55,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Keberadaan dan Keberfungsian Hutan Desa/Adat',
                'keterangan'       => 'Pengelolaan dan perlindungan hutan desa/adat secara lestari.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Fasilitasi SK Hutan Desa/Adat; penyusunan aturan kelola hutan.',
            ],
            [
                'no_urut'          => 56,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Perlindungan Sumber Mata Air dan DAS',
                'keterangan'       => 'Upaya perlindungan mata air dan daerah aliran sungai di desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Penanaman di sempadan sungai; perlindungan zona penyangga mata air.',
            ],
            [
                'no_urut'          => 57,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Pengelolaan Limbah Padat dan Cair',
                'keterangan'       => 'Pengelolaan limbah domestik dan industri rumah tangga secara aman.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'IPAL komunal; septik tank komunal; pengelolaan sampah terpadu.',
            ],
            [
                'no_urut'          => 58,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Ruang Terbuka Hijau (RTH)',
                'keterangan'       => 'Proporsi dan kondisi ruang terbuka hijau di desa.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan taman desa; penghijauan jalan dan pekarangan.',
            ],
            [
                'no_urut'          => 59,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Ketahanan Pangan (Cadangan Pangan Desa)',
                'keterangan'       => 'Ketersediaan cadangan pangan desa (lumbung pangan, dll).',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Pembangunan/penguatan lumbung pangan desa; diversifikasi pangan lokal.',
            ],
            [
                'no_urut'          => 60,
                'dimensi'          => 'IKL',
                'nama_indikator'   => 'Peraturan Desa tentang Lingkungan Hidup',
                'keterangan'       => 'Keberadaan Perdes atau aturan adat yang melindungi lingkungan hidup.',
                'nilai_tambah'     => 0.02000000,
                'kegiatan_dilakukan' => 'Penyusunan Perdes lingkungan hidup; sosialisasi dan penegakan aturan.',
            ],
        ];
    }
}
