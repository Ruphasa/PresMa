<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MahasiswaController extends Controller
{
    public function list(Request $request)
    {
        $mahasiswa = MahasiswaModel::select(
            'nim',
            'user_id',
            'prodi_id',
            'dosen_id',
        )
            ->with(['user', 'prodi', 'dosen'])
            ->get();

        return DataTables::of($mahasiswa)
            ->addIndexColumn()
            ->addColumn('dosen', function ($mahasiswa) {
                return $mahasiswa->dosen && $mahasiswa->dosen->user
                    ? $mahasiswa->dosen->user->nama
                    : '-';
            })
            ->addColumn('action', function ($mahasiswa) {
                $btn = '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->user_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->user_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->user_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
