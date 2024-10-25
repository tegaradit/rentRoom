<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PeminjamanSayaController extends Controller
{
    public function index()
    {
        $menu = 'ruangan';
        $submenu = 'ruangan';

        // Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // Cek peran pengguna dan ambil data yang sesuai dengan user_id mereka
        if ($user->role === 'admin') {
            // Jika pengguna adalah admin, tampilkan semua data peminjaman
            $datas = data_peminjaman::all();
            return view('pages.admin.peminjaman_saya.index', compact('datas', 'menu', 'submenu'));
        } else {
            // Jika pengguna adalah user biasa, tampilkan hanya data milik mereka
            $datas = data_peminjaman::where('user_id', $user->id)->get();
            return view('pages.user.peminjaman_saya.index', compact('datas', 'menu', 'submenu'));
        }
    }
}
