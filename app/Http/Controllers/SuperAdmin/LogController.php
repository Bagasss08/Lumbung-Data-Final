<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // Karena di struktur Anda belum ada view untuk log, kita arahkan ke view dummy atau Anda bisa buat filenya nanti.
        return view('superadmin.logs.index'); 
    }
}