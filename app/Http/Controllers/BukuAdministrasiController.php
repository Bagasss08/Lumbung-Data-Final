<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeraturanDesa;
use App\Models\BukuKeputusan;
use App\Models\BukuInventarisKekayaanDesa;
use App\Models\BukuPemerintah;
use App\Models\BukuTanahKasDesa;
use App\Models\BukuTanahDesa;
use App\Models\BukuAgendaSuratKeluar;
use App\Models\BukuAgendaSuratMasuk;
use App\Models\BukuEkspedisi;
use App\Models\BukuLembaranDesa;
use App\Models\Penduduk;
use App\Models\MutasiPenduduk;
use App\Models\PendudukSementara;
use App\Models\Keluarga;
use App\Models\BukuPembangunan;
use App\Models\KaderPemberdayaanMasyarakat;

class BukuAdministrasiController extends Controller
{
    /**
     * Konfigurasi semua kategori & subkategori yang bisa ditampilkan ke publik.
     */
    private function getKategoriConfig(): array
    {
        return [
            'umum' => [
                'label' => 'Administrasi Umum',
                'deskripsi' => 'Buku-buku administrasi umum pemerintahan desa.',
                'icon' => 'document-text',
                'color' => 'emerald',
                'subkategori' => [
                    'peraturan-desa'           => ['label' => 'Buku Peraturan di Desa',                  'desc' => 'Daftar peraturan yang berlaku di desa.'],
                    'keputusan'                => ['label' => 'Buku Keputusan Kepala Desa',              'desc' => 'Keputusan-keputusan kepala desa.'],
                    'inventaris-kekayaan-desa' => ['label' => 'Buku Inventaris dan Kekayaan Desa',      'desc' => 'Daftar aset dan kekayaan milik desa.'],
                    'pemerintah'               => ['label' => 'Buku Pemerintah Desa',                   'desc' => 'Data perangkat pemerintah desa.'],
                    'tanah-kas-desa'           => ['label' => 'Buku Tanah Kas Desa',                    'desc' => 'Data tanah kas milik desa.'],
                    'tanah-desa'               => ['label' => 'Buku Tanah di Desa',                     'desc' => 'Data tanah yang berada di wilayah desa.'],
                    'agenda-surat-keluar'      => ['label' => 'Buku Agenda Surat Keluar',               'desc' => 'Agenda surat yang dikeluarkan desa.'],
                    'agenda-surat-masuk'       => ['label' => 'Buku Agenda Surat Masuk',                'desc' => 'Agenda surat yang diterima desa.'],
                    'ekspedisi'                => ['label' => 'Buku Ekspedisi',                          'desc' => 'Catatan pengiriman surat ekspedisi.'],
                    'lembaran-desa'            => ['label' => 'Buku Lembaran Desa dan Berita Desa',     'desc' => 'Lembaran dan berita resmi desa.'],
                ],
            ],
            'penduduk' => [
                'label' => 'Administrasi Penduduk',
                'deskripsi' => 'Buku-buku administrasi kependudukan desa.',
                'icon' => 'users',
                'color' => 'blue',
                'subkategori' => [
                    'induk-penduduk'        => ['label' => 'Buku Induk Penduduk',              'desc' => 'Data penduduk utama yang terdaftar di desa.'],
                    'mutasi-penduduk'       => ['label' => 'Buku Mutasi Penduduk Desa',        'desc' => 'Catatan perpindahan penduduk masuk dan keluar.'],
                    'penduduk-sementara'    => ['label' => 'Buku Penduduk Sementara',          'desc' => 'Data penduduk yang tinggal sementara di desa.'],
                    'ktp-kk'                => ['label' => 'Buku KTP dan KK',                  'desc' => 'Data Kartu Tanda Penduduk dan Kartu Keluarga.'],
                ],
            ],
            'pembangunan' => [
                'label' => 'Administrasi Pembangunan',
                'deskripsi' => 'Buku-buku administrasi pembangunan dan pemberdayaan masyarakat.',
                'icon' => 'office-building',
                'color' => 'amber',
                'subkategori' => [
                    'rencana-kerja'      => ['label' => 'Buku Rencana Kerja Pembangunan',             'desc' => 'Rencana kerja pembangunan tahunan desa.'],
                    'kegiatan'           => ['label' => 'Buku Kegiatan Pembangunan',                  'desc' => 'Monitoring dan pencatatan kegiatan pembangunan.'],
                    'inventaris'         => ['label' => 'Buku Inventaris Hasil-Hasil Pembangunan',    'desc' => 'Daftar hasil pembangunan yang telah selesai.'],
                    'kader-pemberdayaan' => ['label' => 'Buku Kader Pemberdayaan Masyarakat',        'desc' => 'Data kader pemberdayaan masyarakat desa.'],
                ],
            ],
        ];
    }

    /**
     * Halaman index — daftar semua kategori buku administrasi.
     */
    public function index()
    {
        $kategoriList = $this->getKategoriConfig();
        return view('frontend.pages.buku-administrasi.index', compact('kategoriList'));
    }

    /**
     * Halaman kategori — daftar subkategori dari kategori tertentu.
     */
    public function kategori(string $kategori)
    {
        $allKategori = $this->getKategoriConfig();
        if (!isset($allKategori[$kategori])) {
            abort(404);
        }
        $config = $allKategori[$kategori];
        return view('frontend.pages.buku-administrasi.kategori', compact('kategori', 'config'));
    }

    /**
     * Halaman show — tabel data untuk subkategori tertentu.
     */
    public function showData(Request $request, string $kategori, string $subkategori)
    {
        $allKategori = $this->getKategoriConfig();
        if (!isset($allKategori[$kategori]['subkategori'][$subkategori])) {
            abort(404);
        }

        $subConfig = $allKategori[$kategori]['subkategori'][$subkategori];
        $cari = $request->get('cari');
        $perPage = 15;

        [$columns, $data] = $this->getData($kategori, $subkategori, $cari, $perPage);

        return view('frontend.pages.buku-administrasi.show', [
            'kategori'    => $kategori,
            'subkategori' => $subkategori,
            'subConfig'   => $subConfig,
            'kategoriConfig' => $allKategori[$kategori],
            'columns'     => $columns,
            'data'        => $data,
            'cari'        => $cari,
        ]);
    }

    /**
     * Ambil data + kolom sesuai subkategori. Hanya kolom non-sensitif.
     */
    private function getData(string $kategori, string $subkategori, ?string $cari, int $perPage): array
    {
        switch ("$kategori/$subkategori") {

            // ── UMUM ────────────────────────────────────────────
            case 'umum/peraturan-desa':
                $columns = [
                    'Nomor'       => 'nomor',
                    'Tentang'     => 'tentang',
                    'Tgl Ditetapkan' => 'tanggal_ditetapkan',
                    'Status'      => 'is_aktif',
                ];
                $q = PeraturanDesa::query();
                if ($cari) $q->where('tentang', 'like', "%$cari%")->orWhere('nomor', 'like', "%$cari%");
                return [$columns, $q->latest()->paginate($perPage)];

            case 'umum/keputusan':
                $columns = [
                    'No. Keputusan'  => 'nomor_keputusan',
                    'Tgl Keputusan'  => 'tanggal_keputusan',
                    'Tentang'        => 'tentang',
                    'Uraian Singkat' => 'uraian_singkat',
                    'Tgl Dilaporkan' => 'tanggal_dilaporkan',
                ];
                $q = BukuKeputusan::query();
                if ($cari) $q->where('tentang', 'like', "%$cari%")->orWhere('nomor_keputusan', 'like', "%$cari%");
                return [$columns, $q->latest()->paginate($perPage)];

            case 'umum/inventaris-kekayaan-desa':
                $columns = [
                    'Kode Barang'   => 'kode_barang',
                    'Nama Barang'   => 'nama_barang',
                    'Kategori'      => 'kategori',
                    'Jumlah'        => 'jumlah',
                    'Satuan'        => 'satuan',
                    'Tahun Pengadaan' => 'tahun_pengadaan',
                    'Kondisi'       => 'kondisi',
                    'Lokasi'        => 'lokasi',
                ];
                $q = BukuInventarisKekayaanDesa::query();
                if ($cari) $q->where('nama_barang', 'like', "%$cari%")->orWhere('kode_barang', 'like', "%$cari%");
                return [$columns, $q->latest()->paginate($perPage)];

            case 'umum/pemerintah':
                $columns = [
                    'Nama Lengkap'  => 'nama_lengkap',
                    'Jabatan'       => 'jabatan',
                    'Jenis Kelamin' => 'jenis_kelamin',
                    'Pendidikan'    => 'pendidikan_terakhir',
                    'Pangkat/Gol'   => 'pangkat_golongan',
                ];
                $q = BukuPemerintah::query();
                if ($cari) $q->where('nama_lengkap', 'like', "%$cari%")->orWhere('jabatan', 'like', "%$cari%");
                return [$columns, $q->paginate($perPage)];

            case 'umum/tanah-kas-desa':
                $columns = [
                    'Asal Tanah'    => 'asal_tanah_kas_desa',
                    'No. Sertifikat'=> 'nomor_sertifikat',
                    'Luas (m²)'     => 'luas',
                    'Kelas'         => 'kelas',
                    'Jenis Tanah'   => 'jenis_tanah',
                    'Lokasi'        => 'lokasi',
                    'Peruntukan'    => 'peruntukan',
                ];
                $q = BukuTanahKasDesa::query();
                if ($cari) $q->where('lokasi', 'like', "%$cari%")->orWhere('asal_tanah_kas_desa', 'like', "%$cari%");
                return [$columns, $q->paginate($perPage)];

            case 'umum/tanah-desa':
                $columns = [
                    'Nama Pemilik'  => 'nama_pemilik',
                    'Luas (m²)'     => 'luas_tanah',
                    'Status Hak'    => 'status_hak_tanah',
                    'Penggunaan'    => 'penggunaan_tanah',
                    'Letak Tanah'   => 'letak_tanah',
                ];
                $q = BukuTanahDesa::query();
                if ($cari) $q->where('nama_pemilik', 'like', "%$cari%")->orWhere('letak_tanah', 'like', "%$cari%");
                return [$columns, $q->paginate($perPage)];

            case 'umum/agenda-surat-keluar':
                $columns = [
                    'Tgl Kirim'    => 'tanggal_pengiriman',
                    'No. Surat'    => 'nomor_surat',
                    'Tgl Surat'    => 'tanggal_surat',
                    'Tujuan'       => 'tujuan',
                    'Isi Singkat'  => 'isi_singkat',
                ];
                $q = BukuAgendaSuratKeluar::query();
                if ($cari) $q->where('tujuan', 'like', "%$cari%")->orWhere('isi_singkat', 'like', "%$cari%")->orWhere('nomor_surat', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_pengiriman')->paginate($perPage)];

            case 'umum/agenda-surat-masuk':
                $columns = [
                    'Tgl Terima'   => 'tanggal_penerimaan',
                    'No. Surat'    => 'nomor_surat',
                    'Tgl Surat'    => 'tanggal_surat',
                    'Pengirim'     => 'pengirim',
                    'Isi Singkat'  => 'isi_singkat',
                    'Disposisi'    => 'disposisi',
                ];
                $q = BukuAgendaSuratMasuk::query();
                if ($cari) $q->where('pengirim', 'like', "%$cari%")->orWhere('isi_singkat', 'like', "%$cari%")->orWhere('nomor_surat', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_penerimaan')->paginate($perPage)];

            case 'umum/ekspedisi':
                $columns = [
                    'Tgl Kirim'   => 'tanggal_pengiriman',
                    'No. Surat'   => 'nomor_surat',
                    'Tgl Surat'   => 'tanggal_surat',
                    'Isi Singkat' => 'isi_singkat',
                    'Tujuan'      => 'tujuan',
                ];
                $q = BukuEkspedisi::query();
                if ($cari) $q->where('tujuan', 'like', "%$cari%")->orWhere('isi_singkat', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_pengiriman')->paginate($perPage)];

            case 'umum/lembaran-desa':
                $columns = [
                    'Jenis Peraturan'   => 'jenis_peraturan',
                    'No. Ditetapkan'    => 'nomor_ditetapkan',
                    'Tgl Ditetapkan'    => 'tanggal_ditetapkan',
                    'Tentang'           => 'tentang',
                    'No. Lembaran'      => 'nomor_diundangkan_lembaran',
                    'Tgl Lembaran'      => 'tanggal_diundangkan_lembaran',
                ];
                $q = BukuLembaranDesa::query();
                if ($cari) $q->where('tentang', 'like', "%$cari%")->orWhere('jenis_peraturan', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_ditetapkan')->paginate($perPage)];

            // ── PENDUDUK ─────────────────────────────────────────
            case 'penduduk/induk-penduduk':
                $columns = [
                    'NIK'           => 'nik',
                    'Nama'          => 'nama',
                    'Jenis Kelamin' => 'jenis_kelamin',
                    'Tempat Lahir'  => 'tempat_lahir',
                    'Tgl Lahir'     => 'tanggal_lahir',
                    'Alamat'        => 'alamat',
                    'Status'        => 'status_hidup',
                ];
                $q = Penduduk::hidup()->select(['nik','nama','jenis_kelamin','tempat_lahir','tanggal_lahir','alamat','status_hidup']);
                if ($cari) $q->where(function($q2) use ($cari) {
                    $q2->where('nama', 'like', "%$cari%")->orWhere('nik', 'like', "%$cari%")->orWhere('alamat', 'like', "%$cari%");
                });
                return [$columns, $q->orderBy('nama')->paginate($perPage)];

            case 'penduduk/mutasi-penduduk':
                $columns = [
                    'NIK'           => 'nik',
                    'Nama'          => 'nama',
                    'Jenis Mutasi'  => 'jenis_mutasi',
                    'Tgl Mutasi'    => 'tanggal_mutasi',
                    'Asal'          => 'asal',
                    'Tujuan'        => 'tujuan',
                    'Alasan'        => 'alasan',
                ];
                $q = MutasiPenduduk::query();
                if ($cari) $q->where('nama', 'like', "%$cari%")->orWhere('nik', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_mutasi')->paginate($perPage)];

            case 'penduduk/penduduk-sementara':
                $columns = [
                    'NIK'           => 'nik',
                    'Nama'          => 'nama',
                    'Jenis Kelamin' => 'jenis_kelamin',
                    'Asal Daerah'   => 'asal_daerah',
                    'Tujuan Datang' => 'tujuan_kedatangan',
                    'Tgl Datang'    => 'tanggal_datang',
                    'Tgl Pergi'     => 'tanggal_pergi',
                    'Menginap di'   => 'tempat_menginap',
                ];
                $q = PendudukSementara::query();
                if ($cari) $q->where('nama', 'like', "%$cari%")->orWhere('nik', 'like', "%$cari%")->orWhere('asal_daerah', 'like', "%$cari%");
                return [$columns, $q->latest('tanggal_datang')->paginate($perPage)];

            case 'penduduk/ktp-kk':
                $columns = [
                    'No. KK'           => 'no_kk',
                    'Kepala Keluarga'  => 'nama_kepala',
                    'Alamat'           => 'alamat',
                    'Tgl Terdaftar'    => 'tgl_terdaftar',
                    'Tgl Cetak KK'     => 'tgl_cetak_kk',
                    'Status'           => 'status',
                ];
                $q = Keluarga::with('kepalaKeluarga:id,nama')->latest('tgl_terdaftar');
                if ($cari) $q->where('no_kk', 'like', "%$cari%")->orWhereHas('kepalaKeluarga', fn($k) => $k->where('nama', 'like', "%$cari%"));
                $rawData = $q->paginate($perPage);
                // Transform for display
                $rawData->getCollection()->transform(function ($item) {
                    $item->nama_kepala = optional($item->kepalaKeluarga)->nama ?? '-';
                    $item->status = $item->status ? 'Aktif' : 'Tidak Aktif';
                    return $item;
                });
                return [$columns, $rawData];

            // ── PEMBANGUNAN ──────────────────────────────────────
            case 'pembangunan/rencana-kerja':
            case 'pembangunan/kegiatan':
                $columns = [
                    'Nama Kegiatan'  => 'nama',
                    'Bidang'         => 'bidang',
                    'Tahun Anggaran' => 'tahun_anggaran',
                    'Sasaran'        => 'sasaran',
                    'Volume'         => 'volume',
                    'Pelaksana'      => 'pelaksana',
                    'Sumber Dana'    => 'sumber_dana',
                ];
                $q = BukuPembangunan::query();
                if ($cari) $q->where('nama', 'like', "%$cari%")->orWhere('bidang', 'like', "%$cari%");
                return [$columns, $q->latest('tahun_anggaran')->paginate($perPage)];

            case 'pembangunan/inventaris':
                $columns = [
                    'Nama Kegiatan'  => 'nama',
                    'Bidang'         => 'bidang',
                    'Tahun Anggaran' => 'tahun_anggaran',
                    'Volume'         => 'volume',
                    'Satuan'         => 'satuan',
                    'Sumber Dana'    => 'sumber_dana',
                ];
                $q = BukuPembangunan::aktif();
                if ($cari) $q->where('nama', 'like', "%$cari%");
                return [$columns, $q->latest('tahun_anggaran')->paginate($perPage)];

            case 'pembangunan/kader-pemberdayaan':
                $columns = [
                    'Nama'          => 'nama',
                    'Jenis Kelamin' => 'jenis_kelamin',
                    'Pendidikan'    => 'pendidikan',
                    'Bidang Tugas'  => 'bidang_tugas',
                    'Tahun Aktif'   => 'tahun_aktif',
                    'Alamat'        => 'alamat',
                ];
                $q = KaderPemberdayaanMasyarakat::query();
                if ($cari) $q->where('nama', 'like', "%$cari%")->orWhere('bidang_tugas', 'like', "%$cari%");
                return [$columns, $q->latest('tahun_aktif')->paginate($perPage)];

            default:
                abort(404);
        }
    }
}
