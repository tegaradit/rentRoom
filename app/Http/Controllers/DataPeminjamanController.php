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
        $datas = data_peminjaman::with('ruangan')->get();
        return view('pages.admin.data_peminjaman.index', compact('menu', 'submenu', 'totalPeminjaman', 'disetujui', 'ditolak', 'datas'));
    }

    public function setuju($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        if ($peminjaman->status != 'pending') {
            return redirect()->back()->with('error', 'Status peminjaman tidak dapat diubah.');
        }
        $peminjaman->status = 'diterima';
        $peminjaman->save();

        // Ubah status ruangan menjadi 'terpinjam'
        $ruangan = $peminjaman->ruangan; // Relasi dari peminjaman ke ruangan
        $ruangan->status = 'terpinjam';
        $ruangan->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        if ($peminjaman->status != 'pending') {
            return redirect()->back()->with('error', 'Status peminjaman tidak dapat diubah.');
        }
        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        // Ubah status ruangan menjadi 'tersedia'
        $ruangan = $peminjaman->ruangan; // Relasi dari peminjaman ke ruangan
        $ruangan->status = 'tersedia';
        $ruangan->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}