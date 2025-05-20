<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ListAchievementController;
use App\Http\Controllers\ListCompetitionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MahasiswaController;
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

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/', [LandingPageController::class, 'index']);
Route::get('/home', [LandingPageController::class, 'index']);

Route::get('/Acheivement', [ListAchievementController::class, 'index']);

Route::get('/Competitions', [ListCompetitionController::class, 'index']);

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/Admin', [DashboardController::class, 'index']);

Route::get('/Admin/User', [UserController::class, 'index']);
Route::post('/Admin/Mahasiswa/list', [MahasiswaController::class, 'list']);
Route::post('/Admin/Dosen/list', [DosenController::class, 'list']);
Route::post('/Admin/admin/list', [AdminController::class, 'list']);


        Route::group(['prefix' => 'Admin/mahasiswa'], function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
            Route::post('/list', action: [MahasiswaController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatable
            Route::get('/create_ajax', [MahasiswaController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [MahasiswaController::class, 'store_ajax']); // menyimpan data user baru ajax
            Route::get('/{id}', [MahasiswaController::class, 'show']); // menampilkan detail user
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
            Route::post('/list', action: [DosenController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatable
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
            Route::post('/list', action: [AdminController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatable
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


Route::get('/Admin/Competition', [CompetitionController::class, 'index']);
Route::post('/Admin/Competition/list', [CompetitionController::class, 'list']);

Route::get('/Admin/Achievement', [AchievementController::class, 'index']);
Route::post('/Admin/Achievement/list', [AchievementController::class, 'list']);


