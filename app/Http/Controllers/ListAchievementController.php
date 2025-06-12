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
            // Action for SEE DETAILS
            ->addColumn('action', function ($row) {
                return '<a href="' . route('achievement.show', $row->prestasi_id) . '" class="btn btn-info btn-sm">See Details</a>';
            })
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
            // Action for RESUBMIT
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
        $mahasiswa = auth()->user()->mahasiswa->nim;
        $request->validate([
            'lomba_id' => 'required',
            'tingkat_prestasi' => 'required',
            'juara_ke' => 'required|integer|min:1',
            'bukti_prestasi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        AchievementModel::create([
            'lomba_id' => $request->lomba_id,
            'mahasiswa_id' => $mahasiswa,
            'tingkat_prestasi' => $request->tingkat_prestasi,
            'juara_ke' => $request->juara_ke,
            'status' => 'pending',
            'point' => 0,
            'bukti_prestasi' => $request->file('bukti_prestasi')->store('prestasi', 'public'),
        ]);

        return redirect('./Student/achievement/')->with('success', 'Prestasi berhasil ditambahkan!');
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
            'lomba' => $lomba,
            'bukti_prestasi' => $achievement->bukti_prestasi,
        ]);
    }
    public function update(Request $request, $id)
    {
        $achievement = AchievementModel::findOrFail($id);

        $request->validate([
            'lomba_id' => 'required',
            'tingkat_prestasi' => 'required|string|max:255',
            'juara_ke' => 'required|integer|min:1',
            'bukti_prestasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $achievement->update([
            'lomba_id' => $request->lomba_id,
            'tingkat_prestasi' => $request->tingkat_prestasi,
            'juara_ke' => $request->juara_ke,
            'status' => 'pending',
            'bukti_prestasi' => $request->file('bukti_prestasi') ? $request->file('bukti_prestasi')->store('prestasi', 'public') : $achievement->bukti_prestasi,
        ]);

        return redirect('./Student/achievement/')->with('success', 'Prestasi berhasil diperbarui.');
    }

    // SHOW A SINGLE ACHIEVEMENT
    public function show($id)
    {
        $achievement = AchievementModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Achievement Detail',
            'list' => ['Achievement', 'Detail'],
        ];
        $page = (object) [
            'title' => 'Detail Prestasi',
        ];
        $activeMenu = 'achievement'; // set menu yang sedang aktif
        return view('achievementdetail', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'achievement' => $achievement,
        ]);
    }
}
