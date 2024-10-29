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
        if ($user->role_id == 2) {
            // Jika pengguna adalah admin, tampilkan halaman admin
            $datas = data_peminjaman::where('user_id', $user->id)->get();
            return view('pages.user.peminjaman_saya.index', compact('datas', 'menu', 'submenu'));
        } else {
            // Jika role_id tidak sesuai, arahkan ke halaman tidak diizinkan atau halaman error
            abort(403, 'Akses tidak diizinkan');
        }
    }
}
