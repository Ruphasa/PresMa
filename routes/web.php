<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ListAchievementController;
use App\Http\Controllers\ListCompetitionController;
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

Route::get('/', [LandingPageController::class, 'index']);
Route::get('/home', [LandingPageController::class, 'index']);

Route::get('/Acheivement', [ListAchievementController::class, 'index']);

Route::get('/Competitions', [ListCompetitionController::class, 'index']);

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/Admin', [DashboardController::class, 'index']);

Route::get('/Admin/user', function () {
    return view('user');
});

Route::get('/Admin/Competition', [CompetitionController::class, 'index']);
Route::post('/Admin/Competition/list', [CompetitionController::class, 'list']);

Route::get('/Admin/Achievement', function () {
    return view('achievement');
});

