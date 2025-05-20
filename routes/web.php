<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ListAchievementController;
use App\Http\Controllers\ListCompetitionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
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

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'store']);
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
Route::get('Admin/User/create_ajax', [UserController::class, 'create_ajax']);
Route::post('Admin/User/ajax', [UserController::class, 'store_ajax']);


Route::get('/Admin/Competition', [CompetitionController::class, 'index']);
Route::post('/Admin/Competition/list', [CompetitionController::class, 'list']);

Route::get('/Admin/Achievement', [AchievementController::class, 'index']);
Route::post('/Admin/Achievement/list', [AchievementController::class, 'list']);


