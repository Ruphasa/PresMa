<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriModel;

class ProfileController extends Controller
{
    //View user profile
    public function show(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'User Profile',
            'list' => ['achievement', 'Achievement List'],
        ];
        $page = (object) [
            'title' => 'Profil Pengguna',
        ];
        $activeMenu = 'profile'; // set menu yang sedang aktif
        $user = $request->user(); // Ambil data user yang sedang login

        return view('profile.profile', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function edit(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Edit User Profile',
            'list' => ['achievement', 'Achievement List'],
        ];
        $page = (object) [
            'title' => 'Profil Pengguna',
        ];
        $activeMenu = 'profile'; // set menu yang sedang aktif
        $user = $request->user(); // Ambil data user yang sedang login
        $kategori = KategoriModel::all(); // Ambil semua kategori
        if (!$user) {
            return redirect()->route('profile.show')->with('error', 'User not found');
        }

        return view('profile.edit', compact('breadcrumb', 'page', 'activeMenu', 'user', 'kategori'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:5',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ipk' => 'nullable|numeric|min:0|max:4.0',
            'prefrensi_lomba' => 'nullable|exists:m_kategori,kategori_id',
        ]);
        $user->nama = $validated['nama'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        if ($request->hasFile('img')) {
            if ($user->img && Storage::exists('public/img/' . $user->img)) {
                Storage::delete('public/img/' . $user->img);
            }
            $filename = $user->username . '.png';
            $request->img->storeAs('public/img', $filename);
            $user->img = $filename;
        }

        //SAVE EVERYTHINGGGG
        DB::table('m_user')
            ->where('user_id', $user->user_id)
            ->update([
                'nama' => $user->nama,
                'password' => $user->password,
                'img' => $user->img,
            ]);
        // Update the user instance in the session
        $request->session()->put('user', $user);

        DB::table('m_mahasiswa')
            ->where('user_id', $user->user_id)
            ->update([
                'ipk' => $request->ipk,
                'prefrensi_lomba' => $request->prefrensi_lomba,
            ]);
        // Update the mahasiswa instance in the session
        $mahasiswa = DB::table('m_mahasiswa')
            ->where('user_id', $user->user_id)
            ->first();
        $request->session()->put('mahasiswa', $mahasiswa);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
