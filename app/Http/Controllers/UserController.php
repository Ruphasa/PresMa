<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'User List',
            'list' => ['Admin /', 'User'],
        ];
        $page = (object) [
            'title' => 'Daftar Mahasiswa yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('admin.user', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}
