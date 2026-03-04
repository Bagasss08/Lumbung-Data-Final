<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller {
    public function index() {
        return view('admin.profil.index');
    }

    public function update(Request $request) {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|max:100|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'no_hp'    => 'nullable|string|max:20',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only(['name', 'username', 'email', 'no_hp']);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'new_password.min'          => 'Password minimal 8 karakter.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
    }
}
