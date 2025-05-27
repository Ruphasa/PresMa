<?php

namespace App\Http\Controllers;

use App\Models\CompetitionModel;
use Illuminate\Http\Request;

class ListCompetitionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Competitions List',
            'list' => ['Home /', 'Competitions'],
        ];
        $page = (object) [
            'title' => 'Daftar Lomba yang terdaftar dalam sistem'
        ];
        $activeMenu = 'competition';

        // Fetch validated competitions
        $competitions = CompetitionModel::with('kategori')
            ->where('status', 'validated')
            ->get();

        return view('competition', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'competitions' => $competitions,
        ]);
    }

    public function show($lomba_id)
{
    // Fetch the specific competition with its category
    $competition = CompetitionModel::with('kategori')
        ->where('lomba_id', $lomba_id)
        ->firstOrFail();

    // Prepare breadcrumb and page data
    $breadcrumb = (object) [
        'title' => 'Competition Details',
        'list' => ['Home /', 'Competitions /', $competition->lomba_nama],
    ];
    $page = (object) [
        'title' => 'Detail Lomba: ' . $competition->lomba_nama
    ];
    $activeMenu = 'competition';

    // Return the detail view with the competition data
    return view('competition_detail', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'competition' => $competition,
    ]);
}
}