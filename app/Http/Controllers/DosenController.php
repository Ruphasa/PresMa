<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DosenController extends Controller
{
    public function list(Request $request)
    {
        $dosen = DosenModel::with('user')->get();

        return DataTables::of($dosen)
            ->addIndexColumn()
            ->addColumn('nama_user', function ($dosen) {
                return $dosen->user ? $dosen->user->nama : '-';
            })
            ->addColumn('jumlah_mahasiswa', function ($dosen) {
                return $dosen->mahasiswa->count();
            })
            ->addColumn('action', function ($dosen) {
                $btn = '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $dosen->nidn . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $user = UserModel::all();
        return view('admin.Dosen.create_ajax', ['user' => $user]);
    }

    public function store_ajax(Request $request)
    {
         if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama'=> 'required' , 
                'password' => 'required',
                'level_id'=> 'required',
                'email'=> 'required',
                'img'=> 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            \DB::beginTransaction();
            try {
                // Simpan data mahasiswa
                $user = UserModel::create([
                    'nama' => $request->nama,
                    'password' => $request->password,
                    'level_id'=> $request->level_id,
                    'email'=> $request->email,
                    'img' => $request->img
                ]);


                \DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data Mahasiswa berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
        }


        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nidn' => 'required|string|unique:m_dosen,nidn',
                'user_id' => 'required|integer|exists:m_user,user_id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                DosenModel::create($request->only(['nidn', 'user_id']));
                return response()->json([
                    'status' => true,
                    'message' => 'Data Dosen berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $dosen = DosenModel::with(['user', 'mahasiswa'])->find($id);
        if (!$dosen) {
            return response()->json([
                'status' => false,
                'message' => 'Dosen tidak ditemukan'
            ]);
        }

        return view('admin.Dosen.show_ajax', [
            'breadcrumb' => (object)[
                'title' => 'Detail Dosen',
                'list' => ['Home', 'Dosen', 'Detail']
            ],
            'page' => (object)['title' => 'Detail Dosen'],
            'dosen' => $dosen,
            'activeMenu' => 'dosen'
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $dosen = DosenModel::find($id);
            if (!$dosen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Dosen tidak ditemukan'
                ]);
            }

            try {
                $dosen->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data dosen berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $dosen = DosenModel::with('user')->get();

        $pdf = Pdf::loadView('admin.Dosen.export_pdf', ['dosen' => $dosen]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        return $pdf->stream('Data Dosen ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
