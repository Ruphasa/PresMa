<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('register.register', ['level' => $level]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|min:3|unique:m_user,nama',
            'password' => 'required|min:5|confirmed',
            'email' => 'required|email|unique:m_user,email',
            'level_id' => 'required|exists:m_level,level_id', // Pastikan level_id ada di tabel m_level
        ]);

        // Simpan data pengguna
        UserModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'img' => 'default.jpg', // Gambar default
        ]);

        // Arahkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}