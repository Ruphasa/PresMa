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
            'status'
        )
            ->with('lomba')
            ->where('status', 'rejected')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->make(true);
    }
}
