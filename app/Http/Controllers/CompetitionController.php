<?php

namespace App\Http\Controllers;

use App\Models\CompetitionModel;
use App\Models\KategoriModel;
use App\Models\MahasiswaModel;
use App\Models\RekomendasiModel;
use App\Models\AchievementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class CompetitionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Competitions List',
            'list' => ['Admin /', 'Competitions'],
        ];
        $page = (object) [
            'title' => 'Daftar Lomba yang terdaftar dalam sistem'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'competitions'; // set menu yang sedang aktif
        return view('Admin.competition', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function listPending(Request $request)
    {
        $competitions = CompetitionModel::select(
            'lomba_id',
            'kategori_id',
            'lomba_tingkat',
            'lomba_tanggal',
            'lomba_nama',
            'lomba_detail',
            'status'
        )
            ->with('kategori')
            ->where('status', 'pending')
            ->get();

        return DataTables::of($competitions)
            ->addIndexColumn()
            ->addColumn('validate', function ($competition) {
                $btn = '<button onclick="modalAction(\'' . url('Admin/competition/' . $competition->lomba_id .
                    '/validate_ajax') . '\')" class="btn btn-success btn-sm">Validate</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('Admin/competition/' . $competition->lomba_id .
                    '/reject_ajax') . '\')" class="btn btn-danger btn-sm">Reject</button> ';
                return $btn;
            })
            ->addColumn('action', function ($competition) {
                return ''; // No action buttons for pending
            })
            ->rawColumns(['validate'])
            ->make(true);
    }

    public function listValid(Request $request)
    {
        $competitions = CompetitionModel::select(
            'lomba_id',
            'kategori_id',
            'lomba_tingkat',
            'lomba_tanggal',
            'lomba_nama',
            'lomba_detail',
            'status'
        )
            ->with('kategori')
            ->where('status', 'validated')
            ->get();

        return DataTables::of($competitions)
            ->addIndexColumn()
            ->addColumn('action', function ($competition) {
                $btn = '<button onclick="modalAction(\'' . url('Admin/competition/' . $competition->lomba_id .
                    '/') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('Admin/competition/' . $competition->lomba_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('Admin/competition/' . $competition->lomba_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function confirmValidate($id)
    {
        $competition = CompetitionModel::findOrFail($id);
        return view('Admin.competition.validate_ajax', ['competition' => $competition]);
    }

    public function validate_ajax($id)
    {
        try{
            $competition = CompetitionModel::findOrFail($id);
            $competition->status = 'validated';
            $competition->save();
            return response()->json(['success' => true, 'message' => 'Competition validated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['gagal' => false, 'message' => 'Failed to validate competition: ' . $e->getMessage()]);
        }
    }

    public function confirmReject($id)
    {
        $competition = CompetitionModel::findOrFail($id);
        return view('Admin.competition.reject_ajax', ['competition' => $competition]);
    }

    public function reject_ajax($id)
    {
        $competition = CompetitionModel::findOrFail($id);
        $competition->status = 'rejected';
        $competition->keterangan = request()->input('keterangan');
        $competition->save();
        return redirect('/Admin/competition');
    }

    public function show_ajax($id)
    {
        $competition = CompetitionModel::where('lomba_id', $id)
            ->with('kategori')
            ->firstOrFail();
        $rekomendasi = RekomendasiModel::where('lomba_id', $id)
            ->with('mahasiswa')
            ->get();
        return view('Admin.competition.show_ajax', ['competition' => $competition, 'rekomendasi' => $rekomendasi]);
    }

    public function findRecommendations($competition_id)
{
    $competition = CompetitionModel::findOrFail($competition_id);

    $students = MahasiswaModel::select(
            'm_mahasiswa.nim',
            'm_mahasiswa.ipk',
            'm_mahasiswa.angkatan',
            'm_mahasiswa.prefrensi_lomba'
        )
        ->get()
        ->map(function ($mhs) {
            $jumlah_prestasi = AchievementModel::where('mahasiswa_id', $mhs->nim)
                ->where('status', 'valid')
                ->count();

            $points = AchievementModel::where('mahasiswa_id', $mhs->nim)
                ->where('status', 'valid')
                ->get()
                ->sum(function ($prestasi) {
                    $point_map = [
                        'internasional' => 10,
                        'nasional' => 7,
                        'regional' => 5,
                        'lokal' => 3
                    ];
                    $juara_weight = (6 - min($prestasi->juara_ke, 5));
                    return ($point_map[$prestasi->tingkat_prestasi] ?? 1) * $juara_weight;
                });

            return [
                'nim' => $mhs->nim,
                'ipk' => $mhs->ipk,
                'angkatan' => $mhs->angkatan,
                'prefrensi_lomba' => $mhs->prefrensi_lomba,
                'jumlah_prestasi' => $jumlah_prestasi,
                'point' => $points
            ];
        })->toArray();

    \Log::info("Jumlah mahasiswa setelah map: " . count($students));

    $csv_file_path = storage_path('app/mahasiswa_data.csv');
    $file = fopen($csv_file_path, 'w');
    fputcsv($file, ['nim', 'ipk', 'angkatan', 'jumlah_prestasi', 'point', 'prefrensi_lomba']);

    foreach ($students as $student) {
        fputcsv($file, [
            $student['nim'],
            $student['ipk'],
            $student['angkatan'],
            $student['jumlah_prestasi'],
            $student['point'],
            $student['prefrensi_lomba'],
        ]);
    }
    fclose($file);

    if (!file_exists($csv_file_path)) {
        \Log::error("File CSV tidak ditemukan di: " . $csv_file_path);
        return response()->json(['message' => 'Gagal membuat file CSV'], 500);
    }

    $level = $competition->lomba_tingkat;
    $category_id = $competition->kategori_id;
    $command = escapeshellcmd("\"C:\\Users\\USER\\AppData\\Local\\Programs\\Python\\Python311\\python.exe\" " . base_path('public/spk_model.py') . " $level $category_id $csv_file_path");
    \Log::info("Executing command: " . $command);
    $output = @shell_exec($command);

    if ($output === null || $output === false) {
        \Log::error("Gagal menjalankan skrip Python. Command: " . $command . ". Output: " . ($output ?: 'No output'));
        return response()->json(['message' => 'Gagal menjalankan skrip Python'], 500);
    }

    unlink($csv_file_path);

    $output = trim($output);

    if ($output === 'tidak ada yang cocok') {
        return response()->json(['message' => 'Tidak dapat menemukan mahasiswa yang cocok'], 404);
    }

    $recommended_nims = array_filter(explode(',', $output));
    $recommended_nims = array_map('trim', $recommended_nims);

    if (empty($recommended_nims)) {
        return response()->json(['message' => 'Tidak ada NIM yang valid dari rekomendasi'], 400);
    }

    foreach ($recommended_nims as $nim) {
        if (!empty($nim) && is_numeric($nim)) {
            RekomendasiModel::create([
                'lomba_id' => $competition_id,
                'nim' => $nim,
            ]);
        }
    }

    $rekomendasi = RekomendasiModel::where('lomba_id', $competition_id)
                                   ->with('mahasiswa')
                                   ->get();

    $html = view('partials.rekomendasi_list', compact('rekomendasi'))->render();

    return response()->json(['html' => $html]);
}
}
