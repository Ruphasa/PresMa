<?php

namespace App\Http\Controllers;

use App\Models\CompetitionModel;
use App\Models\KategoriModel;
use App\Models\MahasiswaModel;
use App\Models\RekomendasiModel;
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
        $competition = CompetitionModel::findOrFail($id);
        $competition->status = 'validated';
        $competition->save();
        return redirect('/Admin/competition');
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

    public function rekomendasi($id)
    {
        // Ambil semua data mahasiswa
        $mahasiswa = MahasiswaModel::all(['nim', 'ipk', 'jumlah_prestasi', 'angkatan', 'point', 'pengalaman_organisasi'])->toArray();

        // Kirim data ke API SPK
        $response = Http::post('http://localhost:5001/recommend', [
            'mahasiswa' => $mahasiswa
        ]);

        if ($response->successful()) {
            $rekomendasi = $response->json()['rekomendasi'];
            return view('Admin.competition.show_ajax', ['rekomendasi' => $rekomendasi]);
        } else {
            return view('Admin.competition.error_ajax', ['message' => 'Gagal mendapatkan rekomendasi']);
        }
    }
}
