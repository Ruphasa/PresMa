<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        $dosen = DosenModel::select('user_id')->get();
        $prodi = ProdiModel::select('prodi_id', 'nama_prodi')->get();
        return view('register.register', ['level' => $level, 'dosen' => $dosen, 'prodi' => $prodi]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|min:3|unique:m_user,nama',
            'password' => 'required|min:5|confirmed',
            'email' => 'required|email|unique:m_user,email',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        switch ($request->level_id) {
            case 1:
                $request->validate([
                    'nim' => 'required|unique:m_mahasiswa,nim',
                    'prodi_id' => 'required',
                    'angkatan' => 'required|numeric',
                ]);
                break;
            case 2:
                $request->validate([
                    'nidn' => 'required|unique:m_dosen,nidn',
                    'prodi_id' => 'required',
                ]);
                break;
        }

        // Simpan data pengguna
        $user = UserModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'img' => 'default.jpg',
        ]);

        switch ($request->level_id) {
            case 1: // Mahasiswa
                MahasiswaModel::create([
                    'nim' => $request->nim,
                    'user_id' => $user->user_id,
                    'prodi_id' => $request->prodi_id,
                    'dosen_id' => $request->dosen_id ?? null,
                    'ipk' => 2.0,
                    'jumlah_lomba' => 0,
                    'preferensi_lomba' => '',
                    'angkatan' => $request->angkatan,
                    'point' => 0,
                ]);
                break;
            case 2: // Dosen
                DosenModel::create([
                    'nidn' => $request->nidn,
                    'user_id' => $user->user_id,
                ]);
                break;
            case 3:
                AdminModel::create([
                    'user_id' => $user->user_id,
                    'nama' => $request->nama,
                ]);
                break;
        }

        // Arahkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}