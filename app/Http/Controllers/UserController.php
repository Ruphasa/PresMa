<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Admin;
use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'User List',
            'list' => ['Admin /', 'User'],
        ];
        $page = (object) [
            'title' => 'Daftar Mahasiswa yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user';
        return view('Admin.user', compact('breadcrumb', 'page', 'activeMenu'));
    }
}
