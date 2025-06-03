<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\CompetitionModel;
use App\Models\AchievementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // Ambil data dengan pengecekan
        try {
            $totalUsers = UserModel::count();
            $totalCompetitions = CompetitionModel::where('status', 'validated')->count();
            $totalAchievements = AchievementModel::count();
            $pendingCompetitions = CompetitionModel::where('status', 'pending')->count();
        } catch (\Exception $e) {
            // Jika ada error, log dan set nilai default
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
            $totalUsers = 0;
            $totalCompetitions = 0;
            $totalAchievements = 0;
            $pendingCompetitions = 0;
        }

        $timeNow = 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s');

        // Log untuk debugging
        Log::info('Dashboard data', [
            'totalUsers' => $totalUsers,
            'totalCompetitions' => $totalCompetitions,
            'totalAchievements' => $totalAchievements,
            'pendingCompetitions' => $pendingCompetitions,
        ]);

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
        try {
            $stats = [
                'timeNow' => 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s'),
                'totalUsers' => UserModel::count(),
                'totalCompetitions' => CompetitionModel::where('status', 'validated')->count(),
                'totalAchievements' => AchievementModel::count(),
                'pendingCompetitions' => CompetitionModel::where('status', 'pending')->count(),
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard stats: ' . $e->getMessage());
            $stats = [
                'timeNow' => 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s'),
                'totalUsers' => 0,
                'totalCompetitions' => 0,
                'totalAchievements' => 0,
                'pendingCompetitions' => 0,
            ];
        }

        return response()->json($stats);
    }
}
