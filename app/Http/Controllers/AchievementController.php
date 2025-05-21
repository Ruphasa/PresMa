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
            'list' => ['Admin /', 'Prestasi'],
        ];
        $page = (object) [
            'title' => 'Daftar Prestasi yang terdaftar dalam sistem'
        ];
        $lomba = CompetitionModel::all();
        $activeMenu = 'achievements'; // set menu yang sedang aktif
        return view('admin.achievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'lomba' => $lomba, 'activeMenu' => $activeMenu]);
    }

    public function dosen()
    {
        $breadcrumb = (object) [
            'title' => 'Prestasi List',
            'list' => ['Admin /', 'Prestasi'],
        ];
        $page = (object) [
            'title' => 'Daftar Prestasi yang terdaftar dalam sistem'
        ];
        $lomba = CompetitionModel::all();
        $activeMenu = 'achievements'; // set menu yang sedang aktif
        return view('dosen.achievement', ['breadcrumb' => $breadcrumb, 'page' => $page, 'lomba' => $lomba, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke'
        )
            ->with('lomba')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn('action', function ($prestasi) {
                $btn = '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listDosen(Request $request)
    {
        $prestasi = AchievementModel::select(
            'prestasi_id',
            'lomba_id',
            'tingkat_prestasi',
            'juara_ke'
        )
            ->with('lomba')
            ->get();

        return DataTables::of($prestasi)
            ->addIndexColumn()
            ->addColumn('action', function ($prestasi) {
                $btn = '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/prestasi/' . $prestasi->prestasi_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
