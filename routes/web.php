<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/course', function () {
    return view('course');
});

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/admin', function () {
    return view('dashboard');
});

Route::get('/admin/user', function () {
    return view('user');
});

Route::get('/admin/competition', function () {
    return view('competition');
});
Route::get('/admin/achievement', function () {
    return view('achievement');
});

