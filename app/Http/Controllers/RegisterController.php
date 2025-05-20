<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3|unique:m_user,nama',
            'password' => 'required|min:5|confirmed',
            'email' => 'required|email|unique:m_user,email',
        ]);
        UserModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level_id' => 1, // auto assign ke level mahasiswa misalnya
            'img' => 'default.jng', // default image
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil! Silakan login.',
            'redirect' => url('/login')
        ]);
    }
}
