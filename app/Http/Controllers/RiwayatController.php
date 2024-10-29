<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        return view('pages.user.peminjaman_saya.riwayat', compact('menu', 'submenu'));
    }
}
