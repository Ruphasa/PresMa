<?php
namespace App\Http\Controllers;

use App\Models\AchievementModel;
use App\Models\CompetitionModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AchievementController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Prestasi List',
            'list'  => ['Admin /', 'Prestasi'],
        ];
        $page = (object) [
            'title' => 'Daftar Prestasi yang terdaftar dalam sistem',
        ];
        $lomba      = CompetitionModel::all();
        $activeMenu = 'achievements'; // set menu yang sedang aktif
        return view('Admin.achievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'lomba' => $lomba, 'activeMenu' => $activeMenu]);
    }

    public function dosen()
    {
        $breadcrumb = (object) [
            'title' => 'Prestasi List',
            'list'  => ['Admin /', 'Prestasi'],
        ];
        $page = (object) [
            'title' => 'Daftar Prestasi yang terdaftar dalam sistem',
        ];
        $lomba      = CompetitionModel::all();
        $activeMenu = 'achievements'; // set menu yang sedang aktif
        return view('dosen.achievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'lomba' => $lomba, 'activeMenu' => $activeMenu]);
    }

    //join with prestasi and mahasiswa
    public function listDosen(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'mahasiswa_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke',
            'status'
        )
            ->with('lomba', 'mahasiswa')
            ->where('status', '!=', 'rejected')
            ->whereHas('mahasiswa', function ($query) {
                $query->where('dosen_id', auth()->user()->dosen->nidn);
            })
            ->orderBy('status', 'desc')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn('nama', function ($prestasi) {
                return $prestasi->mahasiswa->user->nama ?? 'N/A'; // Assuming mahasiswa relation exists
            })
            ->addColumn('action', function ($prestasi) {
                if ($prestasi->status === 'pending') {
                    $btn = '<button onclick="modalAction(\'' . secure_url('Admin/achievement/' . $prestasi->prestasi_id .
                        '/validate_ajax') . '\')" class="btn btn-success btn-sm">Validasi</button> ';
                    $btn .= '<button onclick="modalAction(\'' . secure_url('Admin/achievement/' . $prestasi->prestasi_id .
                        '/reject_ajax') . '\')" class="btn btn-danger btn-sm">Reject</button> ';
                    return $btn;
                }
                if ($prestasi->status === 'validated') {
                    $btn = '<button onclick="modalAction(\'' . secure_url('Admin/achievement/' . $prestasi->prestasi_id .
                        '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                    return $btn;
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show_ajax($id)
    {
        $prestasi = AchievementModel::where('prestasi_id', $id)
            ->with('lomba')
            ->firstOrFail();
        return view('dosen.show_ajax', ['prestasi' => $prestasi]);
    }

    public function listPending(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'mahasiswa_id',
            'lomba_id',
            'point',
            'status'
        )
            ->with('lomba', 'mahasiswa')
            ->where('status', 'pending')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn('nama', function ($prestasi) {
                return $prestasi->mahasiswa->user->nama ?? 'N/A'; // Assuming mahasiswa relation exists
            })
            ->addColumn('validate', function ($prestasi) {
                $btn = '<button onclick="modalAction(\'' . secure_url('Admin/achievement/' . $prestasi->prestasi_id .
                    '/validate_ajax') . '\')" class="btn btn-success btn-sm">Validasi</button> ';
                $btn .= '<button onclick="modalAction(\'' . secure_url('Admin/achievement/' . $prestasi->prestasi_id .
                    '/reject_ajax') . '\')" class="btn btn-danger btn-sm">Reject</button> ';
                return $btn;
            })
            ->addColumn('action', function ($prestasi) {
                return ''; // No action buttons for pending
            })
            ->rawColumns(['validate'])
            ->make(true);
    }

    public function listValid(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'mahasiswa_id',
            'lomba_id',
            'point',
            'status'
        )
            ->with('lomba', 'mahasiswa')
            ->where('status', 'validated')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn('nama', function ($prestasi) {
                return $prestasi->mahasiswa->user->nama ?? 'N/A'; // Assuming mahasiswa relation exists
            })
            ->addColumn('action', function ($prestasi) {
                $btn = '<button onclick="modalAction(\'' . secure_url('/prestasi/' . $prestasi->prestasi_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function confirmValidate($id)
    {
        $prestasi = AchievementModel::findOrFail($id);
        return view('Admin.achievement.validate_ajax', ['achievement' => $prestasi]);
    }

    public function validate_ajax($id)
    {
        try {
            $prestasi = AchievementModel::find($id);
            if ($prestasi->status === 'pending') {
                $prestasi->status = 'validated';
                $prestasi->save();
                return response()->json(['success' => true, 'message' => 'Prestasi berhasil divalidasi']);
            } else {
                return response()->json(['success' => false, 'message' => 'Prestasi tidak dalam status pending']);
            }
        } catch (\Exception $e) {
            return response()->json(['gagal' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function confirmReject($id)
    {
        $achievement = AchievementModel::findOrFail($id);
        return view('Admin.achievement.reject_ajax', ['achievement' => $achievement]);
    }

    public function reject_ajax($id)
    {

        try {
            $achievement = AchievementModel::findOrFail($id);
            if ($achievement->status === 'pending') {
                $achievement->status     = 'rejected';
                $achievement->keterangan = request()->input('reject_note'); // Simpan note jika ada kolom di model
                $achievement->save();
                return response()->json(['success' => true, 'message' => 'Prestasi berhasil ditolak']);
            }
            return response()->json(['success' => false, 'message' => 'Prestasi tidak dalam status pending']);
        } catch (\Exception $e) {
            return response()->json(['gagal' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

}
