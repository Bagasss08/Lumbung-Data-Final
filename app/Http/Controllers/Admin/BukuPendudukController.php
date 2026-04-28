<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuPendudukController extends Controller
{
    public function index()
    {
        // Mengarah ke: resources/views/admin/buku-administrasi/penduduk.blade.php
        return view('admin.buku-administrasi.penduduk');
    }
}