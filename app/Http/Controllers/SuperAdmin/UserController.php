<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function index() {
        $users = Users::whereIn('role', ['superadmin', 'admin'])
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
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:superadmin,admin',
        ]);

        Users::create([
            'name'     => $request->name,
            'username' => $request->username,
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
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:superadmin,admin',
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
            ...($request->filled('password') ? ['password' => bcrypt($request->password)] : []),
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Method Destroy untuk menghapus data user.
     * Ditambahkan untuk memperbaiki BadMethodCallException.
     */
    public function destroy($id) {
        $user = Users::findOrFail($id);

        // FITUR KEAMANAN: Mencegah penghapusan akun yang sedang digunakan login
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Keamanan Sistem: Anda tidak diizinkan menghapus akun Anda sendiri saat sedang aktif.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil dihapus dari sistem!');
    }
}
