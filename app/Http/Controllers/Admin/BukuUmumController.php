<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuUmumController extends Controller
{
    /**
     * Menampilkan halaman dasbor menu Buku Administrasi Umum
     */
    public function index()
    {
        // Ubah dari 'admin.buku.umum.umum' menjadi:
        return view('admin.buku-administrasi.umum');
    }
}