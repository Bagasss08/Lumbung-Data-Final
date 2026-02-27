<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

// --- MODEL ---
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Wilayah;
use App\Models\Artikel;
use App\Models\IdentitasDesa;
use App\Models\PerangkatDesa;
use App\Models\AsetDesa;          
use App\Models\Apbdes;
use App\Models\KategoriKonten;
use App\Models\Pengaduan;
use App\Models\KomentarArtikel;
use App\Models\Lapak;

class FrontendController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HELPER PRIVATE
    |--------------------------------------------------------------------------
    */

    private function getIdentitasDesa(): IdentitasDesa
    {
        return IdentitasDesa::first() ?? new IdentitasDesa();
    }

    /**
     * Resolve path gambar dari storage. Jika tidak ada, kembalikan placeholder.
     */
    private function resolveGambar(?string $filename, string $folder, string $placeholder = ''): string
    {
        if ($filename && file_exists(storage_path('app/public/' . $folder . '/' . $filename))) {
            return asset('storage/' . $folder . '/' . $filename);
        }
        return $placeholder ?: 'https://via.placeholder.com/400x300?text=No+Image';
    }

    /**
     * Ambil data perangkat desa secara defensif (tanpa asumsi scope atau relasi).
     */
    private function getPerangkat(): \Illuminate\Support\Collection
    {
        try {
            // Coba dengan relasi jabatan jika ada
            if (class_exists(\App\Models\PerangkatDesa::class)) {
                $query = \App\Models\PerangkatDesa::query()->where('status', '1');

                // Load relasi jabatan jika ada
                if (Schema::hasTable('jabatans') || Schema::hasTable('ref_jabatans')) {
                    $query->with('jabatan');
                }

                return $query->orderBy('urutan', 'asc')->get();
            }
        } catch (\Exception $e) {
            // Jika model tidak ada, kembalikan koleksi kosong
        }

        return collect();
    }

    /**
     * Ambil nama jabatan dari perangkat secara aman.
     */
    private function getJabatanNama($perangkat): string
    {
        if (isset($perangkat->jabatan) && $perangkat->jabatan) {
            return $perangkat->jabatan->nama ?? ($perangkat->jabatan->nama_jabatan ?? '-');
        }
        // Fallback: coba kolom langsung
        return $perangkat->jabatan_nama ?? $perangkat->nama_jabatan ?? $perangkat->jabatan ?? '-';
    }

    /**
     * Format foto perangkat desa.
     */
    private function getFotoPerangkat($perangkat): string
    {
        if (!empty($perangkat->foto)) {
            return asset('storage/' . $perangkat->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($perangkat->nama) . '&background=059669&color=fff&size=500';
    }

    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        $identitas = $this->getIdentitasDesa();

        // 1. Variabel $desaInfo (Satu deklarasi, data lengkap)
        $desaInfo = [
            'nama_desa'         => $identitas->nama_desa ?? 'Maju & Mandiri',
            'kecamatan'         => $identitas->kecamatan ?? '-',
            'kabupaten'         => $identitas->kabupaten ?? '-',
            'provinsi'          => $identitas->provinsi ?? '-',
            'email_desa'        => $identitas->email_desa ?? '-',
            'telepon_desa'      => $identitas->telepon_desa ?? '-',
            'alamat_kantor'     => $identitas->alamat_kantor ?? '-',
            'deskripsi_singkat' => $identitas->deskripsi_singkat ?? 'Selamat datang di portal resmi transformasi digital Pemerintah Desa.',
            'gambar_kantor'     => $this->resolveGambar(
                $identitas->gambar_kantor, 
                'gambar-kantor', 
                'https://via.placeholder.com/600x600?text=Kantor+Desa'
            ),
            'logo'              => $identitas->logo_desa ? $this->resolveGambar($identitas->logo_desa, 'logo-desa') : null,
        ];

        // 2. Variabel $statistik (Satu deklarasi)
        $statistik = [
            ['label' => 'Total Penduduk', 'value' => Penduduk::where('status_hidup', 'hidup')->count(), 'icon' => 'users'],
            ['label' => 'Laki-laki',      'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count(), 'icon' => 'user'],
            ['label' => 'Perempuan',      'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count(), 'icon' => 'user'],
            ['label' => 'Total Keluarga', 'value' => Keluarga::count(), 'icon' => 'home'],
        ];

        // 3. Variabel $artikelTerbaru (Satu deklarasi)
        $artikelTerbaru = Artikel::latest('created_at')->take(3)->get()->map(function ($item) {
            return [
                'id'       => $item->id,
                'title'    => $item->nama,
                'excerpt'  => Str::limit(strip_tags($item->deskripsi ?? ''), 100),
                'date'     => $item->created_at->format('Y-m-d'),
                'category' => 'Berita',
                'image'    => $this->resolveGambar($item->gambar, 'artikel', 'https://via.placeholder.com/400x300?text=Berita'),
                'author'   => 'Admin',
            ];
        });

        // 4. Variabel $perangkatUtama (Satu deklarasi sesuai orderedByUrutan)
        $perangkatUtama = PerangkatDesa::with('jabatan')
            ->whereHas('jabatan', fn($q) => $q->whereIn('nama', ['Kepala Desa', 'Sekretaris Desa']))
            ->where('status', '1')
            ->orderBy('urutan')
            ->get()->map(function($p) {
                return [
                    'nama'   => $p->nama,
                    'posisi' => $p->jabatan->nama ?? '-',
                    'foto'   => $p->foto ? asset('storage/' . $p->foto) : 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=10b981&color=fff&size=500'
                ];
            });

        // 5. Variabel $anggaranChart (Data lengkap untuk Transparansi Desa)
        $totalAnggaran = Apbdes::sum('anggaran') ?? 0;
        $sumberDana = collect();
        try {
            if (Schema::hasTable('sumber_dana')) {
                $sumberDana = Apbdes::join('sumber_dana', 'apbdes.sumber_dana_id', '=', 'sumber_dana.id')
                    ->select('sumber_dana.nama_sumber', DB::raw('sum(apbdes.anggaran) as total'))
                    ->groupBy('sumber_dana.nama_sumber')->get();
            }
        } catch (\Exception $e) {}

        $anggaranChart = [
            'total'  => 'Rp ' . number_format($totalAnggaran, 0, ',', '.'),
            'tahun'  => date('Y'),
            'detail' => $sumberDana,
        ];

        // 6. Variabel $agendaTerbaru (Logika agenda untuk Widget Kanan)
        $agendaTerbaru = collect();
        try {
            if (Schema::hasTable('agenda')) {
                $agendaTerbaru = DB::table('agenda')
                    ->where('tgl_agenda', '>=', now())
                    ->orderBy('tgl_agenda', 'asc')
                    ->take(4)
                    ->get()
                    ->map(fn($item) => [
                        'tanggal' => Carbon::parse($item->tgl_agenda)->isoFormat('D'),
                        'bulan'   => Carbon::parse($item->tgl_agenda)->isoFormat('MMM'),
                        'judul'   => $item->keterangan ?? 'Kegiatan Desa',
                        'lokasi'  => $item->lokasi_kegiatan ?? 'Balai Desa',
                    ]);
            }
        } catch (\Exception $e) {}

        // 7. Return (Satu return, kirim semua variabel yang diminta Blade)
        return view('frontend.pages.home', compact(
            'desaInfo', 'statistik', 'artikelTerbaru',
            'perangkatUtama', 'anggaranChart', 'agendaTerbaru'
        ));
    }

/*
    |--------------------------------------------------------------------------
    | BERITA / ARTIKEL
    |--------------------------------------------------------------------------
    */

    public function berita(Request $request)
    {
        $query = Artikel::query();

        // Filter Pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        // Filter Kategori (Jika ada parameter kategori di URL)
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('slug_kategori', $request->kategori); // Asumsi kolom kategori ada
        }

        $artikels = $query->latest('created_at')->paginate(9);

        // Ambil Kategori untuk filter di Blade
        $kategoriBlog = ['semua' => 'Semua'];
        try {
            if (Schema::hasTable('kategori_kontens')) {
                $db = KategoriKonten::where('status', 'aktif')->pluck('nama_kategori', 'slug')->toArray();
                $kategoriBlog = array_merge($kategoriBlog, $db);
            }
        } catch (\Exception $e) {}

        // Format data untuk x-article-card di index.blade.php
        $artikelList = collect($artikels->items())->map(function ($item) {
            return [
                'id'       => $item->id,
                'title'    => $item->nama,
                'excerpt'  => Str::limit(strip_tags($item->deskripsi ?? ''), 120),
                'date'     => $item->created_at,
                'category' => 'Berita',
                'image'    => $this->resolveGambar($item->gambar, 'artikel', 'https://via.placeholder.com/400x300?text=Berita'),
                'author'   => 'Admin',
            ];
        });

        // Untuk widget "Sedang Hangat" di sidebar
        $artikelTerbaru = $artikelList->take(3);

        return view('frontend.pages.artikel.index', compact(
            'artikels', 'kategoriBlog', 'artikelList', 'artikelTerbaru'
        ));
    }

    public function artikelShow($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Format ke Object agar sinkron dengan $artikel->title di show.blade.php
        $artikelFormatted = (object) [
            'id'      => $artikel->id,
            'title'   => $artikel->nama,
            'content' => $artikel->deskripsi,
            'excerpt' => Str::limit(strip_tags($artikel->deskripsi ?? ''), 150),
            'date'    => $artikel->created_at,
            'image'   => $this->resolveGambar($artikel->gambar, 'artikel', 'https://via.placeholder.com/800x400?text=Berita'),
            'author'  => 'Admin',
            'category'=> 'Berita',
        ];

        // Artikel Terkait untuk sidebar "Baca Juga"
        $artikelTerkait = Artikel::where('id', '!=', $id)->latest()->take(4)->get()->map(function ($item) {
            return [
                'id'    => $item->id,
                'title' => $item->nama,
                'image' => $this->resolveGambar($item->gambar, 'artikel', 'https://via.placeholder.com/100'),
                'date'  => $item->created_at,
            ];
        });

        $komentars = KomentarArtikel::where('artikel_id', $id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('frontend.pages.artikel.show', [
            'artikel'        => $artikelFormatted,
            'artikelTerkait' => $artikelTerkait,
            'komentars'      => $komentars,
        ]);
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'email'        => 'required|email|max:255',
            'isi_komentar' => 'required|string|max:1000',
        ]);

        KomentarArtikel::create([
            'artikel_id'   => $id,
            'nama'         => $request->nama,
            'email'        => $request->email,
            'isi_komentar' => $request->isi_komentar,
            'status'       => 'pending',
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Komentar Anda berhasil dikirim dan sedang menunggu moderasi.');
    }

/*
    |--------------------------------------------------------------------------
    | PROFIL / IDENTITAS DESA
    |--------------------------------------------------------------------------
    */

    public function profil()
    {
        $identitas = $this->getIdentitasDesa();

        // 1. Variabel $profil (Data lengkap untuk index.blade.php)
        $profil = [
            'nama_desa'     => $identitas->nama_desa ?? 'Nama Desa Belum Diatur',
            'kode_desa'     => $identitas->kode_desa ?? '-',
            'kecamatan'     => $identitas->kecamatan ?? '-',
            'kabupaten'     => $identitas->kabupaten ?? '-',
            'provinsi'      => $identitas->provinsi ?? '-',
            'email_desa'    => $identitas->email_desa ?? 'Belum diatur',
            'telepon_desa'  => $identitas->telepon_desa ?? 'Belum diatur',
            'ponsel_desa'   => $identitas->ponsel_desa ?? 'Belum diatur',
            'alamat_kantor' => $identitas->alamat_kantor ?? 'Alamat belum diatur',
            'gambar_kantor' => $this->resolveGambar(
                $identitas->gambar_kantor, 
                'gambar-kantor', 
                'https://via.placeholder.com/800x400?text=Foto+Kantor'
            ),
            'latitude'      => $identitas->latitude,
            'longitude'     => $identitas->longitude,
            'link_peta'     => $identitas->link_peta ?? "https://www.google.com/maps?q={$identitas->latitude},{$identitas->longitude}&z=15&output=embed",
        ];

        // 2. Variabel $deskripsi (Digunakan di paragraf profil)
        $deskripsi = "Desa " . ($identitas->nama_desa ?? 'Kami') . " adalah desa yang terletak di Kecamatan "
            . ($identitas->kecamatan ?? '-') . ", Kabupaten " . ($identitas->kabupaten ?? '-')
            . ". Desa ini memiliki potensi sumber daya alam dan sumber daya manusia yang unggul.";

        // 3. Variabel $visiMisi (Array misi harus ada agar tidak error forelse)
        $visiMisi = [
            'visi' => $identitas->visi ?? 'Terwujudnya Desa yang Maju, Mandiri, dan Sejahtera Berlandaskan Gotong Royong.',
            'misi' => [
                'Mewujudkan pemerintahan desa yang jujur, transparan, dan akuntabel.',
                'Meningkatkan kualitas pelayanan publik dan administrasi kependudukan.',
                'Mendorong pembangunan infrastruktur yang merata dan berkelanjutan.',
                'Mengembangkan potensi ekonomi lokal melalui UMKM dan BUMDes.',
            ],
        ];

        return view('frontend.pages.identitas-desa.index', compact(
            'profil', 
            'deskripsi', 
            'visiMisi'
        ));
    }

    public function profilKepalaDesa()
    {
        $identitas = $this->getIdentitasDesa();
        
        // Ambil data Kades asli dari tabel PerangkatDesa
        $dataKades = PerangkatDesa::with('jabatan')
            ->whereHas('jabatan', fn($q) => $q->where('nama', 'Kepala Desa'))
            ->where('status', '1')
            ->first();

        // 1. Variabel $kepalaDesa (Data untuk kepala-desa.blade.php)
        $kepalaDesa = [
            'nama'             => $dataKades->nama ?? 'Nama Belum Diatur',
            'nip'              => $dataKades->no_sk ?? '-',
            'tempat_lahir'     => $dataKades->tempat_lahir ?? '-',
            'tanggal_lahir'    => $dataKades->tanggal_lahir ?? now(),
            'agama'            => $dataKades->agama ?? '-',
            'pendidikan'       => $dataKades->pendidikan ?? '-',
            'pengalaman_kerja' => $dataKades->pengalaman ?? 'Memiliki pengalaman dalam memimpin dan melayani masyarakat desa.',
            'riwayat_jabatan'  => [
                'Kepala Desa ' . ($identitas->nama_desa ?? 'Desa'),
                'Tokoh Masyarakat Desa',
            ],
        ];

        // 2. Variabel $program_unggulan (Dibutuhkan oleh looping @foreach di Blade)
        $program_unggulan = [
            'Digitalisasi Pelayanan Desa (Layanan Mandiri)',
            'Pemberdayaan UMKM & Ekonomi Kreatif',
            'Pembangunan Infrastruktur Berkelanjutan',
            'Transparansi Dana Desa & Akuntabilitas Publik',
        ];

        return view('frontend.pages.profil.kepala-desa', compact(
            'identitas',
            'kepalaDesa',
            'program_unggulan'
        ));
    }

/*
    |--------------------------------------------------------------------------
    | PEMERINTAHAN
    |--------------------------------------------------------------------------
    */

    public function pemerintahan()
    {
        // 1. Ambil Semua Perangkat Desa yang aktif (Golongan Pemerintah Desa)
        // Kita gunakan eager loading 'jabatan' agar data jabatan muncul di Blade
        $perangkat = PerangkatDesa::with('jabatan')
            ->whereHas('jabatan', function($q) {
                $q->where('golongan', 'pemerintah_desa');
            })
            ->where('status', '1')
            ->orderBy('urutan')
            ->get();

        // 2. Memilah jabatan secara spesifik untuk layout struktur organisasi di Blade
        
        // Ambil Kepala Desa (Hanya satu)
        $kades = $perangkat->first(fn($p) => str_contains(strtolower($p->jabatan->nama ?? ''), 'kepala desa'));
        
        // Ambil Sekretaris Desa (Hanya satu)
        $sekdes = $perangkat->first(fn($p) => str_contains(strtolower($p->jabatan->nama ?? ''), 'sekretaris desa'));
        
        // Ambil Kasi dan Kaur (Semua yang mengandung kata 'seksi' atau 'urusan')
        $kasiKaur = $perangkat->filter(function($p) {
            $jabatan = strtolower($p->jabatan->nama ?? '');
            return str_contains($jabatan, 'seksi') || str_contains($jabatan, 'urusan');
        })->values();

        // Ambil Kepala Dusun (Semua yang mengandung kata 'dusun' atau 'kadus')
        $kadus = $perangkat->filter(function($p) {
            $jabatan = strtolower($p->jabatan->nama ?? '');
            return str_contains($jabatan, 'dusun') || str_contains($jabatan, 'kadus');
        })->values();

        // 3. Ambil Data Wilayah untuk section RW dan RT
        // Di-grouping berdasarkan nomor RW agar muncul per baris di Blade
        $wilayahRw = Wilayah::orderBy('rw')->orderBy('rt')->get()->groupBy('rw');

        // 4. Return View dengan semua variabel yang diminta index.blade.php
        return view('frontend.pages.pemerintahan.index', compact(
            'kades', 
            'sekdes', 
            'kasiKaur', 
            'kadus', 
            'wilayahRw'
        ));
    }

    public function bpd()
    {
        // AMBIL ANGGOTA BPD (Hanya Golongan BPD)
        $bpd = PerangkatDesa::with('jabatan')
            ->whereHas('jabatan', function($q) {
                $q->where('golongan', 'bpd');
            })
            ->where('status', '1') // Hanya yang aktif
            ->orderBy('urutan')
            ->get();

        // Pisahkan Ketua, Wakil, Sekretaris, dan Anggota biasa
        $ketuaBpd = $bpd->first(fn($p) => str_contains(strtolower($p->jabatan->nama ?? ''), 'ketua') && !str_contains(strtolower($p->jabatan->nama ?? ''), 'wakil'));
        $wakilKetuaBpd = $bpd->first(fn($p) => str_contains(strtolower($p->jabatan->nama ?? ''), 'wakil ketua'));
        $sekretarisBpd = $bpd->first(fn($p) => str_contains(strtolower($p->jabatan->nama ?? ''), 'sekretaris'));
        
        $anggotaBpd = $bpd->filter(function($p) {
            $jabatan = strtolower($p->jabatan->nama ?? '');
            return str_contains($jabatan, 'anggota');
        })->values();

        // Informasi seputar BPD
        $tugasFungsi = [
            'Membahas dan menyepakati Rancangan Peraturan Desa bersama Kepala Desa',
            'Menampung dan menyalurkan aspirasi masyarakat desa',
            'Melakukan pengawasan kinerja Kepala Desa',
            'Mengevaluasi pelaksanaan Anggaran Pendapatan dan Belanja Desa (APBDes)'
        ];

        return view('frontend.pages.bpd.index', compact(
            'ketuaBpd', 'wakilKetuaBpd', 'sekretarisBpd', 'anggotaBpd', 'tugasFungsi'
        ));
    }

    public function kemasyarakatan()
    {
        // Mengambil kategori lembaga (PKK, Karang Taruna, LPM, dll)
        $kategoriLembaga = DB::table('kelompok_master')
            ->orderBy('id', 'asc')
            ->get();

        // Mengambil data spesifik kelompok/pengurus yang aktif
        // dan mengelompokkannya berdasarkan id_kelompok_master
        $dataKelompok = DB::table('kelompok')
            ->where('aktif', '1')
            ->get()
            ->groupBy('id_kelompok_master');

        return view('frontend.pages.kemasyarakatan.index', compact('kategoriLembaga', 'dataKelompok'));
    }

/*
    |--------------------------------------------------------------------------
    | DATA DESA / DEMOGRAFI
    |--------------------------------------------------------------------------
    */

    public function dataDesa()
    {
        // 1. Ambil Data Dasar
        $identitas = $this->getIdentitasDesa();
        $totalPenduduk = Penduduk::where('status_hidup', 'hidup')->count();
        $lakiLaki = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count();
        $perempuan = Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count();
        $totalKeluarga = Keluarga::count();
        $luasWilayah = $identitas->luas_wilayah ?? 0;

        // 2. Hitung Persen Jenis Kelamin (Penting untuk Grafik di Blade)
        $persenLaki = $totalPenduduk > 0 ? round(($lakiLaki / $totalPenduduk) * 100, 1) : 0;
        $persenPerempuan = $totalPenduduk > 0 ? round(($perempuan / $totalPenduduk) * 100, 1) : 0;

        // 3. Helper untuk Format Data Chart (Label, Total, Persen)
        $formatChart = function($dataArray) use ($totalPenduduk) {
            $result = [];
            foreach($dataArray as $label => $total) {
                $result[] = [
                    'label'  => $label,
                    'total'  => $total,
                    'persen' => $totalPenduduk > 0 ? round(($total / $totalPenduduk) * 100, 1) : 0
                ];
            }
            return $result;
        };

        // 4. Distribusi Usia
        $usiaDataRaw = [
            '0-14 Tahun' => Penduduk::where('status_hidup', 'hidup')->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 14')->count(),
            '15-64 Tahun' => Penduduk::where('status_hidup', 'hidup')->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 64')->count(),
            '65+ Tahun'  => Penduduk::where('status_hidup', 'hidup')->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 65')->count(),
        ];
        $usiaData = $formatChart($usiaDataRaw);

        // 5. Tingkat Pendidikan
        $pendidikanDataRaw = Penduduk::where('status_hidup', 'hidup')
            ->select('pendidikan', DB::raw('count(*) as total'))
            ->groupBy('pendidikan')->orderBy('total', 'desc')->get()
            ->pluck('total', 'pendidikan')->toArray();
        $pendidikanData = $formatChart($pendidikanDataRaw);

        // 6. Mata Pencaharian (Pekerjaan)
        $pekerjaanDataRaw = Penduduk::where('status_hidup', 'hidup')
            ->select('pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('pekerjaan')->orderBy('total', 'desc')->get()
            ->pluck('total', 'pekerjaan')->toArray();
        
        // Ubah key pekerjaan agar lebih rapi (hilangkan underscore)
        $pekerjaanClean = [];
        foreach($pekerjaanDataRaw as $key => $val) {
            $label = ucwords(str_replace('_', ' ', $key ?: 'Lainnya'));
            $pekerjaanClean[$label] = $val;
        }
        $pekerjaanData = $formatChart($pekerjaanClean);

        // 7. Agama
        $agamaDataRaw = Penduduk::where('status_hidup', 'hidup')
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')->orderBy('total', 'desc')->get()
            ->pluck('total', 'agama')->toArray();
        $agamaData = $formatChart($agamaDataRaw);

        // 8. Return View dengan variabel yang tepat
        return view('frontend.pages.demografi.index', [
            'totalPenduduk'   => $totalPenduduk,
            'lakiLaki'        => $lakiLaki,
            'perempuan'       => $perempuan,
            'persenLaki'      => $persenLaki,
            'persenPerempuan' => $persenPerempuan,
            'totalKeluarga'   => $totalKeluarga,
            'luasWilayah'     => $luasWilayah,
            'usiaData'        => $usiaData,
            'pendidikanData'  => $pendidikanData,
            'pekerjaanData'   => $pekerjaanData,
            'agamaData'       => $agamaData,
        ]);
    }

 /*
    |--------------------------------------------------------------------------
    | WILAYAH
    |--------------------------------------------------------------------------
    */

    public function wilayah()
    {
        // 1. Ambil semua data wilayah
        $wilayahRecords = Wilayah::all();

        // 2. Statistik Ringkasan (Kombinasi data unik dan sum)
        $statistik = [
            ['label' => 'Total Dusun',    'value' => $wilayahRecords->unique('dusun')->count(), 'icon' => 'map',   'color' => 'emerald'],
            ['label' => 'Total RW',       'value' => $wilayahRecords->unique('rw')->count(),    'icon' => 'users', 'color' => 'blue'],
            ['label' => 'Total RT',       'value' => $wilayahRecords->count(),                  'icon' => 'home',  'color' => 'amber'],
            ['label' => 'Total Penduduk', 'value' => $wilayahRecords->sum('jumlah_penduduk'),   'icon' => 'user',  'color' => 'rose'],
        ];

        // 3. Grouping Data Bersarang (Dusun -> RW -> RT)
        // Pastikan key yang diminta Blade (nama_dusun, data_rw, rt_list) tersedia
        $wilayahList = $wilayahRecords->groupBy('dusun')->map(function ($dusunGroup, $dusunName) {
            return [
                'nama_dusun'      => $dusunName ?: 'Dusun Utama',
                'jumlah_rw'       => $dusunGroup->unique('rw')->count(),
                'jumlah_rt'       => $dusunGroup->count(),
                'jumlah_penduduk' => $dusunGroup->sum('jumlah_penduduk'),
                
                // Grouping RW di dalam Dusun tersebut
                'data_rw' => $dusunGroup->groupBy('rw')->map(function ($rwGroup, $rwName) {
                    return [
                        'nama_rw'         => $rwName,
                        'ketua_rw'        => $rwGroup->first()->ketua_rw ?? 'Belum Diatur',
                        'jumlah_kk'       => $rwGroup->sum('jumlah_kk'),
                        'jumlah_penduduk' => $rwGroup->sum('jumlah_penduduk'),
                        'rt_list'         => $rwGroup // Berisi koleksi data RT (nomor rt, ketua_rt, dll)
                    ];
                })
            ];
        })->values();

        return view('frontend.pages.wilayah.index', compact('statistik', 'wilayahList'));
    }

    public function wilayahShow($id)
    {
        // Ambil satu record wilayah sebagai representasi dusun
        $dataWilayah = Wilayah::findOrFail($id);
        $namaDusun = $dataWilayah->dusun;

        // Ambil semua RT/RW yang berada di dusun yang sama
        $allInDusun = Wilayah::where('dusun', $namaDusun)->get();

        // 1. Format Variabel $wilayah (Object/Array untuk show.blade.php)
        $wilayah = [
            'nama'            => 'Dusun ' . ($namaDusun ?: 'Utama'),
            'deskripsi'       => 'Wilayah administratif ' . ($namaDusun ?: 'Pusat Desa') . ' yang mencakup koordinasi pelayanan warga di tingkat RW dan RT.',
            'kepala_dusun'    => $dataWilayah->ketua_rw ?? 'Masyarakat Desa', // Fallback jika tidak ada kolom Kadus
            'luas_wilayah'    => ($dataWilayah->luas_wilayah ?? '0') . ' Ha',
            'jumlah_penduduk' => $allInDusun->sum('jumlah_penduduk'),
            'jumlah_kk'       => $allInDusun->sum('jumlah_kk'),
        ];

        // 2. Format Variabel $rwRt (Untuk tabel di bagian bawah detail)
        $rwRt = $allInDusun->map(function($item) {
            return [
                'nomor_rw'        => $item->rw,
                'nomor_rt'        => $item->rt,
                'ketua_rt'        => $item->ketua_rt ?? 'Belum Diatur',
                'alamat_umum'     => $item->alamat ?? 'Lingkungan Dusun',
                'jumlah_kk'       => $item->jumlah_kk ?? 0,
                'jumlah_penduduk' => $item->jumlah_penduduk ?? 0,
            ];
        });

        return view('frontend.pages.wilayah.show', compact('wilayah', 'rwRt'));
    }


/*
    |--------------------------------------------------------------------------
    | APBD / TRANSPARANSI KEUANGAN
    |--------------------------------------------------------------------------
    */

    public function apbd(Request $request)
    {
        // 1. Ambil Tahun Aktif dari Database atau Request
        $tahunAktif = DB::table('tahun_anggaran')
            ->where('status', 'aktif')
            ->orderBy('tahun', 'desc')
            ->first();

        // Jika user memilih tahun di dropdown, gunakan itu. Jika tidak, gunakan tahun aktif.
        $tahun = $request->get('tahun', $tahunAktif ? $tahunAktif->tahun : date('Y'));

        // Ambil ID Tahun tersebut untuk memfilter data APBDes
        $tahunId = DB::table('tahun_anggaran')->where('tahun', $tahun)->value('id');

        // 2. Data Ringkasan Utama (Top Cards)
        // Pastikan filter tahun_id digunakan agar data akurat sesuai tahun yang dipilih
        $totalPendapatan = Apbdes::where('tahun_id', $tahunId)->where('kategori', 'pendapatan')->sum('anggaran') ?? 0;
        $totalBelanja = Apbdes::where('tahun_id', $tahunId)->where('kategori', 'belanja')->sum('anggaran') ?? 0;
        
        // 3. Hitung Realisasi Belanja (Penyebab Error Sebelumnya)
        // Kita join dengan tabel realisasi_anggaran
        $realisasiBelanja = DB::table('realisasi_anggaran')
            ->join('apbdes', 'realisasi_anggaran.apbdes_id', '=', 'apbdes.id')
            ->where('apbdes.tahun_id', $tahunId)
            ->where('apbdes.kategori', 'belanja')
            ->sum('realisasi_anggaran.jumlah') ?? 0;

        // 4. Hitung Sisa dan Progress (Untuk Bar Indikator di Blade)
        $sisaAnggaran = $totalBelanja - $realisasiBelanja;
        $progressPersen = $totalBelanja > 0 ? round(($realisasiBelanja / $totalBelanja) * 100, 1) : 0;

        // 5. Rincian Sumber Pendapatan (Untuk Section Kiri)
        $sumberPendapatan = DB::table('apbdes')
            ->join('sumber_dana', 'apbdes.sumber_dana_id', '=', 'sumber_dana.id')
            ->where('apbdes.tahun_id', $tahunId)
            ->where('apbdes.kategori', 'pendapatan')
            ->select('sumber_dana.nama_sumber', DB::raw('SUM(apbdes.anggaran) as total'))
            ->groupBy('sumber_dana.nama_sumber')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function($item) use ($totalPendapatan) {
                // Tambahkan key 'persen' agar Blade bisa merender bar progress
                $item->persen = $totalPendapatan > 0 ? round(($item->total / $totalPendapatan) * 100, 1) : 0;
                return $item;
            });

        // 6. Rincian Alokasi Belanja per Bidang (Untuk Section Kanan)
        $alokasiBelanja = DB::table('apbdes')
            ->join('kegiatan_anggaran', 'apbdes.kegiatan_id', '=', 'kegiatan_anggaran.id')
            ->join('bidang_anggaran', 'kegiatan_anggaran.bidang_id', '=', 'bidang_anggaran.id')
            ->where('apbdes.tahun_id', $tahunId)
            ->where('apbdes.kategori', 'belanja')
            ->select('bidang_anggaran.nama_bidang', DB::raw('SUM(apbdes.anggaran) as total'))
            ->groupBy('bidang_anggaran.nama_bidang')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function($item) use ($totalBelanja) {
                // Tambahkan key 'persen' untuk ditampilkan di badge kartu belanja
                $item->persen = $totalBelanja > 0 ? round(($item->total / $totalBelanja) * 100, 1) : 0;
                return $item;
            });

        // 7. Ambil Daftar Tahun untuk Dropdown Filter
        $daftarTahun = DB::table('tahun_anggaran')->orderBy('tahun', 'desc')->pluck('tahun');

        // 8. Return dengan data lengkap tanpa duplikasi
        return view('frontend.pages.apbd.index', compact(
            'tahun', 
            'totalPendapatan', 
            'totalBelanja', 
            'realisasiBelanja', 
            'sisaAnggaran', 
            'progressPersen', 
            'sumberPendapatan', 
            'alokasiBelanja', 
            'daftarTahun'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | KONTAK & PENGADUAN
    |--------------------------------------------------------------------------
    */

    public function kontak()
    {
        $identitas = $this->getIdentitasDesa();

        $infoKontak = [
            'alamat'           => $identitas->alamat_kantor ?? 'Alamat belum diatur',
            'telepon'          => $identitas->telepon_desa ?? $identitas->ponsel_desa ?? '-',
            'email'            => $identitas->email_desa ?? '-',
            'jam_operasional'  => 'Senin - Kamis (08.00 - 16.00), Jumat (08.00 - 14.00)',
            'latitude'         => $identitas->latitude ?? '-6.200000',
            'longitude'        => $identitas->longitude ?? '106.816666',
            'link_peta'        => $identitas->link_peta
                ?? "https://www.google.com/maps?q={$identitas->latitude},{$identitas->longitude}&z=15&output=embed",
        ];

        $departemen = [
            [
                'nama'              => 'Pelayanan Umum & Administrasi',
                'penanggung_jawab'  => 'Sekretariat Desa',
                'telepon'           => $identitas->telepon_desa ?? '-',
                'email'             => $identitas->email_desa ?? '-',
            ],
        ];

        return view('frontend.pages.kontak.index', compact('infoKontak', 'departemen'));
    }

    public function storeKontak(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|max:255',
            'subjek' => 'required|string|max:200',
            'pesan'  => 'required|string',
        ]);

        Pengaduan::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'subjek'     => $request->subjek,
            'isi'        => $request->pesan,
            'ip_address' => $request->ip(),
            'status'     => Pengaduan::STATUS_BARU,
        ]);

        return redirect()->route('kontak')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }

    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */

    public function faq()
    {
        $faqs = [
            'Layanan Administrasi & Surat' => [
                [
                    'tanya' => 'Apa saja jenis surat yang bisa diurus di kantor desa?',
                    'jawab' => 'Kami melayani pembuatan berbagai dokumen administrasi, antara lain: Surat Keterangan Domisili, Surat Keterangan Usaha (SKU), Surat Keterangan Tidak Mampu (SKTM), Surat Pengantar SKCK, Surat Keterangan Kelahiran, Surat Keterangan Kematian, Surat Keterangan Janda/Duda, dan Surat Pengantar Nikah (N1-N4).',
                ],
                [
                    'tanya' => 'Apakah bisa mengurus surat secara online melalui website ini?',
                    'jawab' => 'Ya, website ini dilengkapi fitur Layanan Mandiri. Warga yang NIK-nya sudah terdaftar dapat mengajukan permohonan surat melalui menu "Layanan Surat" (login diperlukan), mengisi formulir yang dibutuhkan, dan memantau status suratnya hingga siap diambil.',
                ],
                [
                    'tanya' => 'Berapa lama proses pembuatan surat?',
                    'jawab' => 'Untuk permohonan langsung di kantor, estimasi 10-15 menit jika berkas lengkap dan pejabat penandatangan ada di tempat. Untuk permohonan online, maksimal 1x24 jam pada hari kerja.',
                ],
                [
                    'tanya' => 'Apakah ada biaya untuk pembuatan surat?',
                    'jawab' => 'Tidak ada. Seluruh layanan administrasi kependudukan dan surat-menyurat di Pemerintah Desa tidak dipungut biaya (GRATIS).',
                ],
                [
                    'tanya' => 'Dokumen apa yang harus dibawa saat mengurus surat?',
                    'jawab' => 'Secara umum, Anda wajib membawa KTP asli dan Kartu Keluarga (KK) asli/fotokopi. Untuk surat khusus (surat tanah, nikah, dll), mungkin diperlukan dokumen pendukung lain seperti PBB, surat pengantar RT/RW, atau akta cerai.',
                ],
            ],
            'Bantuan Sosial (Bansos)' => [
                [
                    'tanya' => 'Apa saja bantuan sosial yang dikelola oleh desa?',
                    'jawab' => 'Desa mengelola Bantuan Langsung Tunai (BLT) Dana Desa. Selain itu, desa juga memfasilitasi pendataan dan verifikasi untuk bantuan dari pemerintah pusat/daerah seperti PKH (Program Keluarga Harapan), BPNT (Sembako), dan BST.',
                ],
                [
                    'tanya' => 'Bagaimana cara mendaftar agar mendapatkan bantuan?',
                    'jawab' => 'Pengusulan data penerima bantuan dilakukan melalui Musyawarah Dusun (Musdus) yang kemudian diputuskan dalam Musyawarah Desa (Musdes). Jika Anda merasa layak namun belum terdata, silakan lapor ke Ketua RT/RW setempat untuk diusulkan dalam musyawarah berikutnya.',
                ],
                [
                    'tanya' => 'Bagaimana cara mengecek apakah saya terdaftar sebagai penerima bantuan?',
                    'jawab' => 'Anda dapat mengecek daftar penerima bantuan melalui menu "Data Desa" atau "Transparansi" di website ini, atau mengecek langsung di papan pengumuman Balai Desa. Anda juga bisa mengecek di situs cekbansos.kemensos.go.id.',
                ],
            ],
            'Sistem Website Desa' => [
                [
                    'tanya' => 'Apa fungsi utama website desa ini?',
                    'jawab' => 'Website ini berfungsi sebagai: (1) Pusat Informasi (Berita, Pengumuman, Agenda). (2) Media Transparansi (APBDes, Data Penduduk). (3) Sarana Pelayanan Publik (Layanan Surat Online, Pengaduan Masyarakat). (4) Promosi Potensi Desa.',
                ],
                [
                    'tanya' => 'Bagaimana cara mendapatkan akun untuk Login Warga?',
                    'jawab' => 'Untuk keamanan data, pendaftaran akun Layanan Mandiri dilakukan secara manual. Silakan datang ke kantor desa membawa KTP dan KK untuk didaftarkan NIK-nya oleh operator desa agar bisa mengakses fitur khusus warga.',
                ],
                [
                    'tanya' => 'Apakah data penduduk di website ini aman?',
                    'jawab' => 'Ya, kami sangat menjaga privasi data. Data yang ditampilkan di halaman publik hanya berupa statistik agregat (jumlah/angka) tanpa menampilkan nama dan alamat rinci.',
                ],
                [
                    'tanya' => 'Saya lupa PIN/Password akun saya, apa yang harus dilakukan?',
                    'jawab' => 'Silakan hubungi admin desa melalui nomor WhatsApp yang tertera di menu "Kontak" untuk melakukan reset PIN/Password.',
                ],
            ],
            'Pengaduan & Aspirasi' => [
                [
                    'tanya' => 'Saya punya usulan pembangunan atau keluhan pelayanan, lapor kemana?',
                    'jawab' => 'Anda bisa menyampaikan aspirasi atau pengaduan melalui menu "Kontak" di website ini (isi formulir pengaduan). Anda juga bisa menyampaikannya secara langsung melalui Ketua RT/RW atau datang ke kantor desa.',
                ],
                [
                    'tanya' => 'Apakah identitas pelapor akan dirahasiakan?',
                    'jawab' => 'Ya, kami menjamin kerahasiaan identitas pelapor jika Anda meminta untuk dirahasiakan, terutama untuk pengaduan yang bersifat sensitif.',
                ],
                [
                    'tanya' => 'Berapa lama pengaduan akan direspon?',
                    'jawab' => 'Setiap pengaduan yang masuk melalui website akan diverifikasi oleh admin dalam waktu 1x24 jam dan diteruskan ke perangkat desa terkait untuk ditindaklanjuti sesegera mungkin.',
                ],
            ],
            'Informasi Umum' => [
                [
                    'tanya' => 'Jam berapa pelayanan kantor desa buka?',
                    'jawab' => 'Senin - Kamis: 08.00 - 16.00 WIB. Jumat: 08.00 - 14.00 WIB. Sabtu, Minggu, dan Hari Libur Nasional: Tutup.',
                ],
                [
                    'tanya' => 'Dimana lokasi kantor desa?',
                    'jawab' => 'Lokasi kantor desa dapat dilihat pada peta di menu "Wilayah" atau "Kontak". Alamat lengkap juga tersedia di bagian bawah (footer) website ini.',
                ],
            ],
        ];

        return view('frontend.pages.faq.index', compact('faqs'));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPAK
    |--------------------------------------------------------------------------
    */

    public function lapak(Request $request)
    {
        $query = Lapak::with('penduduk')
            ->withCount('produkAktif')
            ->where('status', 'aktif'); 

        if ($request->filled('search')) {
            $query->where('nama_toko', 'like', '%' . $request->search . '%');
        }

        $lapakList = $query->latest()->paginate(12);

        return view('frontend.pages.lapak.index', compact('lapakList'));
    }

    public function lapakShow($slug)
    {
        $lapak = Lapak::where('slug', $slug)
            ->where('status', 'aktif')
            ->with('penduduk')
            ->firstOrFail();

        $produk = $lapak->produkAktif()->paginate(12);

        return view('frontend.pages.lapak.show', compact('lapak', 'produk'));
    }
}