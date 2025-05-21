<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect('/home'); // Laravel langsung redirect
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
