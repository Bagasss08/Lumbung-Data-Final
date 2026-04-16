<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Program extends Model {
    protected $table = 'program';

    protected $fillable = [
        'nama',
        'asal_dana',   // ← ganti
        'keterangan',
        'sasaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'publikasi',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_selesai'  => 'date',
        'nominal'          => 'decimal:2',
        'status'           => 'boolean',
        'publikasi'        => 'boolean',
    ];

    /**
     * Relasi: Program memiliki banyak peserta
     */
    public function peserta() {
        return $this->hasMany(ProgramPeserta::class, 'program_id');
    }

    /**
     * Accessor: Label untuk sasaran
     * 1 = Penduduk, 0 = Keluarga
     */
    public function getSasaranLabelAttribute(): string {
        return $this->sasaran == 1 ? 'Penduduk' : 'Keluarga';
    }

    /**
     * Accessor: Label untuk status
     * 1 = Aktif, 0 = Tidak Aktif
     */
    public function getStatusLabelAttribute(): string {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Accessor: Label untuk publikasi
     * 1 = Publik, 0 = Hanya Admin
     */
    public function getPublikasiLabelAttribute(): string {
        return $this->publikasi == 1 ? 'Publik' : 'Hanya Admin';
    }

    /**
     * Scope: Filter program berdasarkan status, sasaran, dan search
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, Request $request) {
        // Filter berdasarkan status
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->boolean('status'));
        }

        // Filter berdasarkan sasaran
        if ($request->has('sasaran') && $request->input('sasaran') !== '') {
            $query->where('sasaran', $request->input('sasaran'));
        }

        // Search berdasarkan nama dan keterangan
        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
