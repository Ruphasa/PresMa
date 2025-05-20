<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Mahasiswa;



class DosenController extends Controller
{
    public function list(Request $request)
{
    $dosen = DosenModel::with('user')->get();
    return DataTables::of($dosen)
        ->addIndexColumn()
        ->addColumn('nama', function ($dosen) { return $dosen->user ? $dosen->user->nama : '-'; })
        ->addColumn('email', function ($dosen) { return $dosen->user ? $dosen->user->email : '-'; })
        ->addColumn('img', function ($dosen) { return $dosen->user && $dosen->user->img ? '<img src="' . asset($dosen->user->img) . '" alt="Image" style="width: 50px; height: auto;">' : '-'; })
        ->addColumn('action', function ($dosen) {
            $btn = '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['img', 'action'])
        ->make(true);
}
 // ============================================
    // DOSEN
    // ============================================
    public function storeDosenAjax(Request $request): JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nidn'       => 'required|string|unique:dosen,nidn',
                'nama'       => 'required|string|max:100',
                'email'      => 'required|email|unique:dosen,email',
                'image_path' => 'nullable|string',
                'prodi'      => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            DosenModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data dosen berhasil disimpan'
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid request']);
    }

}
