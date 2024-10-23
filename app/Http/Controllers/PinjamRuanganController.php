<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
class PinjamRuanganController extends Controller
{
    public function index()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        $datas = Ruangan::latest()->paginate(10);
        return view('pages.admin.pinjam_ruangan.index', compact('menu', 'submenu', 'datas'));
    }
}
