<?php

namespace App\Http\Controllers;

use App\Models\LapakProduk;
use App\Models\LapakProdukReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapakProdukReviewController extends Controller
{
    public function store(Request $request, LapakProduk $produk)
    {
        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('review', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['lapak_produk_id'] = $produk->id;

        LapakProdukReview::create($validated);

        return back()->with('success', 'Review berhasil dikirim!');
    }
}
