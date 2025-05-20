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
        $mahasiswa = MahasiswaModel::with(['user', 'prodi', 'dosen'])->get();

        return DataTables::of($mahasiswa)
            ->addIndexColumn()
            ->addColumn('dosen', function ($mahasiswa) {
                return $mahasiswa->dosen ? $mahasiswa->dosen->user->nama : '-';
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
                'nim' => 'required|string|min:3|unique:m_mahasiswa,nim', // Tambah validasi untuk NIM
                'prodi_id' => 'required|integer|exists:m_prodi,prodi_id', // Tambah validasi prodi_id
                'dosen_id' => 'nullable|string|exists:m_dosen,nidn',
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
                $mahasiswa = MahasiswaModel::create([
                    'nim' => $request->nim, // Gunakan NIM dari request
                    'user_id' => $request->user_id,
                    'prodi_id' => $request->prodi_id, // Simpan prodi_id
                    'dosen_id' => $request->dosen_id,
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
        return redirect('/');
    }

    // Menampilkan detail mahasiswa
    public function show_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::where('user_id', $id)
            ->with(['user', 'prodi', 'dosen']) // Eager load relasi
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        $breadcrumb = (object) [
            'title' => 'Detail Mahasiswa',
            'list' => ['Home', 'Mahasiswa', 'Detail']
        ];
        $page =
            (object) [
                'title' => 'Detail Mahasiswa'
            ];
        $activeMenu = 'mahasiswa';
        return view('admin.Mahasiswa.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mahasiswa' => $mahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function confirm_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::where('user_id', $id)->with('user')->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return view('admin.Mahasiswa.confirm_ajax', ['mahasiswa' => $mahasiswa]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = MahasiswaModel::where('user_id', $id)->first();

            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            \DB::beginTransaction();
            try {
                // Hapus mahasiswa
                $mahasiswa->delete();

                \DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil dihapus'
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
        $mahasiswa = MahasiswaModel::with(['user', 'prodi', 'dosen'])->get();

        // use Barryvdh\DomPDF \Facade\Pdf;
        $pdf = Pdf::loadView('admin.Mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();
        return $pdf->stream('Data Mahasiswa' . date('Y-m-d H:i:s') . '.pdf');
    }
}
