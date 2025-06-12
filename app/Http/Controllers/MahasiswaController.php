<?php
namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\KategoriModel;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                $btn = '<button onclick="modalAction(\'' . url('Admin/mahasiswa/' . $mahasiswa->nim .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('Admin/mahasiswa/' . $mahasiswa->nim .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('Admin/mahasiswa/' . $mahasiswa->nim .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::all();
        $dosen = DosenModel::all();
        $prodi = ProdiModel::all();
        return view('Admin.mahasiswa.create_ajax', ['level' => $level, 'dosen' => $dosen, 'prodi' => $prodi]);
    }

    public function store_ajax(Request $request)
    {
        // Pastikan ini adalah request AJAX
        if (! $request->ajax() && ! $request->wantsJson()) {
            // Ini seharusnya tidak tercapai jika ini dipanggil via AJAX
            return redirect('/');
        }

        // 1. Definisikan semua aturan validasi untuk User dan Mahasiswa sekaligus
        // Perhatikan nama field harus sesuai dengan name di form blade
        $rules = [
            'nim'      => 'required|string|max:20|unique:m_mahasiswa,nim',
            // 'user_id' tidak diperlukan di sini karena akan dibuat otomatis
            'nama'     => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'level_id' => 'required|integer|exists:m_level,level_id',
            'email'    => 'required|email|max:255|unique:m_user,email',
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // name="image" di blade
            'prodi_id' => 'required|integer|exists:m_prodi,prodi_id',       // Pastikan m_prodi adalah tabel yang benar
            'dosen_id' => 'required|string|exists:m_dosen,nidn',            // Validasi untuk NIDN
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal.',
                'msgField' => $validator->errors()->toArray(), // Mengubah ke array untuk ditampilkan di frontend
            ], 422);                                       // Status code 422 Unprocessable Entity cocok untuk validasi gagal
        }

        DB::beginTransaction(); // Mulai transaksi database
        try {
            // 2. Tangani Upload Gambar Terlebih Dahulu
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image     = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/mahasiswa_images', $imageName);
                $imagePath = Storage::url($imagePath); // Dapatkan url publik
            }

            // 3. Simpan data ke tabel User (m_user)
            $user = UserModel::create([
                'nama'     => $request->nama,
                'password' => Hash::make($request->password), // WAJIB HASH PASSWORD!
                'level_id' => $request->level_id,
                'email'    => $request->email,
                'img'      => $imagePath, // Simpan path gambar yang sudah di-upload
            ]);

            // 4. Simpan data ke tabel Mahasiswa (m_mahasiswa) menggunakan user_id yang baru dibuat
            MahasiswaModel::create([
                'nim'      => $request->nim,
                'user_id'  => $user->user_id, // Gunakan ID dari user yang baru dibuat
                'prodi_id' => $request->prodi_id,
                'dosen_id' => $request->dosen_id,
            ]);

            DB::commit(); // Komit transaksi jika semua berhasil

            return response()->json([
                'status'  => true,
                'message' => 'Data Mahasiswa berhasil disimpan.',
            ], 200); // Status code 200 OK untuk sukses

        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika ada error
                            // Hapus gambar yang sudah diupload jika terjadi error saat menyimpan ke DB
            if ($imagePath && Storage::exists(str_replace('/storage/', 'public/', $imagePath))) {
                Storage::delete(str_replace('/storage/', 'public/', $imagePath));
            }

            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data mahasiswa. Error: ' . $e->getMessage(),
            ], 500); // Status code 500 Internal Server Error untuk error server
        }
    }

    // Menampilkan detail mahasiswa
    public function show_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::where('nim', $id)
            ->with(['user', 'prodi', 'dosen']) // Eager load relasi
            ->first();

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $breadcrumb = (object) [
            'title' => 'Detail Mahasiswa',
            'list'  => ['Home', 'Mahasiswa', 'Detail'],
        ];
        $page =
        (object) [
            'title' => 'Detail Mahasiswa',
        ];
        $activeMenu = 'mahasiswa';
        return view('Admin.mahasiswa.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mahasiswa' => $mahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function confirm_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::where('user_id', $id)->with('user')->first();

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
        return view('Admin.mahasiswa.confirm_ajax', ['mahasiswa' => $mahasiswa]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = MahasiswaModel::where('user_id', $id)->first();

            if (! $mahasiswa) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }

            \DB::beginTransaction();
            try {
                // Hapus mahasiswa
                $mahasiswa->delete();

                \DB::commit();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data mahasiswa berhasil dihapus',
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage(),
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
                'file_User' => 'required|mimes:xls,xlsx|max:1024',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $file   = $request->file('file_User');                   // ambil file dari request
            $reader = IOFactory::createReader('Xlsx');               // load reader file excel
            $reader->setReadDataOnly(true);                          // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath());      // load file excel
            $sheet       = $spreadsheet->getActiveSheet();           // ambil sheet yang aktif
            $data        = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert      = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'user_id'           => $value['A'],
                            'User_kode'         => $value['B'],
                            'punjualan_tanggal' => $value['C'],
                            'created_at'        => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    UserModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil di import',
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang di import',
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
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode User');
        $sheet->setCellValue('C1', 'Nama Pembeli');
        $sheet->setCellValue('D1', 'Tanggal User');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $no    = 1;
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

        $writer   = IOFactory::createWriter($spreadsheet, 'Xlsx');
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

        $pdf = Pdf::loadView('Admin.mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait');

        // Enable remote assets safely
        $pdf->getDomPDF()->getOptions()->setIsRemoteEnabled(true);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Data mahasiswa.pdf"');
    }

    public function edit_ajax($nim)
    {
        $mahasiswa = MahasiswaModel::where('nim', $nim)
            ->with(['user', 'prodi', 'dosen'])
            ->first();

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $level    = LevelModel::all();
        $dosen    = DosenModel::all();
        $prodi    = ProdiModel::all();
        $kategori = KategoriModel::all();

        return view('Admin.mahasiswa.edit_ajax', [
            'mahasiswa' => $mahasiswa,
            'level'     => $level,
            'dosen'     => $dosen,
            'prodi'     => $prodi,
            'kategori'  => $kategori,
        ]);
    }

    public function update_ajax(Request $request, $nim)
    {
        if (! $request->ajax() && ! $request->wantsJson()) {
            return redirect('/');
        }

        $mahasiswa = MahasiswaModel::where('nim', $nim)->with('user')->first();

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:m_user,email,' . $mahasiswa->user_id . ',user_id',
            'level_id' => 'required|integer|exists:m_level,level_id',
            'prodi_id' => 'required|integer|exists:m_prodi,prodi_id',
            'dosen_id' => 'required|string|exists:m_dosen,nidn',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors()->toArray(),
            ], 422);
        }

        \DB::beginTransaction();
        try {
            // Jika ada gambar baru di-upload
            if ($request->hasFile('image')) {
                $image     = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/mahasiswa_images', $imageName);
                $imagePath = \Storage::url($imagePath);

                // Hapus gambar lama
                if ($mahasiswa->user->img && \Storage::exists(str_replace('/storage/', 'public/', $mahasiswa->user->img))) {
                    \Storage::delete(str_replace('/storage/', 'public/', $mahasiswa->user->img));
                }

                $mahasiswa->user->img = $imagePath;
            }

            // Update data user
            $mahasiswa->user->nama     = $request->nama;
            $mahasiswa->user->email    = $request->email;
            $mahasiswa->user->level_id = $request->level_id;
            $mahasiswa->user->save();

            // Update data mahasiswa
            $mahasiswa->prodi_id = $request->prodi_id;
            $mahasiswa->dosen_id = $request->dosen_id;
            $mahasiswa->save();

            \DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Data mahasiswa berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
