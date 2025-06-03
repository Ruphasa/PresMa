<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\CompetitionModel;
use App\Models\AchievementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
            $totalUsers = 0;
            $totalCompetitions = 0;
            $totalAchievements = 0;
            $pendingCompetitions = 0;
        }

        $timeNow = 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s');

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
            // Ambil data lomba per bulan
            $competitionData = CompetitionModel::select(
                DB::raw('MONTH(lomba_tanggal) as month'),
                DB::raw('COUNT(*) as count')
            )
                ->where('status', 'validated')
                ->whereYear('lomba_tanggal', now(+7)->year)
                ->groupBy(DB::raw('MONTH(lomba_tanggal)'))
                ->pluck('count', 'month')
                ->toArray();

            // Inisialisasi array untuk semua bulan
            $competitionDataByMonth = array_fill(1, 12, 0);
            foreach ($competitionData as $month => $count) {
                $competitionDataByMonth[$month] = $count;
            }

            // Ambil data mahasiswa berprestasi per bulan
            $achievementData = AchievementModel::select(
                DB::raw('MONTH(m_lomba.lomba_tanggal) as month'),
                DB::raw('COUNT(DISTINCT t_prestasi.mahasiswa_id) as count')
            )
                ->join('m_lomba', 't_prestasi.lomba_id', '=', 'm_lomba.lomba_id')
                ->where('t_prestasi.status', 'validated')
                ->whereYear('m_lomba.lomba_tanggal', now(+7)->year)
                ->groupBy(DB::raw('MONTH(m_lomba.lomba_tanggal)'))
                ->pluck('count', 'month')
                ->toArray();

            // Inisialisasi array untuk semua bulan
            $achievementDataByMonth = array_fill(1, 12, 0);
            foreach ($achievementData as $month => $count) {
                $achievementDataByMonth[$month] = $count;
            }

            Log::info('Competition Data:', $competitionDataByMonth);
            Log::info('Achievement Data:', $achievementDataByMonth);

            $stats = [
                'timeNow' => 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s'),
                'totalUsers' => UserModel::count(),
                'totalCompetitions' => CompetitionModel::where('status', 'validated')->count(),
                'totalAchievements' => AchievementModel::count(),
                'pendingCompetitions' => CompetitionModel::where('status', 'pending')->count(),
                'competitionData' => array_values($competitionDataByMonth),
                'achievementData' => array_values($achievementDataByMonth),
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard stats: ' . $e->getMessage());
            $stats = [
                'timeNow' => 'Tanggal : ' . now(+7)->format('d M Y') . ' Jam : ' . now(+7)->format('H:i:s'),
                'totalUsers' => 0,
                'totalCompetitions' => 0,
                'totalAchievements' => 0,
                'pendingCompetitions' => 0,
                'competitionData' => array_fill(0, 12, 0),
                'achievementData' => array_fill(0, 12, 0),
            ];
        }

        return response()->json($stats);
    }

    public function exportPdf()
    {
        try {
            Log::info('Starting PDF export process using Dompdf...');

            // Ambil data untuk laporan
            $totalUsers = UserModel::count();
            $totalCompetitions = CompetitionModel::where('status', 'validated')->count();
            $totalAchievements = AchievementModel::count();
            $pendingCompetitions = CompetitionModel::where('status', 'pending')->count();

            Log::info('Dashboard summary data retrieved:', [
                'totalUsers' => $totalUsers,
                'totalCompetitions' => $totalCompetitions,
                'totalAchievements' => $totalAchievements,
                'pendingCompetitions' => $pendingCompetitions,
            ]);

            // Ambil data lomba per bulan
            $competitionData = CompetitionModel::select(
                DB::raw('MONTH(lomba_tanggal) as month'),
                DB::raw('COUNT(*) as count')
            )
                ->where('status', 'validated')
                ->whereYear('lomba_tanggal', now(+7)->year)
                ->groupBy(DB::raw('MONTH(lomba_tanggal)'))
                ->pluck('count', 'month')
                ->toArray();

            $competitionDataByMonth = array_fill(1, 12, 0);
            foreach ($competitionData as $month => $count) {
                $competitionDataByMonth[$month] = $count;
            }

            // Ambil data mahasiswa berprestasi per bulan
            $achievementData = AchievementModel::select(
                DB::raw('MONTH(m_lomba.lomba_tanggal) as month'),
                DB::raw('COUNT(DISTINCT t_prestasi.mahasiswa_id) as count')
            )
                ->join('m_lomba', 't_prestasi.lomba_id', '=', 'm_lomba.lomba_id')
                ->where('t_prestasi.status', 'validated')
                ->whereYear('m_lomba.lomba_tanggal', now(+7)->year)
                ->groupBy(DB::raw('MONTH(m_lomba.lomba_tanggal)'))
                ->pluck('count', 'month')
                ->toArray();

            $achievementDataByMonth = array_fill(1, 12, 0);
            foreach ($achievementData as $month => $count) {
                $achievementDataByMonth[$month] = $count;
            }

            Log::info('Graph data retrieved:', [
                'competitionDataByMonth' => $competitionDataByMonth,
                'achievementDataByMonth' => $achievementDataByMonth,
            ]);

            // Buat konten HTML untuk PDF
            $htmlContent = <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan Dashboard Admin 2025</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 1in; }
        h1 { text-align: center; }
        h2 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #3498db; color: white; }
        .summary { margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Laporan Tahunan Dashboard Admin 2025</h1>
    <h3>Sistem Manajemen Prestasi Mahasiswa</h3>
    <p>Tanggal: 04 Juni 2025</p>

    <h2>Ringkasan Data Tahunan</h2>
    <div class="summary">
        <p>Total Users: $totalUsers (Jumlah pengguna terdaftar)</p>
        <p>Total Competitions: $totalCompetitions (Jumlah lomba yang divalidasi)</p>
        <p>Total Achievements: $totalAchievements (Jumlah prestasi tercatat)</p>
        <p>Pending Competitions: $pendingCompetitions (Jumlah lomba menunggu validasi)</p>
    </div>

    <h2>Statistik Lomba per Bulan</h2>
    <table>
        <tr>
            <th>Bulan</th>
            <th>Jumlah Lomba</th>
        </tr>
        <tr><td>Januari</td><td>{$competitionDataByMonth[1]}</td></tr>
        <tr><td>Februari</td><td>{$competitionDataByMonth[2]}</td></tr>
        <tr><td>Maret</td><td>{$competitionDataByMonth[3]}</td></tr>
        <tr><td>April</td><td>{$competitionDataByMonth[4]}</td></tr>
        <tr><td>Mei</td><td>{$competitionDataByMonth[5]}</td></tr>
        <tr><td>Juni</td><td>{$competitionDataByMonth[6]}</td></tr>
        <tr><td>Juli</td><td>{$competitionDataByMonth[7]}</td></tr>
        <tr><td>Agustus</td><td>{$competitionDataByMonth[8]}</td></tr>
        <tr><td>September</td><td>{$competitionDataByMonth[9]}</td></tr>
        <tr><td>Oktober</td><td>{$competitionDataByMonth[10]}</td></tr>
        <tr><td>November</td><td>{$competitionDataByMonth[11]}</td></tr>
        <tr><td>Desember</td><td>{$competitionDataByMonth[12]}</td></tr>
    </table>

    <h2>Statistik Mahasiswa Berprestasi per Bulan</h2>
    <table>
        <tr>
            <th>Bulan</th>
            <th>Jumlah Mahasiswa Berprestasi</th>
        </tr>
        <tr><td>Januari</td><td>{$achievementDataByMonth[1]}</td></tr>
        <tr><td>Februari</td><td>{$achievementDataByMonth[2]}</td></tr>
        <tr><td>Maret</td><td>{$achievementDataByMonth[3]}</td></tr>
        <tr><td>April</td><td>{$achievementDataByMonth[4]}</td></tr>
        <tr><td>Mei</td><td>{$achievementDataByMonth[5]}</td></tr>
        <tr><td>Juni</td><td>{$achievementDataByMonth[6]}</td></tr>
        <tr><td>Juli</td><td>{$achievementDataByMonth[7]}</td></tr>
        <tr><td>Agustus</td><td>{$achievementDataByMonth[8]}</td></tr>
        <tr><td>September</td><td>{$achievementDataByMonth[9]}</td></tr>
        <tr><td>Oktober</td><td>{$achievementDataByMonth[10]}</td></tr>
        <tr><td>November</td><td>{$achievementDataByMonth[11]}</td></tr>
        <tr><td>Desember</td><td>{$achievementDataByMonth[12]}</td></tr>
    </table>

    <h2>Catatan Tambahan</h2>
    <p>Laporan ini dibuat berdasarkan data yang tersedia hingga 04 Juni 2025. Data menunjukkan aktivitas utama terjadi pada bulan Juni dengan $totalCompetitions lomba divalidasi dan {$achievementDataByMonth[6]} mahasiswa berprestasi. Disarankan untuk memantau data lebih lanjut seiring berjalannya tahun untuk evaluasi yang lebih komprehensif.</p>
</body>
</html>
EOD;

            Log::info('Generating PDF with Dompdf...');

            // Generate PDF menggunakan Dompdf
            $pdf = Pdf::loadHTML($htmlContent);
            $pdf->setPaper('A4', 'portrait');

            // Tambahkan log untuk memastikan proses berhasil sebelum download
            Log::info('PDF generated successfully with Dompdf.');
            return $pdf->download('laporan_tahunan_2025.pdf');
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal menghasilkan PDF: ' . $e->getMessage());
        }
    }
}
