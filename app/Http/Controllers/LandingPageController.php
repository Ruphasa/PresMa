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

        // Fetch top 10 students by points
        $topStudents = MahasiswaModel::select(
            'm_user.nama',
            'm_user.img',
            \DB::raw('SUM(t_prestasi.point) as total_point')
        )
        ->join('m_user', 'm_mahasiswa.user_id', '=', 'm_user.user_id')
        ->leftJoin('t_prestasi', 'm_mahasiswa.nim', '=', 't_prestasi.mahasiswa_id')
        ->groupBy('m_mahasiswa.nim', 'm_user.nama', 'm_user.img')
        ->orderByDesc('total_point')
        ->take(10)
        ->get();

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
