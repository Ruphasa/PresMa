<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

public function postlogin(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $username = $request->username;
    $password = $request->password;

    // Ambil 5 karakter pertama dari username
    $firstFiveChars = substr($username, 0, 5);

    // Case 1: Jika 5 karakter pertama adalah "admin"
    if (strtolower($firstFiveChars) === 'admin') {
        $admin = AdminModel::whereHas('user', function ($query) use ($username) {
            $query->where('nama', $username);
        })->with('user')->first();

        if ($admin && Hash::check($password, $admin->user->password)) {
            Auth::login($admin->user);
            return redirect()->intended('/');
        }
    }
    // Case 2: Jika username adalah angka (NIM mahasiswa)
    elseif (is_numeric($username)) {
        $mahasiswa = MahasiswaModel::where('nim', $username)->with('user')->first();

        if ($mahasiswa && Hash::check($password, $mahasiswa->user->password)) {
            Auth::login($mahasiswa->user);
            return redirect()->intended('/');
        }
    }
    // Case 3: Jika username adalah string satu kata (dosen)
    else {
        $dosen = DosenModel::where('username', $username)->with('user')->first();

        if ($dosen && Hash::check($password, $dosen->user->password)) {
            Auth::login($dosen->user);
            return redirect()->intended('/');
        }
    }

    // Jika tidak ada yang cocok, kembalikan error
    return back()->with('error', 'Login Gagal! Username atau Password salah.');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
