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
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NotificationController;
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

Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::get('/', [LandingPageController::class, 'index']);
    Route::get('/home', [LandingPageController::class, 'index']);
    Route::get('notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
    Route::post('/find-recommendations/{competition_id}', [CompetitionController::class, 'findRecommendations']);

    Route::get('/Achievement', [ListAchievementController::class, 'index']);
    Route::get('/Achievement/{id}', [AchievementController::class, 'show_ajax']);

    Route::get('/ListCompetition', [ListCompetitionController::class, 'index']);

    Route::get('/Competition/{id}', [ListCompetitionController::class, 'show']);
    Route::get('/Competition/create', [ListCompetitionController::class, 'create']);
    Route::put('/Competition/store', [ListCompetitionController::class, 'store']);
    Route::get('/Competition/{id}/edit', [ListCompetitionController::class, 'edit']);

    // Profile Edits
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::group(['prefix' => 'Dosen'], function () {
        Route::get('/achievement', [AchievementController::class, 'dosen']);
        Route::post('/achievement/list', [AchievementController::class, 'listDosen']);
    });

    Route::group(['prefix' => 'Student/achievement'], function () {
        Route::get('/', [ListAchievementController::class, 'studentIndex']);
        Route::post('/listPending', [ListAchievementController::class, 'listPending'])->name('achievement.listPending');
        Route::post('/listValid', [ListAchievementController::class, 'listValid'])->name('achievement.listValid');
        Route::post('/listReject', [ListAchievementController::class, 'listRejected'])->name('achievement.listRejected');
        Route::get('/new', [ListAchievementController::class, 'create']);
        Route::put('/store', [ListAchievementController::class, 'store']);
        Route::get('/{id}', [ListAchievementController::class, 'show']);
        Route::get('/{id}/edit', [ListAchievementController::class, 'edit']);
        Route::put('/{id}/update', [ListAchievementController::class, 'update']);
    });

    Route::group(['prefix' => 'Admin'], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');
        Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.exportPdf');
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/mahasiswa/list', [MahasiswaController::class, 'list']);
        Route::post('/dosen/list', [DosenController::class, 'list']);
        Route::post('/admin/list', [AdminController::class, 'list']);

        Route::group(['prefix' => '/mahasiswa'], function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('user.index');      // menampilkan halaman awal user
            Route::get('/create_ajax', [MahasiswaController::class, 'create_ajax']);         // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [MahasiswaController::class, 'store_ajax']);                // menyimpan data user baru ajax
            Route::get('/{id}/show_ajax', [MahasiswaController::class, 'show_ajax']);        // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [MahasiswaController::class, 'edit_ajax']);        // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [MahasiswaController::class, 'update_ajax']);    // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [MahasiswaController::class, 'confirm_ajax']);   // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [MahasiswaController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [MahasiswaController::class, 'import']);                   // menampilkan halaman form import User
            Route::post('/import_ajax', [MahasiswaController::class, 'import_ajax']);        // menyimpan data User dari file import
            Route::get('/export_excel', [MahasiswaController::class, 'export_excel']);       // ajax export excel
            Route::get('/export_pdf', [MahasiswaController::class, 'export_pdf']);           // ajax export pdf
        });

        Route::group(['prefix' => '/dosen'], function () {
            Route::get('/', [DosenController::class, 'index'])->name('user.index');      // menampilkan halaman awal user
            Route::get('/create_ajax', [DosenController::class, 'create_ajax']);         // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [DosenController::class, 'store_ajax']);                // menyimpan data user baru ajax
            Route::get('/{id}', [DosenController::class, 'show']);                       // menampilkan detail user
            Route::get('/{id}/show_ajax', [DosenController::class, 'show_ajax']);        // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [DosenController::class, 'edit_ajax']);        // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [DosenController::class, 'update_ajax']);    // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [DosenController::class, 'confirm_ajax']);   // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [DosenController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [DosenController::class, 'import']);                   // menampilkan halaman form import User
            Route::post('/import_ajax', [DosenController::class, 'import_ajax']);        // menyimpan data User dari file import
            Route::get('/export_excel', [DosenController::class, 'export_excel']);       // ajax export excel
            Route::get('/export_pdf', [DosenController::class, 'export_pdf']);           // ajax export pdf
        });

        Route::group(['prefix' => '/admin'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('user.index');      // menampilkan halaman awal user
            Route::get('/create_ajax', [AdminController::class, 'create_ajax']);         // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [AdminController::class, 'store_ajax']);                // menyimpan data user baru ajax
            Route::get('/{id}', [AdminController::class, 'show']);                       // menampilkan detail user
            Route::get('/{id}/show_ajax', [AdminController::class, 'show_ajax']);        // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [AdminController::class, 'edit_ajax']);        // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [AdminController::class, 'update_ajax']);    // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [AdminController::class, 'confirm_ajax']);   // untuk tampilan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [AdminController::class, 'delete_ajax']); // menghapus data user ajax
            Route::get('/import', [AdminController::class, 'import']);                   // menampilkan halaman form import User
            Route::post('/import_ajax', [AdminController::class, 'import_ajax']);        // menyimpan data User dari file import
            Route::get('/export_excel', [AdminController::class, 'export_excel']);       // ajax export excel
            Route::get('/export_pdf', [AdminController::class, 'export_pdf']);           // ajax export pdf
        });

        Route::group(['prefix' => '/prodi'], function () {
            Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
            Route::post('/list', [ProdiController::class, 'list'])->name('prodi.list');
            Route::get('/create_ajax', [ProdiController::class, 'create_ajax'])->name('prodi.create_ajax');
            Route::post('/ajax', [ProdiController::class, 'store_ajax'])->name('prodi.store_ajax');
            Route::get('/{id}/show_ajax', [ProdiController::class, 'show_ajax'])->name('prodi.show_ajax');
            Route::get('/{id}/edit_ajax', [ProdiController::class, 'edit_ajax'])->name('prodi.edit_ajax');
            Route::put('/{id}/update_ajax', [ProdiController::class, 'update_ajax'])->name('prodi.update_ajax');
            Route::delete('/{id}/delete_ajax', [ProdiController::class, 'delete_ajax'])->name('prodi.delete_ajax');
        });

        Route::group(['prefix' => '/competition'], function () {
            Route::get('/', [CompetitionController::class, 'index']);
            Route::post('/listPending', [CompetitionController::class, 'listPending'])->name('competition.listPending');
            Route::post('/listValid', [CompetitionController::class, 'listValid'])->name('competition.listValid');
            Route::get('/{id}/validate_ajax', [CompetitionController::class, 'confirmValidate']);
            Route::post('/{id}/validate_ajax', [CompetitionController::class, 'validate_ajax']);
            Route::get('/{id}/reject_ajax', [CompetitionController::class, 'confirmReject']);
            Route::post('/{id}/reject_ajax', [CompetitionController::class, 'reject_ajax']);
            Route::get('/{id}', [CompetitionController::class, 'show_ajax']);
        });

        Route::group(['prefix' => '/achievement'], function () {
            Route::get('/', [AchievementController::class, 'index']);
            Route::post('/listPending', [AchievementController::class, 'listPending'])->name('achievement.listPending');
            Route::post('/listValid', [AchievementController::class, 'listValid'])->name('achievement.listValid');
            Route::get('/{id}/show_ajax', [AchievementController::class, 'show_ajax']);
            Route::get('/{id}/validate_ajax', [AchievementController::class, 'confirmValidate']);
            Route::post('/{id}/validate_ajax', [AchievementController::class, 'validate_ajax']);
            Route::get('/{id}/reject_ajax', [AchievementController::class, 'confirmReject']);
            Route::post('/{id}/reject_ajax', [AchievementController::class, 'reject_ajax']);
        });
    });

    Route::post('/prodi/list', [ProdiController::class, 'list'])->name('prodi.list');

});
