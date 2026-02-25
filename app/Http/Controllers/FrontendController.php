<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

// --- LIST MODEL YANG DIGUNAKAN ---
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Wilayah;
use App\Models\Artikel;
use App\Models\IdentitasDesa;
use App\Models\DataPerangkatDesa; 
use App\Models\AsetDesa;          
use App\Models\Apbdes;
use App\Models\KategoriKonten;
use App\Models\Pengaduan;
use App\Models\Lapak;

class FrontendController extends Controller
{
    private function getIdentitasDesa()
    {
        return IdentitasDesa::first() ?? new IdentitasDesa();
    }

    public function home()
    {
        $identitas = $this->getIdentitasDesa();

        // 1. PERBAIKAN PATH GAMBAR DESA
        $desaInfo = [
            'nama_desa' => $identitas->nama_desa ?? 'Nama Desa Belum Diisi',
            'kecamatan' => $identitas->kecamatan ?? '-',
            'kabupaten' => $identitas->kabupaten ?? '-',
            'provinsi' => $identitas->provinsi ?? '-',
            'email_desa' => $identitas->email_desa ?? '-',
            'telepon_desa' => $identitas->telepon_desa ?? '-',
            'alamat_kantor' => $identitas->alamat_kantor ?? '-',
            'deskripsi_singkat' => 'Selamat datang di portal resmi transformasi digital Pemerintah Desa. Kami hadir untuk mendekatkan pelayanan publik melalui akses informasi yang transparan, layanan administrasi surat-menyurat yang cepat dan efisien, serta keterbukaan data pembangunan desa. Mari bersama-sama mewujudkan tata kelola pemerintahan yang modern, akuntabel, dan partisipatif demi kemajuan dan kesejahteraan desa.',
            
            // Perbaikan: Tambahkan path 'gambar-kantor/' sesuai struktur upload
            'gambar_kantor' => ($identitas->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/' . $identitas->gambar_kantor))) 
                ? asset('storage/gambar-kantor/' . $identitas->gambar_kantor) 
                : 'https://via.placeholder.com/600x600?text=Kantor+Desa',
            
            // Perbaikan: Tambahkan path 'logo-desa/' sesuai struktur upload
            'logo' => ($identitas->logo_desa && file_exists(storage_path('app/public/logo-desa/' . $identitas->logo_desa))) 
                ? asset('storage/logo-desa/' . $identitas->logo_desa) 
                : null,
        ];

        $statistik = [
            ['label' => 'Total Penduduk', 'value' => Penduduk::where('status_hidup', 'hidup')->count(), 'icon' => 'users', 'color' => 'emerald'],
            ['label' => 'Laki-laki', 'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count(), 'icon' => 'user', 'color' => 'blue'],
            ['label' => 'Perempuan', 'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count(), 'icon' => 'user', 'color' => 'rose'],
            ['label' => 'Total Keluarga', 'value' => Keluarga::count(), 'icon' => 'home', 'color' => 'amber'],
        ];

        // 2. PERBAIKAN PATH GAMBAR ARTIKEL
        $artikelQuery = Artikel::latest('created_at')->take(3)->get();
        $artikelTerbaru = $artikelQuery->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->nama,
                'excerpt' => Str::limit(strip_tags($item->deskripsi), 100),
                'date' => $item->created_at->format('Y-m-d'),
                'category' => 'Berita',
                // Asumsi: Gambar artikel disimpan di folder 'artikel'
                'image' => ($item->gambar && file_exists(storage_path('app/public/artikel/' . $item->gambar)))
                    ? asset('storage/artikel/' . $item->gambar) 
                    : 'https://via.placeholder.com/400x300?text=Berita',
                'author' => 'Admin'
            ];
        });

        $perangkatQuery = DataPerangkatDesa::whereIn('jabatan', ['kades', 'sekdes'])->where('status', 'aktif')->get();
        $perangkatUtama = $perangkatQuery->map(function($p) {
            return [
                'nama' => $p->nama,
                'posisi' => $this->formatJabatan($p->jabatan),
                // Gunakan avatar default jika foto perangkat belum ada fiturnya
                'foto' => 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=10b981&color=fff&size=500'
            ];
        });

        $tahunIni = date('Y');
        $totalAnggaran = Apbdes::sum('anggaran'); 
        $sumberDana = Apbdes::join('sumber_dana', 'apbdes.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('sumber_dana.nama_sumber', DB::raw('sum(apbdes.anggaran) as total'))
            ->groupBy('sumber_dana.nama_sumber')
            ->get();

        $anggaranChart = [
            'total' => 'Rp ' . number_format($totalAnggaran, 0, ',', '.'),
            'tahun' => $tahunIni,
            'detail' => $sumberDana
        ];

        $agendaTerbaru = DB::table('agenda')
            ->where('tgl_agenda', '>=', now())
            ->orderBy('tgl_agenda', 'asc')
            ->take(4)
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => Carbon::parse($item->tgl_agenda)->isoFormat('D'),
                    'bulan' => Carbon::parse($item->tgl_agenda)->isoFormat('MMM'),
                    'judul' => $item->keterangan ?? 'Kegiatan Desa',
                    'lokasi' => $item->lokasi_kegiatan ?? 'Balai Desa',
                    'koordinator' => $item->koordinator_kegiatan
                ];
            });

        return view('frontend.pages.home', compact('desaInfo', 'statistik', 'artikelTerbaru', 'perangkatUtama', 'anggaranChart', 'agendaTerbaru'));
    }

    public function berita(Request $request)
    {
        $query = Artikel::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $artikels = $query->latest('created_at')->paginate(9);

        $kategoriBlog = KategoriKonten::where('status', 'aktif')->pluck('nama_kategori', 'slug')->toArray();
        $kategoriBlog = array_merge(['semua' => 'Semua'], $kategoriBlog);

        $artikelList = collect($artikels->items())->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->nama,
                'excerpt' => Str::limit(strip_tags($item->deskripsi), 120),
                'date' => $item->created_at->format('Y-m-d'),
                'category' => 'Berita',
                // PERBAIKAN PATH GAMBAR ARTIKEL
                'image' => ($item->gambar && file_exists(storage_path('app/public/artikel/' . $item->gambar)))
                    ? asset('storage/artikel/' . $item->gambar) 
                    : 'https://via.placeholder.com/400x300?text=Berita',
                'author' => 'Admin',
                'views' => 0, 
            ];
        });

        $artikelTerbaru = $artikelList->take(3);

        return view('frontend.pages.artikel.index', compact('artikels', 'kategoriBlog', 'artikelList', 'artikelTerbaru'));
    }

    public function artikelShow($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        $artikelFormatted = (object) [
            'id' => $artikel->id,
            'title' => $artikel->nama,
            'content' => $artikel->deskripsi, 
            'date' => $artikel->created_at,
            // PERBAIKAN PATH GAMBAR ARTIKEL
            'image' => ($artikel->gambar && file_exists(storage_path('app/public/artikel/' . $artikel->gambar)))
                ? asset('storage/artikel/' . $artikel->gambar) 
                : null,
            'author' => 'Admin',
            'category' => 'Berita'
        ];

        $artikelTerbaru = Artikel::latest()->take(4)->get()->map(function($item){
            return [
                'id' => $item->id,
                'title' => $item->nama,
                // PERBAIKAN PATH GAMBAR ARTIKEL
                'image' => ($item->gambar && file_exists(storage_path('app/public/artikel/' . $item->gambar)))
                    ? asset('storage/artikel/' . $item->gambar) 
                    : 'https://via.placeholder.com/100',
                'views' => 0,
                'date' => $item->created_at
            ];
        });

        return view('frontend.pages.artikel.show', [
            'artikel' => $artikelFormatted,
            'artikels' => $artikelTerbaru 
        ]);
    }

    public function profil()
    {
        $identitas = $this->getIdentitasDesa();

        $profil = [
            'nama_desa' => $identitas->nama_desa,
            'kode_desa' => $identitas->kode_desa,
            'kecamatan' => $identitas->kecamatan,
            'kabupaten' => $identitas->kabupaten,
            'provinsi' => $identitas->provinsi,
            'email_desa' => $identitas->email_desa ?? 'Belum diatur',
            'telepon_desa' => $identitas->telepon_desa ?? 'Belum diatur',
            'alamat_kantor' => $identitas->alamat_kantor,
            
            // PERBAIKAN PATH GAMBAR KANTOR
            'gambar_kantor' => ($identitas->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/' . $identitas->gambar_kantor))) 
                ? asset('storage/gambar-kantor/' . $identitas->gambar_kantor) 
                : 'https://via.placeholder.com/800x400?text=Foto+Kantor',
            
            'latitude' => $identitas->latitude,
            'longitude' => $identitas->longitude,
            'link_peta' => $identitas->link_peta ?? "https://www.google.com/maps?q={$identitas->latitude},{$identitas->longitude}&z=15&output=embed",
        ];

        $deskripsi = "Desa " . ($identitas->nama_desa ?? 'Kami') . " adalah desa yang terletak di Kecamatan " . ($identitas->kecamatan ?? '-') . ", Kabupaten " . ($identitas->kabupaten ?? '-') . ". Desa ini memiliki potensi sumber daya alam dan sumber daya manusia yang unggul.";

        $infoDesa = [
            ['label' => 'Penduduk', 'value' => Penduduk::where('status_hidup', 'hidup')->count(), 'icon' => 'users'],
            ['label' => 'Keluarga', 'value' => Keluarga::count(), 'icon' => 'home'],
            ['label' => 'Wilayah Dusun', 'value' => Wilayah::count(), 'icon' => 'map'],
            ['label' => 'Luas Wilayah', 'value' => ($identitas->luas_wilayah ?? 0) . ' Ha', 'icon' => 'globe'],
        ];

        $visiMisi = [
            'visi' => 'Terwujudnya Desa yang Maju, Mandiri, dan Sejahtera Berlandaskan Gotong Royong.',
            'misi' => [
                'Mewujudkan pemerintahan desa yang jujur, transparan, dan akuntabel.',
                'Meningkatkan kualitas pelayanan publik dan administrasi kependudukan.',
                'Mendorong pembangunan infrastruktur yang merata dan berkelanjutan.',
                'Mengembangkan potensi ekonomi lokal melalui UMKM dan BUMDes.'
            ]
        ];

        $kades = DataPerangkatDesa::where('jabatan', 'kades')->where('status', 'aktif')->first();
        
        $perangkatLain = DataPerangkatDesa::where('jabatan', '!=', 'kades')
            ->where('status', 'aktif')
            ->orderByRaw("FIELD(jabatan, 'sekdes', 'kasi', 'kaur', 'kadus')")
            ->get()
            ->map(function($p) {
                return [
                    'nama' => $p->nama,
                    'jabatan' => $this->formatJabatan($p->jabatan),
                    'foto' => 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=059669&color=fff'
                ];
            });

        return view('frontend.pages.profil.index', compact(
            'profil', 
            'deskripsi', 
            'infoDesa', 
            'visiMisi', 
            'kades',
            'perangkatLain'
        ));
    }

    public function profilKepalaDesa()
    {
        $identitas = $this->getIdentitasDesa();
        $dataKades = DataPerangkatDesa::where('jabatan', 'kades')->where('status', 'aktif')->first();

        return view('frontend.pages.profil.kepala-desa', [
            'identitas_desa' => $identitas,
            'kades' => $dataKades
        ]);
    }

    public function pemerintahan()
    {
        $perangkat = DataPerangkatDesa::where('status', 'aktif')->get();

        $struktur = [
            [
                'kategori' => 'Pimpinan Desa',
                'anggota' => $perangkat->filter(fn($p) => in_array($p->jabatan, ['kades', 'sekdes']))
                    ->sortBy(fn($p) => $p->jabatan === 'kades' ? 0 : 1)
                    ->map(fn($p) => [
                        'nama' => $p->nama,
                        'posisi' => $this->formatJabatan($p->jabatan),
                        'nip' => $p->no_sk,
                        'status' => 'Aktif',
                        'foto' => 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=059669&color=fff&size=500'
                ])
            ],
            [
                'kategori' => 'Pelaksana Kewilayahan (Kepala Dusun)',
                'anggota' => $perangkat->filter(fn($p) => $p->jabatan == 'kadus')->map(fn($p) => [
                    'nama' => $p->nama,
                    'posisi' => 'Kepala Dusun',
                    'nip' => $p->no_sk,
                    'status' => 'Aktif',
                    'foto' => 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=059669&color=fff&size=500'
                ])
            ],
            [
                'kategori' => 'Pelaksana Teknis & Urusan',
                'anggota' => $perangkat->filter(fn($p) => in_array($p->jabatan, ['kasi', 'kaur']))->map(fn($p) => [
                    'nama' => $p->nama,
                    'posisi' => $this->formatJabatan($p->jabatan),
                    'nip' => $p->no_sk,
                    'status' => 'Aktif',
                    'foto' => 'https://ui-avatars.com/api/?name='.urlencode($p->nama).'&background=059669&color=fff&size=500'
                ])
            ]
        ];

        $pemerintahan = ['struktur' => $struktur];
        $badan_permusyawaratan = []; 

        return view('frontend.pages.pemerintahan.index', compact('pemerintahan', 'badan_permusyawaratan'));
    }

    public function dataDesa()
    {
        $statistikPenduduk = [
            ['label' => 'Total Penduduk', 'value' => Penduduk::where('status_hidup', 'hidup')->count(), 'color' => 'emerald', 'icon' => 'users'],
            ['label' => 'Laki-laki', 'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'L')->count(), 'color' => 'blue', 'icon' => 'user'],
            ['label' => 'Perempuan', 'value' => Penduduk::where('status_hidup', 'hidup')->where('jenis_kelamin', 'P')->count(), 'color' => 'rose', 'icon' => 'user'],
            ['label' => 'Total Keluarga', 'value' => Keluarga::count(), 'color' => 'amber', 'icon' => 'home'],
        ];

        $totalPenduduk = Penduduk::where('status_hidup', 'hidup')->count();

        $pendidikanData = Penduduk::where('status_hidup', 'hidup')
            ->select('pendidikan', DB::raw('count(*) as total'))
            ->groupBy('pendidikan')
            ->orderBy('total', 'desc')
            ->get();
        
        $statistikPendidikan = $pendidikanData->map(function($item) use ($totalPenduduk) {
            return [
                'label' => $item->pendidikan ?? 'Tidak Sekolah',
                'value' => $item->total,
                'persen' => $totalPenduduk > 0 ? round(($item->total / $totalPenduduk) * 100, 1) : 0
            ];
        });

        $pekerjaanData = Penduduk::where('status_hidup', 'hidup')
            ->select('pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->get();

        $statistikPekerjaan = $pekerjaanData->map(function($item) use ($totalPenduduk) {
            return [
                'label' => ucwords(str_replace('_', ' ', $item->pekerjaan)),
                'value' => $item->total,
                'persen' => $totalPenduduk > 0 ? round(($item->total / $totalPenduduk) * 100, 1) : 0
            ];
        });

        $asetDesa = AsetDesa::where('status', 'aktif')->get()->map(function($item){
            return [
                'nama' => $item->nama_aset,
                'deskripsi' => ucfirst($item->jenis_aset) . ' - ' . $item->lokasi,
                'kondisi' => ucfirst($item->kondisi),
                'tahun' => $item->tahun_perolehan,
                'nilai' => 'Rp ' . number_format($item->nilai, 0, ',', '.')
            ];
        });

        $tahunIni = date('Y');
        $totalAnggaran = Apbdes::sum('anggaran');
        
        $sumberDana = Apbdes::join('sumber_dana', 'apbdes.sumber_dana_id', '=', 'sumber_dana.id')
            ->select('sumber_dana.nama_sumber', DB::raw('sum(apbdes.anggaran) as total'))
            ->groupBy('sumber_dana.nama_sumber')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function($item) use ($totalAnggaran) {
                return [
                    'sumber' => $item->nama_sumber,
                    'nilai' => 'Rp ' . number_format($item->total, 0, ',', '.'),
                    'persentase' => $totalAnggaran > 0 ? round(($item->total / $totalAnggaran) * 100, 1) : 0
                ];
            });

        $anggaranDesa = [
            'tahun' => $tahunIni,
            'total_anggaran' => 'Rp ' . number_format($totalAnggaran, 0, ',', '.'),
            'sumber_dana' => $sumberDana
        ];

        $agamaData = Penduduk::where('status_hidup', 'hidup')
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->orderBy('total', 'desc')
            ->get();

        $statistikAgama = $agamaData->map(function($item) use ($totalPenduduk) {
            return [
                'label' => $item->agama,
                'value' => $item->total,
                'persen' => $totalPenduduk > 0 ? round(($item->total / $totalPenduduk) * 100, 1) : 0
            ];
        });

        return view('frontend.pages.data-desa.index', compact(
            'statistikPenduduk',
            'statistikPendidikan',
            'statistikPekerjaan',
            'asetDesa',
            'anggaranDesa',
            'statistikAgama'
        ));
    }

    public function wilayah()
    {
        $wilayahRecords = Wilayah::all();

        $statistik = [
            ['label' => 'Total Dusun', 'value' => $wilayahRecords->unique('dusun')->count(), 'icon' => 'map', 'color' => 'emerald'],
            ['label' => 'Total RW', 'value' => $wilayahRecords->sum('rw'), 'icon' => 'users', 'color' => 'blue'],
            ['label' => 'Total RT', 'value' => $wilayahRecords->sum('rt'), 'icon' => 'home', 'color' => 'amber'],
            ['label' => 'Total Penduduk', 'value' => $wilayahRecords->sum('jumlah_penduduk'), 'icon' => 'user', 'color' => 'rose'],
        ];

        $wilayahList = $wilayahRecords->groupBy('dusun')->map(function ($group) {
            $first = $group->first();
            return [
                'id' => $first->id, 
                'nama' => $first->dusun ?? 'Dusun Tanpa Nama',
                'deskripsi' => "Wilayah administratif Dusun " . ($first->dusun ?? '') . " yang terdiri dari beberapa RW dan RT.",
                'kepala_dusun' => $first->ketua_rw ?? 'Belum Ditentukan', 
                'jumlah_rw' => $group->sum('rw'),
                'jumlah_rt' => $group->sum('rt'),
                'jumlah_penduduk' => $group->sum('jumlah_penduduk'),
            ];
        });

        return view('frontend.pages.wilayah.index', compact('statistik', 'wilayahList'));
    }

    public function wilayahShow($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('frontend.pages.wilayah.show', compact('wilayah'));
    }

    public function kontak()
    {
        $identitas = $this->getIdentitasDesa();

        $infoKontak = [
            'alamat' => $identitas->alamat_kantor ?? 'Alamat belum diatur',
            'telepon' => $identitas->telepon_desa ?? $identitas->ponsel_desa ?? '-',
            'email' => $identitas->email_desa ?? '-',
            'jam_operasional' => 'Senin - Kamis (08.00 - 16.00), Jumat (08.00 - 14.00)', 
            'latitude' => $identitas->latitude,
            'longitude' => $identitas->longitude,
            'link_peta' => $identitas->link_peta ?? "https://www.google.com/maps?q={$identitas->latitude},{$identitas->longitude}&z=15&output=embed",
        ];

        $departemen = [
            [
                'nama' => 'Pelayanan Umum & Administrasi',
                'penanggung_jawab' => 'Sekretariat Desa',
                'telepon' => $identitas->telepon_desa ?? '-',
                'email' => $identitas->email_desa ?? '-'
            ]
        ];

        return view('frontend.pages.kontak.index', compact('infoKontak', 'departemen'));
    }

    public function storeKontak(Request $request) {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:200',
            'pesan' => 'required|string',
        ]);

        Pengaduan::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'subjek'     => $request->subjek,
            'isi'        => $request->pesan,
            'ip_address' => $request->ip(),
            'status'     => Pengaduan::STATUS_BARU,
            // penduduk_id & petugas_id dibiarkan null (pengaduan anonim dari publik)
        ]);

        return redirect()->route('kontak')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda kembali.');
    }

    private function formatJabatan($kode)
    {
        $map = [
            'kades' => 'Kepala Desa',
            'sekdes' => 'Sekretaris Desa',
            'kasi' => 'Kepala Seksi',
            'kaur' => 'Kepala Urusan',
            'kadus' => 'Kepala Dusun'
        ];
        return $map[$kode] ?? ucfirst($kode);
    }

    // ==========================================
    // FUNGSI UNTUK HALAMAN LAPAK (PUBLIK)
    // ==========================================
    public function lapak(Request $request)
    {
        // Pastikan relasi 'penduduk' ikut dipanggil jika ingin menampilkan nama pemiliknya
        $query = Lapak::with('penduduk')->where('status', 'aktif'); 

        // Fitur pencarian
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                // UBAH 'nama_lapak' MENJADI 'nama_toko'
                $q->where('nama_toko', 'like', '%' . $keyword . '%') 
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $lapaks = $query->latest()->paginate(9);

        return view('frontend.pages.lapak.index', compact('lapaks'));
    }

    public function lapakShow($id)
    {
        // Mengambil detail lapak berdasarkan ID
        $lapak = Lapak::findOrFail($id);
        
        // Opsional: Ambil produk dari lapak tersebut jika ada relasinya di model
        // $produk = $lapak->produk()->latest()->get(); 

        return view('frontend.pages.lapak.show', compact('lapak'));
    }

        // Fungsi FAQ yang sudah Anda tambahkan sebelumnya
    // ... kode function faq() kamu sebelumnya ...

    public function faq()
    {
        // Data FAQ Lengkap (Dikelompokkan)
        $faqs = [
            'Layanan Administrasi & Surat' => [
                [
                    'tanya' => 'Apa saja jenis surat yang bisa diurus di kantor desa?',
                    'jawab' => 'Kami melayani pembuatan berbagai dokumen administrasi, antara lain: Surat Keterangan Domisili, Surat Keterangan Usaha (SKU), Surat Keterangan Tidak Mampu (SKTM), Surat Pengantar SKCK, Surat Keterangan Kelahiran, Surat Keterangan Kematian, Surat Keterangan Janda/Duda, dan Surat Pengantar Nikah (N1-N4).'
                ],
                [
                    'tanya' => 'Apakah bisa mengurus surat secara online melalui website ini?',
                    'jawab' => 'Ya, website ini dilengkapi fitur Layanan Mandiri. Warga yang NIK-nya sudah terdaftar dapat mengajukan permohonan surat melalui menu "Layanan Surat" (Login diperlukan), mengisi formulir yang dibutuhkan, dan memantau status suratnya hingga siap diambil.'
                ],
                [
                    'tanya' => 'Berapa lama proses pembuatan surat?',
                    'jawab' => 'Untuk permohonan langsung di kantor, proses estimasi 10-15 menit jika berkas lengkap dan pejabat penandatangan ada di tempat. Untuk permohonan online, maksimal 1x24 jam pada hari kerja.'
                ],
                [
                    'tanya' => 'Apakah ada biaya untuk pembuatan surat?',
                    'jawab' => 'Tidak ada. Seluruh layanan administrasi kependudukan dan surat-menyurat di Pemerintah Desa Serayu Larangan tidak dipungut biaya (GRATIS).'
                ],
                [
                    'tanya' => 'Dokumen apa yang harus dibawa saat mengurus surat?',
                    'jawab' => 'Secara umum, Anda wajib membawa KTP asli dan Kartu Keluarga (KK) asli/fotokopi. Untuk surat khusus (seperti surat tanah, nikah, dll), mungkin diperlukan dokumen pendukung lain seperti PBB, surat pengantar RT/RW, atau akta cerai.'
                ]
            ],
            'Bantuan Sosial (Bansos)' => [
                [
                    'tanya' => 'Apa saja bantuan sosial yang dikelola oleh desa?',
                    'jawab' => 'Desa mengelola Bantuan Langsung Tunai (BLT) Dana Desa. Selain itu, desa juga memfasilitasi pendataan dan verifikasi untuk bantuan dari pemerintah pusat/daerah seperti PKH (Program Keluarga Harapan), BPNT (Sembako), dan BST.'
                ],
                [
                    'tanya' => 'Bagaimana cara mendaftar agar mendapatkan bantuan?',
                    'jawab' => 'Pengusulan data penerima bantuan dilakukan melalui Musyawarah Dusun (Musdus) yang kemudian diputuskan dalam Musyawarah Desa (Musdes). Jika Anda merasa layak namun belum terdata, silakan lapor ke Ketua RT/RW setempat untuk diusulkan dalam musyawarah berikutnya.'
                ],
                [
                    'tanya' => 'Bagaimana cara mengecek apakah saya terdaftar sebagai penerima bantuan?',
                    'jawab' => 'Anda dapat mengecek daftar penerima bantuan melalui menu "Data Desa" atau "Transparansi" di website ini, atau mengecek langsung di papan pengumuman Balai Desa. Anda juga bisa mengecek di situs cekbansos.kemensos.go.id.'
                ]
            ],
            'Sistem Website Desa' => [
                [
                    'tanya' => 'Apa fungsi utama website desa ini?',
                    'jawab' => 'Website ini berfungsi sebagai: 1. Pusat Informasi (Berita, Pengumuman, Agenda). 2. Media Transparansi (APBDes, Data Penduduk). 3. Sarana Pelayanan Publik (Layanan Surat Online, Pengaduan Masyarakat). 4. Promosi Potensi Desa.'
                ],
                [
                    'tanya' => 'Bagaimana cara mendapatkan akun untuk Login Warga?',
                    'jawab' => 'Untuk keamanan data, pendaftaran akun Layanan Mandiri dilakukan secara manual. Silakan datang ke kantor desa membawa KTP dan KK untuk didaftarkan NIK-nya oleh operator desa agar bisa mengakses fitur khusus warga.'
                ],
                [
                    'tanya' => 'Apakah data penduduk di website ini aman?',
                    'jawab' => 'Ya, kami sangat menjaga privasi data. Data yang ditampilkan di halaman publik ("Data Desa") hanya berupa statistik agregat (jumlah/angka) tanpa menampilkan nama dan alamat rinci (by name by address), kecuali untuk data pejabat atau penerima bantuan yang diwajibkan oleh aturan transparansi.'
                ],
                [
                    'tanya' => 'Saya lupa PIN/Password akun saya, apa yang harus dilakukan?',
                    'jawab' => 'Silakan hubungi admin desa melalui nomor WhatsApp yang tertera di menu "Kontak" untuk melakukan reset PIN/Password.'
                ]
            ],
            'Pengaduan & Aspirasi' => [
                [
                    'tanya' => 'Saya punya usulan pembangunan atau keluhan pelayanan, lapor kemana?',
                    'jawab' => 'Anda bisa menyampaikan aspirasi atau pengaduan melalui menu "Kontak" di website ini (isi formulir pengaduan). Anda juga bisa menyampaikannya secara langsung melalui Ketua RT/RW atau datang ke kantor desa.'
                ],
                [
                    'tanya' => 'Apakah identitas pelapor akan dirahasiakan?',
                    'jawab' => 'Ya, kami menjamin kerahasiaan identitas pelapor jika Anda meminta untuk dirahasiakan, terutama untuk pengaduan yang bersifat sensitif.'
                ],
                [
                    'tanya' => 'Berapa lama pengaduan akan direspon?',
                    'jawab' => 'Setiap pengaduan yang masuk melalui website akan diverifikasi oleh admin dalam waktu 1x24 jam dan diteruskan ke perangkat desa terkait untuk ditindaklanjuti sesegera mungkin.'
                ]
            ],
            'Informasi Umum' => [
                [
                    'tanya' => 'Jam berapa pelayanan kantor desa buka?',
                    'jawab' => 'Senin - Kamis: 08.00 - 16.00 WIB. Jumat: 08.00 - 14.00 WIB. Sabtu, Minggu, dan Hari Libur Nasional: Tutup.'
                ],
                [
                    'tanya' => 'Dimana lokasi kantor desa?',
                    'jawab' => 'Lokasi kantor desa dapat dilihat pada peta di menu "Wilayah" atau "Kontak". Alamat lengkap juga tersedia di bagian bawah (footer) website ini.'
                ]
            ]
        ];

        return view('frontend.pages.faq.index', compact('faqs'));
    }
}