<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function list(Request $request)
{
    $admin = AdminModel::with('user')->get();
    return DataTables::of($admin)
        ->addIndexColumn()
        ->addColumn('nama', function ($admin) { return $admin->user ? $admin->user->nama : '-'; })
        ->addColumn('email', function ($admin) { return $admin->user ? $admin->user->email : '-'; })
        ->addColumn('img', function ($admin) { return $admin->user && $admin->user->img ? '<img src="' . asset($admin->user->img) . '" alt="Image" style="width: 50px; height: auto;">' : '-'; })
        ->addColumn('action', function ($admin) {
            $btn = '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/admin/' . $admin->admin_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['img', 'action'])
        ->make(true);
}
}
