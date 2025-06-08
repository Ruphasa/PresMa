<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AchievementModel;
use App\Models\MahasiswaModel;
use App\Models\CompetitionModel;

class LandingPageController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Landing Page',
            'list' => ['Home', 'Landing Page'],
        ];
        $page = (object) [
            'title' => 'Selamat datang di PresMa',
        ];

        // Fetch statistics
        $totalAchievements = AchievementModel::count();
        $studentsWithAchievements = AchievementModel::distinct('mahasiswa_id')->count();
        $totalCompetitions = CompetitionModel::count();

        // Fetch top 5 students by points
        $topStudents = MahasiswaModel::with(['user', 'achievements' => function ($query) {
            $query->select('mahasiswa_id', \DB::raw('SUM(point) as total_poin'))
                ->groupBy('mahasiswa_id')
                ->orderBy('total_poin', 'desc')
                ->take(5);
        }]);
        // Fetch 6 latest competitions
        $latestCompetitions = CompetitionModel::with('kategori')
            ->where('status', 'validated')
            ->orderBy('lomba_tanggal', 'desc')
            ->take(6)
            ->get();

        $activeMenu = 'home';

        return view('home', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalAchievements' => $totalAchievements,
            'studentsWithAchievements' => $studentsWithAchievements,
            'totalCompetitions' => $totalCompetitions,
            'topStudents' => $topStudents,
            'latestCompetitions' => $latestCompetitions
        ]);
    }
}
