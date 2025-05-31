<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\CompetitionModel;
use App\Models\AchievementModel; // Asumsi model untuk prestasi
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard'],
        ];
        $page = (object) [
            'title' => 'Selamat datang di Dashboard Admin'
        ];
        $activeMenu = 'dashboard';

        // Ambil data awal untuk tampilan awal
        $totalUsers = UserModel::count();
        $timeNow = 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s');
        $totalCompetitions = CompetitionModel::where('status', 'validated')->count();
        $totalAchievements = AchievementModel::count(); // Asumsi
        $pendingCompetitions = CompetitionModel::where('status', 'pending')->count();

        return view('Admin.dashboard', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalUsers' => $totalUsers,
            'timeNow' => $timeNow,
            'totalCompetitions' => $totalCompetitions,
            'totalAchievements' => $totalAchievements,
            'pendingCompetitions' => $pendingCompetitions,
        ]);
    }

    public function getDashboardStats()
    {
        $stats = [
            'timeNow'=> 'Tanggal : '.now(+7)->format('d M Y'). ' Jam : '.now(+7)->format('H:i:s'),
            'totalUsers' => UserModel::count(),
            'totalCompetitions' => CompetitionModel::where('status', 'validated')->count(),
            'totalAchievements' => AchievementModel::count(),
            'pendingCompetitions' => CompetitionModel::where('status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}
