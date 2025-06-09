<?php

namespace App\Http\Controllers;

use App\Models\AchievementModel;
use App\Models\CompetitionModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function studentIndex()
    {
        $breadcrumb = (object) [
            'title' => 'Achievement List',
            'list' => ['Our', 'Achievement List'],
        ];
        $page = (object) [
            'title' => 'Prestasi yang telah diraih oleh peserta',
        ];
        $activeMenu = 'achievement'; // set menu yang sedang aktif
        return view('studentachievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function listPending(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke',
            'status'
        )
            ->with('lomba')
            ->where('status', 'pending')
            ->where('mahasiswa_id', auth()->user()->mahasiswa->nim)
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->make(true);
    }

    public function listValid(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke',
            'status'
        )
            ->with('lomba')
            ->where('status', 'validated')
            ->where('mahasiswa_id', auth()->user()->mahasiswa->nim)
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->make(true);
    }

    public function listRejected(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke',
            'status',
            'keterangan'
        )
            ->with('lomba')
            ->where('status', 'rejected')
            ->where('mahasiswa_id', auth()->user()->mahasiswa->nim)
            ->get();
        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn(('action'), function ($row) {
                return '<a href="" class="btn btn-primary btn-sm">Re-submit</a>'; //Later
            })
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Add Achievement',
            'list' => ['Add a', 'New Achievement'],
        ];
        $page = (object) [
            'title' => 'Prestasi yang telah diraih oleh peserta',
        ];
        $activeMenu = 'achievement'; // set menu yang sedang aktif
        $lomba = CompetitionModel::all();
        return view('createachievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'lomba' => $lomba]);
    }

    public function store(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if (!$mahasiswa) {
            return back()->withErrors(['auth' => 'Data mahasiswa tidak ditemukan.']);
        }
        $dd['mahasiswa_id'] = $mahasiswa->nim;

        $request->validate([
            'lomba_id' => 'required|exists:competitions,lomba_id',
            'tingkat_prestasi' => 'required|string|max:255',
            'juara_ke' => 'required|integer|min:1',
        ]);


        AchievementModel::create([
            'lomba_id' => $request->lomba_id,
            'tingkat_prestasi' => $request->tingkat_prestasi,
            'juara_ke' => $request->juara_ke,
            'status' => 'pending',
            'point' => 0,
            'mahasiswa_id' => $request->mahasiswa_id,
        ]);

        return redirect()->route('achievement.index')->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Achievement List',
            'list' => ['Our', 'Achievement List'],
        ];
        $page = (object) [
            'title' => 'Prestasi yang telah diraih oleh peserta',
        ];
        $activeMenu = 'achievement'; // set menu yang sedang aktif
        $achievement = AchievementModel::findOrFail($id);
        $lomba = CompetitionModel::all();
        return view('studentachievementresubmit', [
            'id' => $id,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'achievement' => $achievement,
            'lomba' => $lomba
        ]);
    }
    public function update(Request $request, $id)
    {
        $achievement = AchievementModel::findOrFail($id);

        $request->validate([
            'lomba_id' => 'required',
            'tingkat_prestasi' => 'required|string|max:255',
            'juara_ke' => 'required|integer|min:1',
        ]);

        $achievement->update([
            'lomba_id' => $request->lomba_id,
            'tingkat_prestasi' => $request->tingkat_prestasi,
            'juara_ke' => $request->juara_ke,
        ]);

        return redirect('./student/achievement')->with('success', 'Prestasi berhasil diperbarui.');
    }
}
