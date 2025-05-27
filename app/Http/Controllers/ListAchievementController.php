<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListAchievementController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Achievement List',
            'list' => ['Our', 'Achievement List'],
        ];
        $page = (object) [
            'title' => 'Prestasi yang telah diraih oleh peserta',
        ];
        $activeMenu = 'achievement'; // set menu yang sedang aktif
        return view('achievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}
