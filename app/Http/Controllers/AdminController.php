<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $admin = AdminModel::select('nip', 'user_id')
            ->with(['user'])
            ->get();

        return DataTables::of($admin)
            ->addIndexColumn()
            ->addColumn('nama_user', function ($admin) {
                return $admin->user ? $admin->user->nama : '-';
            })
            ->addColumn('action', function ($admin) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/' . $admin->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $user = UserModel::all();
        return view('admin.Admin.create_ajax', ['user' => $user]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nip' => 'required|string|unique:m_admin,nip',
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
                AdminModel::create($request->only(['nip', 'user_id']));
                return response()->json([
                    'status' => true,
                    'message' => 'Data Admin berhasil disimpan'
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
        $user = UserModel::find($id);
        $admin = AdminModel::where('user_id', $id)->with('user')->get();

        return view('admin.Admin.show_ajax', [
            'breadcrumb' => (object)[
                'title' => 'Detail Admin',
                'list' => ['Home', 'Admin', 'Detail']
            ],
            'page' => (object)['title' => 'Detail Admin'],
            'user' => $user,
            'admin' => $admin,
            'activeMenu' => 'admin'
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            try {
                AdminModel::where('user_id', $id)->delete();
                $user->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data admin dan user berhasil dihapus'
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
        $admin = AdminModel::select('nip', 'user_id')
            ->with('user')
            ->orderBy('user_id')
            ->get();

        $pdf = Pdf::loadView('admin.Admin.export_pdf', ['admin' => $admin]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        return $pdf->stream('Data Admin ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
