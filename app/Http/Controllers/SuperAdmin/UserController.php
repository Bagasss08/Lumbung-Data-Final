<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        // Memfilter data: Hanya ambil user dengan role superadmin, admin, atau operator
        $users = Users::whereIn('role', ['superadmin', 'admin', 'operator'])
            ->latest()
            ->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    public function create() {
        return view('superadmin.users.create');
    }

    public function store(Request $request) {
        // Logika untuk menyimpan user baru ke database
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil ditambahkan!');
    }
}
