<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use App\Models\DataPeminjaman;
use Illuminate\Http\Request;

class DataPeminjamanController extends Controller
{
    public function index()
    {
        $menu = 'data_peminjaman';
        $submenu = 'data_peminjaman';
        $datas = data_peminjaman::latest()->paginate(10);
        return view('pages.admin.data_peminjaman.index', compact('menu', 'submenu', 'datas'));
    }
}