<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListCompetitionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Competitions List',
            'list' => ['Competitions'],
        ];
        $page = (object) [
            'title' => 'Daftar Lomba yang terdaftar dalam sistem'
        ];
        $activeMenu = 'competition'; // set menu yang sedang aktif
        return view('competition', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}
