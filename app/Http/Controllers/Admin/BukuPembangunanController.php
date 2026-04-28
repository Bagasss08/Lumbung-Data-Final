<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuPembangunanController extends Controller
{
    public function index()
    {
        // Mengarah ke file: resources/views/admin/buku-administrasi/pembangunan.blade.php
        return view('admin.buku-administrasi.pembangunan');
    }
}