<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinjamRuanganController extends Controller
{
    public function index()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        return view('pages.admin.pinjam_ruangan.index', compact('menu', 'submenu'));
    }
}
