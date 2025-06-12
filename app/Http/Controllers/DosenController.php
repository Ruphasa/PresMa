<?php
namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
        return view('Admin.Dosen.create_ajax', ['user' => $user]);
    }

    public function store_ajax(Request $request)
    {

        \DB::beginTransaction();
        try {
            // Simpan data mahasiswa
            $user = UserModel::create([
                'nama'     => $request->nama,
                'password' => $request->password,
                'level_id' => '2',
                'email'    => $request->email,
                'img'      => $request->img,
            ]);

            DosenModel::create([
                'nidn'    => $request->nidn,
                'user_id' => $user->user_id,
            ]);
            \DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Data Dosen berhasil disimpan',
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $dosen = DosenModel::with(['user', 'mahasiswa'])->find($id);
        if (! $dosen) {
            return response()->json([
                'status'  => false,
                'message' => 'Dosen tidak ditemukan',
            ]);
        }

        return view('Admin.Dosen.show_ajax', [
            'breadcrumb' => (object) [
                'title' => 'Detail Dosen',
                'list'  => ['Home', 'Dosen', 'Detail'],
            ],
            'page'       => (object) ['title' => 'Detail Dosen'],
            'dosen'      => $dosen,
            'activeMenu' => 'dosen',
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $dosen = DosenModel::find($id);
            if (! $dosen) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Dosen tidak ditemukan',
                ]);
            }

            try {
                $dosen->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data dosen berhasil dihapus',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage(),
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $dosen = DosenModel::with('user')->get();

        $pdf = Pdf::loadView('Admin.Dosen.export_pdf', ['dosen' => $dosen]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        return $pdf->stream('Data Dosen ' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function edit_ajax($id)
    {
        $dosen = DosenModel::with('user')->find($id);

        return view('Admin.Dosen.edit_ajax', [
            'dosen' => $dosen,
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $dosen = DosenModel::findOrFail($id);
            $user  = $dosen->user;

            // Update user
            $user->nama  = $request->nama;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            // Update dosen
            $dosen->username = $request->username;
            $dosen->save();

            \DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Data Dosen berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ]);
        }
    }

}
