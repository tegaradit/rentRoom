<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanSayaController extends Controller
{
    public function index()
    {
        $menu = 'peminjaman_saya';
        $submenu = 'peminjaman_saya';
        $user = Auth::user();

        if ($user->role_id == 2) {
            $datas = data_peminjaman::where('user_id', $user->id)
                ->with('ruangan')
                ->get();

            return view('pages.user.peminjaman_saya.index', compact('datas', 'menu', 'submenu'));
        } else {
            abort(403, 'Akses tidak diizinkan');
        }
    }

    public function riwayat()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        $riwayat = data_peminjaman::where('user_id', auth()->id())
            ->where('status', '!=', 'pending')
            ->get();

        return view('pages.user.peminjaman_saya.riwayat', compact('menu', 'submenu', 'riwayat'));
    }

    public function destroy(string $id)
    {
        $gol = data_peminjaman::findOrFail($id);
        $gol->delete();
        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan');
    }
}
