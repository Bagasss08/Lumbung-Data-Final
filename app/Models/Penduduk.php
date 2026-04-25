<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Penduduk — Lumbung Data
 *
 * Pemetaan ke OpenSID tweb_penduduk.
 *
 * Catatan perbedaan yang disengaja vs OpenSID:
 * - Nama tabel          : 'penduduk'        (OpenSID: tweb_penduduk)
 * - FK keluarga         : 'keluarga_id'     (OpenSID: id_kk)
 * - FK wilayah          : 'wilayah_id'      (OpenSID: id_cluster)
 * - NIK ayah/ibu        : 'nik_ayah'/'nik_ibu' (OpenSID: ayah_nik/ibu_nik)
 * - Telepon             : 'no_telp'         (OpenSID: telepon)
 * - Alamat              : 'alamat'          (OpenSID: alamat_sekarang)
 * - jenis_kelamin       : enum('L','P')     (OpenSID: sex tinyint 1/2)
 * - status_hidup        : string enum       (OpenSID: integer 1/2/3/4/5/6)
 * - SoftDeletes         : dipakai           (OpenSID: hard delete + log_penduduk_hapus)
 * - jenis_tambah        : kolom custom      (OpenSID: tidak ada, dicatat di log_penduduk)
 * - tgl_peristiwa       : kolom custom      (OpenSID: tidak ada)
 * - tgl_terdaftar       : kolom custom      (OpenSID: tidak ada)
 * - kolom _lama         : kolom custom      (OpenSID: disimpan di log_penduduk)
 *
 * Catatan pemetaan asuransi:
 * OpenSID punya DUA kolom: id_asuransi (FK) + no_asuransi (nomor kartu).
 * Di sini: 'asuransi_id' (FK) + 'no_asuransi' (nomor kartu) — semantik sama.
 *
 * Relasi RTM:
 * Tidak ada pivot rumah_tangga_penduduk. Akses RTM via rantai:
 * Penduduk → keluarga() → RumahTangga (sesuai pola OpenSID).
 */
class Penduduk extends Model {
    use SoftDeletes;

    protected $table = 'penduduk';

    protected $fillable = [
        // --- Identitas Utama ---
        'nik',
        'is_nik_sementara', // true = NIK belum resmi (checkbox di form tambah penduduk)
        'foto',
        'tag_id_card',
        'nama',
        'nama_ayah',
        'nama_ibu',
        'nik_ayah',         // OpenSID: ayah_nik
        'nik_ibu',          // OpenSID: ibu_nik      

        // --- Demografi ---
        'jenis_kelamin',    // OpenSID: sex (tinyint 1/2) → di sini enum('L','P')
        'tempat_lahir',
        'tanggal_lahir',
        'waktu_lahir',

        // --- Relasi Keluarga & Wilayah ---
        'keluarga_id',      // OpenSID: id_kk → FK ke keluarga.id
        'kk_level',         // SHDK — nilai integer, FK ke ref_shdk.id
        'wilayah_id',       // OpenSID: id_cluster → FK ke wilayah.id

        // --- Status ---
        'status',           // integer: 1=Tetap, 2=TidakTetap, 3=Pendatang
        'status_hidup',     // string: hidup|mati|pindah|hilang|pergi|tidak_valid (DULU: status_dasar)
        'jenis_tambah',     // string: lahir|masuk (custom, tidak ada di OpenSID)

        // --- Referensi Master (FK integer) ---
        'agama_id',
        'pendidikan_kk_id',
        'pendidikan_sedang_id',
        'pekerjaan_id',
        'golongan_darah_id',
        'status_kawin_id',
        'warganegara_id',
        'cacat_id',
        'sakit_menahun_id',
        'cara_kb_id',
        'asuransi_id',      // OpenSID: id_asuransi
        'bahasa_id',

        // --- KTP Elektronik ---
        'ktp_el',
        'status_rekam',
        'tempat_cetak_ktp',
        'tanggal_cetak_ktp',

        // --- Perkawinan ---
        'akta_perkawinan',
        'tanggal_perkawinan',
        'akta_perceraian',
        'tanggal_perceraian',

        // --- Detail Kelahiran ---
        'tempat_dilahirkan',
        'jenis_kelahiran',
        'kelahiran_anak_ke',
        'penolong_kelahiran',
        'berat_lahir',
        'panjang_lahir',
        'akta_lahir',

        // --- Kesehatan ---
        'hamil',
        'no_asuransi',      // nomor kartu asuransi (OpenSID: no_asuransi)

        // --- Dokumen Keimigrasian ---
        'dokumen_pasport',
        'tanggal_akhir_paspor',
        'dokumen_kitas',
        'negara_asal',

        // --- Kontak & Alamat ---
        'no_telp',          // OpenSID: telepon
        'email',
        'alamat',           // OpenSID: alamat_sekarang
        'alamat_sebelumnya',
        'no_kk_sebelumnya',

        // --- Lain-lain ---
        'tgl_peristiwa',    // custom
        'tgl_terdaftar',    // custom
        'keterangan',       // OpenSID: ket

        // --- Nilai lama (custom — OpenSID simpan di log_penduduk) ---
        'golongan_darah_lama',
        'agama_lama',
        'pendidikan_lama',
        'pekerjaan_lama',
        'status_kawin_lama',
        'kewarganegaraan_lama',

        'lat',
        'lng',
    ];

    protected $casts = [
        'tanggal_lahir'        => 'date',
        'tanggal_cetak_ktp'    => 'date',
        'tanggal_perkawinan'   => 'date',
        'tanggal_perceraian'   => 'date',
        'tanggal_akhir_paspor' => 'date',
        'tgl_peristiwa'        => 'date',
        'tgl_terdaftar'        => 'date',
        'berat_lahir'          => 'float',
        'panjang_lahir'        => 'float',
        'is_nik_sementara'     => 'boolean',
        'hamil'                => 'boolean',
        'ktp_el'               => 'boolean',
        'kk_level'             => 'integer',
        'status'               => 'integer',
        'agama_id'             => 'integer',
        'pendidikan_kk_id'     => 'integer',
        'pendidikan_sedang_id' => 'integer',
        'pekerjaan_id'         => 'integer',
        'golongan_darah_id'    => 'integer',
        'status_kawin_id'      => 'integer',
        'warganegara_id'       => 'integer',
        'cacat_id'             => 'integer',
        'sakit_menahun_id'     => 'integer',
        'cara_kb_id'           => 'integer',
        'asuransi_id'          => 'integer',
        'bahasa_id'            => 'integer',
        'deleted_at'           => 'datetime',
    ];

    // =========================================================================
    // KONSTANTA — STATUS DASAR
    // Sengaja pakai string (berbeda dengan OpenSID yg integer 1/2/3/4/5/6)
    // agar lebih readable di codebase Laravel.
    // Mapping ke OpenSID: hidup=1, mati=2, pindah=3, hilang=4, pergi=5, tidak_valid=6
    // =========================================================================

    public const STATUS_DASAR_HIDUP       = 'hidup';        // OpenSID: 1
    public const STATUS_DASAR_MATI        = 'mati';         // OpenSID: 2
    public const STATUS_DASAR_PINDAH      = 'pindah';       // OpenSID: 3
    public const STATUS_DASAR_HILANG      = 'hilang';       // OpenSID: 4
    public const STATUS_DASAR_PERGI       = 'pergi';        // OpenSID: 5
    public const STATUS_DASAR_TIDAK_VALID = 'tidak_valid';  // OpenSID: 6

    public const STATUS_DASAR_LABEL = [
        self::STATUS_DASAR_HIDUP       => 'Hidup',
        self::STATUS_DASAR_MATI        => 'Meninggal',
        self::STATUS_DASAR_PINDAH      => 'Pindah',
        self::STATUS_DASAR_HILANG      => 'Hilang',
        self::STATUS_DASAR_PERGI       => 'Pergi',
        self::STATUS_DASAR_TIDAK_VALID => 'Tidak Valid',
    ];

    // =========================================================================
    // KONSTANTA — STATUS (Jenis Penduduk)
    // =========================================================================

    public const STATUS_TETAP       = 1;
    public const STATUS_TIDAK_TETAP = 2;
    public const STATUS_PENDATANG   = 3;

    public const STATUS_LABEL = [
        self::STATUS_TETAP       => 'Tetap',
        self::STATUS_TIDAK_TETAP => 'Tidak Tetap',
        self::STATUS_PENDATANG   => 'Pendatang',
    ];

    // =========================================================================
    // KONSTANTA — SHDK (kk_level)
    // Sesuai data OpenSID tweb_penduduk_hubungan
    // =========================================================================

    public const SHDK_KEPALA_KELUARGA = 1;
    public const SHDK_ISTRI           = 2;  // bukan Suami — format KK Indonesia
    public const SHDK_ANAK            = 3;
    public const SHDK_MENANTU         = 4;
    public const SHDK_CUCU            = 5;
    public const SHDK_ORANG_TUA       = 6;
    public const SHDK_MERTUA          = 7;
    public const SHDK_FAMILI_LAIN     = 8;
    public const SHDK_PEMBANTU        = 9;
    public const SHDK_LAINNYA         = 10;

    public const SHDK_LABEL = [
        self::SHDK_KEPALA_KELUARGA => 'Kepala Keluarga',
        self::SHDK_ISTRI           => 'Istri',
        self::SHDK_ANAK            => 'Anak',
        self::SHDK_MENANTU         => 'Menantu',
        self::SHDK_CUCU            => 'Cucu',
        self::SHDK_ORANG_TUA       => 'Orang Tua',
        self::SHDK_MERTUA          => 'Mertua',
        self::SHDK_FAMILI_LAIN     => 'Famili Lain',
        self::SHDK_PEMBANTU        => 'Pembantu',
        self::SHDK_LAINNYA         => 'Lainnya',
    ];

    // =========================================================================
    // KONSTANTA — JENIS TAMBAH (custom, tidak ada di OpenSID)
    // =========================================================================

    public const JENIS_TAMBAH_LAHIR = 'lahir';
    public const JENIS_TAMBAH_MASUK = 'masuk';

    // =========================================================================
    // KONSTANTA — KTP
    // =========================================================================

    // ktp_el: 0=Non-Elektronik, 1=Elektronik
    // status_rekam: sesuai kode Dukcapil
    public const STATUS_REKAM_LABEL = [
        1  => 'Belum Rekam',
        2  => 'Sudah Rekam',
        3  => 'Rekam Sebagian',
        4  => 'Diterbitkan',
    ];

    // =========================================================================
    // NIK SEMENTARA
    // Format OpenSID: '0' + kode_desa (10 digit) + urutan (5 digit)
    // Contoh: 0 + 3301012001 + 00001 = 0330101200100001 (16 digit total)
    // Sumber kode desa: config('app.kode_desa') atau tabel pengaturan
    // =========================================================================

    /**
     * Generate NIK sementara berikutnya.
     * Pastikan config 'app.kode_desa' sudah diisi (10 digit).
     * Contoh di config/app.php: 'kode_desa' => '3301012001'
     */
    public static function generateNikSementara(): string {
        $kodeDesa = config('app.kode_desa', '0000000000');

        // Pastikan kode desa tepat 10 digit
        $kodeDesa = str_pad(substr($kodeDesa, 0, 10), 10, '0', STR_PAD_LEFT);

        // Cari urutan tertinggi NIK sementara yang sudah ada
        $prefix  = '0' . $kodeDesa; // 11 karakter awalan
        $lastNik = static::withTrashed()
            ->where('nik', 'like', $prefix . '%')
            ->orderByRaw('CAST(nik AS UNSIGNED) DESC')
            ->value('nik');

        if ($lastNik) {
            // Ambil 5 digit terakhir sebagai urutan
            $lastUrutan = (int) substr($lastNik, 11, 5);
            $urutan     = $lastUrutan + 1;
        } else {
            $urutan = 1;
        }

        if ($urutan > 99999) {
            throw new \RuntimeException('NIK sementara sudah mencapai batas maksimum (99999).');
        }

        return $prefix . str_pad($urutan, 5, '0', STR_PAD_LEFT); // total 16 digit
    }

    /**
     * Apakah NIK ini sementara?
     * Format NIK sementara: diawali '0' (tidak mungkin NIK resmi diawali 0)
     */
    public function getIsNikSementaraAttribute(): bool {
        return str_starts_with((string) $this->nik, '0');
    }

    // =========================================================================
    // RELASI — REFERENSI MASTER
    // =========================================================================

    public function agama() {
        return $this->belongsTo(\App\Models\Ref\RefAgama::class, 'agama_id');
    }

    public function pendidikanKk() {
        return $this->belongsTo(\App\Models\Ref\RefPendidikan::class, 'pendidikan_kk_id');
    }

    public function pendidikanSedang() {
        return $this->belongsTo(\App\Models\Ref\RefPendidikan::class, 'pendidikan_sedang_id');
    }

    public function pekerjaan() {
        return $this->belongsTo(\App\Models\Ref\RefPekerjaan::class, 'pekerjaan_id');
    }

    public function golonganDarah() {
        return $this->belongsTo(\App\Models\Ref\RefGolonganDarah::class, 'golongan_darah_id');
    }

    public function statusKawin() {
        return $this->belongsTo(\App\Models\Ref\RefStatusKawin::class, 'status_kawin_id');
    }

    public function warganegara() {
        return $this->belongsTo(\App\Models\Ref\RefWarganegara::class, 'warganegara_id');
    }

    public function cacat() {
        return $this->belongsTo(\App\Models\Ref\RefCacat::class, 'cacat_id');
    }

    public function sakitMenahun() {
        return $this->belongsTo(\App\Models\Ref\RefSakitMenahun::class, 'sakit_menahun_id');
    }

    public function caraKb() {
        return $this->belongsTo(\App\Models\Ref\RefCaraKb::class, 'cara_kb_id');
    }

    public function asuransi() {
        return $this->belongsTo(\App\Models\Ref\RefAsuransi::class, 'asuransi_id');
    }

    public function bahasa() {
        return $this->belongsTo(\App\Models\Ref\RefBahasa::class, 'bahasa_id');
    }

    public function shdk() {
        return $this->belongsTo(\App\Models\Ref\RefShdk::class, 'kk_level');
    }

    // =========================================================================
    // RELASI — DATA UTAMA
    // =========================================================================

    public function keluarga() {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function wilayah() {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function user() {
        return $this->hasOne(Users::class, 'penduduk_id');
    }

    public function layananMandiri() {
        return $this->hasOne(\App\Models\LayananMandiri::class, 'penduduk_id');
    }

    // -------------------------------------------------------------------------
    // Relasi orang tua — lookup via NIK, bukan via ID
    // Catatan: bisa null kalau nik_ayah/nik_ibu tidak terdaftar di sistem
    // -------------------------------------------------------------------------

    /** Ayah — lookup via nik_ayah → nik */
    public function ayah() {
        return $this->belongsTo(Penduduk::class, 'nik_ayah', 'nik');
    }

    /** Ibu — lookup via nik_ibu → nik */
    public function ibu() {
        return $this->belongsTo(Penduduk::class, 'nik_ibu', 'nik');
    }

    // -------------------------------------------------------------------------
    // Relasi anak — dibagi dua karena Eloquent tidak mendukung OR di hasMany
    // Gunakan getAnakAttribute() kalau butuh hasil gabungan
    // -------------------------------------------------------------------------

    /** Anak yang tercatat NIK ayah-nya = NIK penduduk ini */
    public function anakViaAyah() {
        return $this->hasMany(Penduduk::class, 'nik_ayah', 'nik');
    }

    /** Anak yang tercatat NIK ibu-nya = NIK penduduk ini */
    public function anakViaIbu() {
        return $this->hasMany(Penduduk::class, 'nik_ibu', 'nik');
    }

    /**
     * Accessor: semua anak (via ayah ATAU ibu) — kembalikan Collection.
     * Pakai ini untuk tampil di view, bukan untuk eager loading massal.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAnakAttribute() {
        return Penduduk::where('nik_ayah', $this->nik)
            ->orWhere('nik_ibu', $this->nik)
            ->get();
    }

    // -------------------------------------------------------------------------
    // Akses Rumah Tangga — via rantai Penduduk → Keluarga → RumahTangga
    // Tidak ada pivot langsung; sesuai pola OpenSID.
    // -------------------------------------------------------------------------

    /**
     * Rumah Tangga penduduk ini, diakses via keluarga.
     * Gunakan: $penduduk->keluarga->rumahTangga
     *
     * Atau via helper ini untuk kenyamanan:
     */
    public function getRumahTanggaAttribute(): ?RumahTangga {
        return $this->keluarga?->rumahTangga;
    }

    // =========================================================================
    // RELASI — KESEHATAN
    // =========================================================================

    public function kiaAsIbu() {
        return $this->hasMany(Kia::class, 'penduduk_id_ibu');
    }

    public function kiaAsAnak() {
        return $this->hasMany(Kia::class, 'penduduk_id_anak');
    }

    public function vaksins() {
        return $this->hasMany(Vaksin::class, 'penduduk_id');
    }

    // =========================================================================
    // RELASI — KELOMPOK
    // =========================================================================

    public function kelompokAnggota() {
        return $this->hasMany(\App\Models\KelompokAnggota::class, 'nik', 'nik');
    }

    public function kelompokAktif() {
        return $this->hasMany(\App\Models\KelompokAnggota::class, 'nik', 'nik')
            ->where('aktif', '1');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /** Penduduk aktif (status_hidup = hidup) — dipakai di hampir semua query */
    public function scopeHidup($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_HIDUP);
    }

    /** Alias scopeHidup — untuk konsistensi pemanggilan */
    public function scopeWargaAktif($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_HIDUP);
    }

    public function scopeMati($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_MATI);
    }

    public function scopePindah($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_PINDAH);
    }

    public function scopeHilang($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_HILANG);
    }

    public function scopePergi($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_PERGI);
    }

    public function scopeTidakValid($query) {
        return $query->where('status_hidup', self::STATUS_DASAR_TIDAK_VALID);
    }

    /**
     * Penduduk yang sudah tidak aktif — tampil di Catatan Peristiwa.
     * Mencakup: mati, pindah, hilang, pergi, tidak_valid.
     */
    public function scopeNonAktif($query) {
        return $query->whereIn('status_hidup', [
            self::STATUS_DASAR_MATI,
            self::STATUS_DASAR_PINDAH,
            self::STATUS_DASAR_HILANG,
            self::STATUS_DASAR_PERGI,
            self::STATUS_DASAR_TIDAK_VALID,
        ]);
    }

    /** Filter jenis penduduk */
    public function scopeTetap($query) {
        return $query->where('status', self::STATUS_TETAP);
    }

    public function scopeTidakTetap($query) {
        return $query->where('status', self::STATUS_TIDAK_TETAP);
    }

    public function scopePendatang($query) {
        return $query->where('status', self::STATUS_PENDATANG);
    }

    /** Hanya Kepala Keluarga */
    public function scopeKepalaKeluarga($query) {
        return $query->where('kk_level', self::SHDK_KEPALA_KELUARGA);
    }

    /** NIK sementara (diawali '0') */
    public function scopeNikSementara($query) {
        return $query->where('nik', 'like', '0%');
    }

    /** NIK resmi (tidak diawali '0') */
    public function scopeNikResmi($query) {
        return $query->where('nik', 'not like', '0%');
    }

    /** Penduduk lahir pada tahun tertentu */
    public function scopeLahirTahun($query, int $tahun) {
        return $query->whereYear('tanggal_lahir', $tahun);
    }

    /**
     * Filter berdasarkan jenis kelamin.
     * Kolom jenis_kelamin menggunakan enum('L','P'), bukan integer.
     */
    public function scopeLakiLaki($query) {
        return $query->where('jenis_kelamin', 'L');
    }

    public function scopePerempuan($query) {
        return $query->where('jenis_kelamin', 'P');
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /** Hitung umur dari tanggal_lahir */
    public function getUmurAttribute(): ?int {
        return $this->tanggal_lahir
            ? (int) $this->tanggal_lahir->diffInYears(now())
            : null;
    }

    /** Apakah penduduk ini masih aktif (belum mati/pindah/hilang/pergi/tidak_valid)? */
    public function getIsAktifAttribute(): bool {
        return $this->status_hidup === self::STATUS_DASAR_HIDUP;
    }

    /**
     * Wajib KTP?
     * Sesuai OpenSID: umur >= 17 ATAU sudah pernah kawin (status_kawin_id != 1)
     * Asumsi ref_status_kawin: 1 = Belum Kawin
     */
    public function getWajibKtpAttribute(): bool {
        if ($this->umur !== null && $this->umur >= 17) {
            return true;
        }
        // Semua status kawin selain "Belum Kawin" (id=1) dianggap wajib KTP
        if ($this->status_kawin_id && $this->status_kawin_id !== 1) {
            return true;
        }
        return false;
    }

    /** Label status_hidup (Dulu status_dasar) */
    public function getLabelStatusDasarAttribute(): string {
        return self::STATUS_DASAR_LABEL[$this->status_hidup] ?? '-';
    }

    /** Label status (jenis penduduk) */
    public function getLabelStatusAttribute(): string {
        return self::STATUS_LABEL[$this->status] ?? '-';
    }

    /** Label kk_level (SHDK) */
    public function getLabelShdkAttribute(): string {
        return self::SHDK_LABEL[$this->kk_level] ?? '-';
    }

    /** Label jenis_tambah */
    public function getLabelJenisTambahAttribute(): string {
        return match ($this->jenis_tambah) {
            self::JENIS_TAMBAH_LAHIR => 'Lahir',
            self::JENIS_TAMBAH_MASUK => 'Datang / Masuk',
            default                  => '-',
        };
    }

    /** URL foto publik, fallback ke placeholder */
    public function getFotoUrlAttribute(): string {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/avatar-placeholder.png');
    }
}