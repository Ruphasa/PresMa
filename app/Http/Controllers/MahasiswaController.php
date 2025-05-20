<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

    public function create_ajax()
    {
        $user = UserModel::all();
        return view('admin.Mahasiswa.create_ajax', ['user' => $user]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|integer|exists:m_user,user_id',
                'user_kode' => 'required|string|min:3|unique:t_user,user_kode',
                'user_tanggal' => 'required|date',
                'stok_id' => 'required|array',
                'stok_id.*' => 'required|integer|exists:t_stok,stok_id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1'
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
                // Simpan data user utama
                $user = UserModel::create([
                    'user_id' => $request->user_id,
                    'user_kode' => $request->user_kode,
                    'user_tanggal' => $request->user_tanggal,
                ]);
            
            $mahasiswa = [];
                // Simpan semua mahasiswa user
                MahasiswaModel::insert($mahasiswa);

                \DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data User dan Detail berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    // Menampilkan mahasiswa User
    public function show_ajax(string $id)
    {
        $User = UserModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page =
            (object) [
                'title' => 'Detail User'
            ];
        $mahasiswa = MahasiswaModel::where('user_id', $id)
            ->with('user')
            ->get();
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('admin.Mahasiswa.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'User' => $User, 'mahasiswa' => $mahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function confirm_ajax(string $id)
    {
        $User = UserModel::find($id);
        $mahasiswa = MahasiswaModel::where('user_id', $id)
            ->with('user')
            ->get();
        return view('admin.Mahasiswa.confirm_ajax', ['user' => $User, 'mahasiswa' => $mahasiswa]);
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

            \DB::beginTransaction();
            try {
                // Hapus semua mahasiswa user terkait
                $mahasiswa = MahasiswaModel::where('user_id', $id)->get();
                $mahasiswa->delete();

                // Hapus user utama
                $user->delete();

                \DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data user dan mahasiswanya berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }
    public function import()
    {
        return view('User.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_User' => 'required|mimes:xls,xlsx|max:1024'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_User'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'user_id' => $value['A'],
                            'User_kode' => $value['B'],
                            'punjualan_tanggal' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    UserModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil di import'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang di import'
                ]);
            }
        }
        return redirect('/');
    }
    public function export_excel()
    {
        $User = UserModel::select('user_id', 'User_kode', 'User_nama', 'harga_beli', 'harga_jual')
            ->orderBy('user_id')
            ->orderBy('User_kode')
            ->with('user')
            ->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode User');
        $sheet->setCellValue('C1', 'Nama Pembeli');
        $sheet->setCellValue('D1', 'Tanggal User');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $no = 1;
        $baris = 2;
        foreach ($User as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->User_kode);
            $sheet->setCellValue('C' . $baris, $value->user->username);
            $sheet->setCellValue('D' . $baris, $value->user_tanggal);
            $baris++;
            $no++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data User');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-offocedocumentsreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d MY H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $user = MahasiswaModel::select('nim', 'user_id', 'prodi_id', 'dosen_id')
            ->orderBy('user_id')
            ->orderBy('user_kode')
            ->with('user')
            ->get();

        // use Barryvdh\DomPDF \Facade\Pdf;
        $pdf = Pdf::loadView('admin.Mahasiswa.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data User' . date('Y-m-d H:i:s') . '.pdf');
    }
}
