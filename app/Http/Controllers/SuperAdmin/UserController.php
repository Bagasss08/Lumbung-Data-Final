<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function index() {
        $users = Users::whereIn('role', ['superadmin', 'admin', 'operator'])
            ->latest()
            ->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    public function create() {
        return view('superadmin.users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:superadmin,admin,operator',
        ]);

        Users::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id) {
        $user = Users::findOrFail($id);
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = Users::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:superadmin,admin,operator',
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
            ...($request->filled('password') ? ['password' => bcrypt($request->password)] : []),
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil diperbarui!');
    }
}
