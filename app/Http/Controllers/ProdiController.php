<?php
namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProdiController extends Controller
{
    public function index()
    {
        $activeMenu = 'prodi';

        $breadcrumb = (object) [
            'title' => 'Program Studi',
            'list'  => ['Admin', 'Program Studi'],
        ];

        // Ambil data program studi dari database
        $dataProdi = ProdiModel::all();

        return view('Admin.prodi.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'dataProdi'  => $dataProdi,
        ]);
    }

    public function list(Request $request)
    {
        $prodi = ProdiModel::withCount('mahasiswa')->get();

        return DataTables::of($prodi)
            ->addIndexColumn()
            ->addColumn('action', function ($prodi) {
                $btn = '<button onclick="modalAction(\'' . url('/Admin/prodi/' . $prodi->prodi_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Admin/prodi/' . $prodi->prodi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Admin/prodi/' . $prodi->prodi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('Admin.Prodi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'kode_prodi' => 'required|string|unique:m_prodi,kode_prodi',
            'nama_prodi' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            ProdiModel::create($request->only(['kode_prodi', 'nama_prodi']));
            return response()->json([
                'status'  => true,
                'message' => 'Data Prodi berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $prodi = ProdiModel::with('mahasiswa')->find($id);
        if (! $prodi) {
            return response()->json([
                'status'  => false,
                'message' => 'Prodi tidak ditemukan',
            ]);
        }

        return view('Admin.Prodi.show_ajax', [
            'prodi' => $prodi,
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        $prodi = ProdiModel::find($id);
        if (! $prodi) {
            return response()->json([
                'status'  => false,
                'message' => 'Prodi tidak ditemukan',
            ]);
        }

        try {
            $prodi->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data Prodi berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit_ajax(string $id)
    {
        $prodi = ProdiModel::find($id);
        if (! $prodi) {
            return response()->json([
                'status'  => false,
                'message' => 'Prodi tidak ditemukan',
            ]);
        }

        return view('Admin.prodi.edit_ajax', [
            'prodi' => $prodi,
        ]);
    }

    public function update_ajax(Request $request, string $id)
    {
        $rules = [
            'kode_prodi' => 'required|string|unique:m_prodi,kode_prodi,' . $id . ',prodi_id',
            'nama_prodi' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $prodi = ProdiModel::find($id);
            if (! $prodi) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Prodi tidak ditemukan',
                ]);
            }

            $prodi->update($request->only(['kode_prodi', 'nama_prodi']));
            return response()->json([
                'status'  => true,
                'message' => 'Data Prodi berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage(),
            ]);
        }
    }
}
