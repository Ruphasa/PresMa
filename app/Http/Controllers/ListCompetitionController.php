<?php

namespace App\Http\Controllers;

use App\Models\CompetitionModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class ListCompetitionController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Competitions',
            'list' => ['Home', 'Competitions']
        ];

        $page = (object) [
            'title' => 'List of Competitions Available'
        ];

        $activeMenu = 'listcompetition';

        // Ambil semua kategori untuk dropdown
        $categories = KategoriModel::all();

        // Query untuk kompetisi
        $query = CompetitionModel::with('kategori')->where('status', 'validated');

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan keyword jika ada
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('lomba_nama', 'like', '%' . $keyword . '%')
                  ->orWhere('lomba_detail', 'like', '%' . $keyword . '%')
                  ->orWhere('lomba_tingkat', 'like', '%' . $keyword . '%');
            });
        }

        // Ambil data kompetisi setelah filter
        $competitions = $query->get();

        return view('competition', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'competitions' => $competitions,
            'categories' => $categories
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
        return view('detail', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'competition' => $competition,
        ]);
    }
}
