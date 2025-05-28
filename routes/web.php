<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ListAchievementController;
use App\Http\Controllers\ListCompetitionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route:: pattern('id', '[0-9]+');

Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'postlogin']);
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'store']);

Route::middleware(['auth'])->group(function() {
    Route::get('/', [LandingPageController::class, 'index']);

Route::get('/home', [LandingPageController::class, 'index']);

Route::get('/Achievement', [ListAchievementController::class, 'index']);

Route::get('/Competition    ', [ListCompetitionController::class, 'index']);

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/Admin', [DashboardController::class, 'index']);
Route::get('/Admin/User', [UserController::class, 'index']);
Route::post('/Admin/mahasiswa/list', [MahasiswaController::class, 'list']);
Route::post('/Admin/dosen/list', [DosenController::class, 'list']);
Route::post('/Admin/admin/list', [AdminController::class, 'list']);

// Profile Edits
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::group(['prefix' => 'Admin/mahasiswa'], function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
            Route::get('/create_ajax', [MahasiswaController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [MahasiswaController::class, 'store_ajax']); // menyimpan data user baru ajax
            Route::get('/{id}/show_ajax', [MahasiswaController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [MahasiswaController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [MahasiswaController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [MahasiswaController::class, 'confirm_ajax']); // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [MahasiswaController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [MahasiswaController::class, 'import']); // menampilkan halaman form import User
            Route::post('/import_ajax', [MahasiswaController::class, 'import_ajax']); // menyimpan data User dari file import
            Route::get('/export_excel', [MahasiswaController::class,'export_excel']); // ajax export excel
            Route::get('/export_pdf', [MahasiswaController::class,'export_pdf']); // ajax export pdf
        });

        Route::group(['prefix' => 'Admin/dosen'], function () {
            Route::get('/', [DosenController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
            Route::get('/create_ajax', [DosenController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [DosenController::class, 'store_ajax']); // menyimpan data user baru ajax
            Route::get('/{id}', [DosenController::class, 'show']); // menampilkan detail user
            Route::get('/{id}/show_ajax', [DosenController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [DosenController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [DosenController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [DosenController::class, 'confirm_ajax']); // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [DosenController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [DosenController::class, 'import']); // menampilkan halaman form import User
            Route::post('/import_ajax', [DosenController::class, 'import_ajax']); // menyimpan data User dari file import
            Route::get('/export_excel', [DosenController::class,'export_excel']); // ajax export excel
            Route::get('/export_pdf', [DosenController::class,'export_pdf']); // ajax export pdf
        });

        Route::group(['prefix' => 'Admin/admin'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
            Route::get('/create_ajax', [AdminController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [AdminController::class, 'store_ajax']); // menyimpan data user baru ajax
            Route::get('/{id}', [AdminController::class, 'show']); // menampilkan detail user
            Route::get('/{id}/show_ajax', [AdminController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [AdminController::class, 'edit_ajax']); // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [AdminController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [AdminController::class, 'confirm_ajax']); // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [AdminController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [AdminController::class, 'import']); // menampilkan halaman form import User
            Route::post('/import_ajax', [AdminController::class, 'import_ajax']); // menyimpan data User dari file import
            Route::get('/export_excel', [AdminController::class,'export_excel']); // ajax export excel
            Route::get('/export_pdf', [AdminController::class,'export_pdf']); // ajax export pdf
        });


Route::prefix('prodi')->group(function () {
    Route::post('/list', [ProdiController::class, 'list']); // datatables ajax
    Route::get('/create_ajax', [ProdiController::class, 'create_ajax']); // form create
    Route::post('/ajax', [ProdiController::class, 'store_ajax']); // store via ajax
    Route::get('/{id}/show_ajax', [ProdiController::class, 'show_ajax']); // detail prodi
    Route::delete('/{id}/delete_ajax', [ProdiController::class, 'delete_ajax']); // hapus via ajax
});

        
Route::get('/Admin/Competition', [CompetitionController::class, 'index']);
Route::post('/Admin/competition/listPending', [CompetitionController::class, 'listPending'])->name('competition.listPending');
Route::post('/Admin/competition/listValid', [CompetitionController::class, 'listValid'])->name('competition.listValid');
Route::get('/Admin/competition/{id}/validate_ajax', [CompetitionController::class,'confirmValidate']);
Route::post('/Admin/competition/{id}/validate_ajax', [CompetitionController::class,'validate_ajax']);
Route::get('/Admin/competition/{id}/reject_ajax', [CompetitionController::class,'confirmReject']);
Route::post('/Admin/competition/{id}/reject_ajax', [CompetitionController::class,'reject_ajax']);
Route::get('/competition/{lomba_id}', [ListCompetitionController::class, 'show'])->name('competition.detail');

Route::get('/Admin/Achievement', [AchievementController::class, 'index']);
Route::post('/Admin/achievement/listPending', [AchievementController::class, 'listPending'])->name('achievement.listPending');
Route::post('/Admin/achievement/listValid', [AchievementController::class, 'listValid'])->name('achievement.listValid');
Route::get('/Admin/achievement/{id}/validate_ajax', [AchievementController::class,'confirmValidate']);
Route::post('/Admin/achievement/{id}/validate_ajax', [AchievementController::class,'validate_ajax']);
Route::get('/Admin/achievement/{id}/reject_ajax', [AchievementController::class,'confirmReject']);
Route::post('/Admin/achievement/{id}/reject_ajax', [AchievementController::class,'reject_ajax']);
Route::get('/Dosen/achievement', [AchievementController::class, 'dosen']);
Route::post('/Dosen/achievement/list', [AchievementController::class, 'listDosen']);


});
