<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Landing Page',
            'list' => ['Home', 'Landing Page'],
        ];
        $page = (object) [
            'title' => 'Selamat datang di PresMa',
        ];
        $activeMenu = 'home'; // set menu yang sedang aktif
        return view('home', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}
