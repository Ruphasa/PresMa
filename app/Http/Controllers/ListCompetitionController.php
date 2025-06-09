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
        $query = CompetitionModel::with('kategori')->where('status', 'validated')->where('lomba_tanggal', '>=', now())->orderBy('lomba_tanggal', 'asc');

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

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Create Competition',
            'list' => ['Home', 'Create Competition']
        ];

        $page = (object) [
            'title' => 'Create a New Competition'
        ];

        $activeMenu = 'createcompetition';

        // Ambil semua kategori untuk dropdown
        $categories = KategoriModel::all();
        
        //Ambil User ID dari auth
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a competition.');
        }
        //Ambil
        $userId = auth()->id();

        return view('createcompetition', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'categories' => $categories,
            'userId' => $userId
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'user_id' => 'required',
            'lomba_nama' => 'required|string|max:255',
            'lomba_tingkat' => 'required|string|max:255',
            'lomba_tanggal' => 'required|date',
            'lomba_detail' => 'required|string',
            'status' => 'required|in:pending',
            'keterangan' => 'nullable|string',
        ]);

        $competition = new CompetitionModel();
        $competition->kategori_id = $request->kategori_id;
        $competition->user_id = auth()->id(); // assuming login
        $competition->lomba_nama = $request->lomba_nama;
        $competition->lomba_tingkat = $request->lomba_tingkat;
        $competition->lomba_tanggal = $request->lomba_tanggal;
        $competition->lomba_detail = $request->lomba_detail;
        $competition->status = $request->status;
        $competition->keterangan = $request->keterangan;
        $competition->save();

        return redirect()->route('competition.index')->with('success', 'Lomba berhasil ditambahkan!');
    }

}
