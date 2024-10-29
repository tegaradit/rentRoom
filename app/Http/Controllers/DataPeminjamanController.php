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
        $totalPeminjaman = data_peminjaman::count();
        $disetujui = data_peminjaman::where('status', 'diterima')->count();
        $ditolak = data_peminjaman::where('status', 'ditolak')->count();
        $dibatalkan = data_peminjaman::where('status', 'dibatalkan')->count();
        $datas = data_peminjaman::all();
        return view('pages.admin.data_peminjaman.index', compact('menu','submenu', 'totalPeminjaman', 'disetujui', 'ditolak', 'dibatalkan', 'datas'));
    }

    public function setuju($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        $peminjaman->status = 'diterima';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

}