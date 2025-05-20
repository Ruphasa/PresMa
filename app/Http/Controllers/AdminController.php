<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Mahasiswa;

class AdminController extends Controller
{
    public function list(Request $request)
{
    $admin = AdminModel::with('user')->get();
    return DataTables::of($admin)
        ->addIndexColumn()
        ->addColumn('nama', function ($admin) { return $admin->user ? $admin->user->nama : '-'; })
        ->addColumn('email', function ($admin) { return $admin->user ? $admin->user->email : '-'; })
        ->addColumn('img', function ($admin) { return $admin->user && $admin->user->img ? '<img src="' . asset($admin->user->img) . '" alt="Image" style="width: 50px; height: auto;">' : '-'; })
        ->addColumn('action', function ($admin) {
            $btn = '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['img', 'action'])
        ->make(true);
}

  public function create_ajax() 
    { 
        $kategori = AdminModel::select('kategori_id', 'kategori_nama')->get(); 
        return  view('admin.create_ajax')->with('admin', $admin); 
    } 
 
  public function storeAdminAjax(Request $request): JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|unique:admin,username',
                'nama'     => 'required|string|max:100',
                'email'    => 'required|email|unique:admin,email',
                'password' => 'required|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            AdminModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data admin berhasil disimpan'
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid request']);
    }
}
