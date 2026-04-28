<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoDesaController extends Controller
{
    public function pemerintahDesa()
    {
        return view('admin.pemerintah-desa');
    }

    public function lembaga()
    {
        return view('admin.lembaga');
    }

    public function statusDesa()
    {
        return view('admin.status-desa');
    }

    public function layananPelanggan()
    {
        return view('admin.layanan-pelanggan');
    }

    public function kerjasama()
    {
        return view('admin.kerjasama');
    }
}
