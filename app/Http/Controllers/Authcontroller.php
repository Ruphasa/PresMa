<?php 
 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
 
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
    $credentials = $request->only('email', 'password'); 

    if (Auth::attempt($credentials)) { 
        return redirect()->intended('/'); // redirect ke halaman utama setelah login 
    } 
     
    return back()->with('error', 'Login Gagal! Email atau Password salah.');
}

 
    public function logout(Request $request) 
    { 
        Auth::logout(); 
 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();     
        return redirect('login'); 
    } 
} 