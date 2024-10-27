<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PinjamRuanganController extends Controller
{
    public function index()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        $datas = Ruangan::latest()->paginate(10);
        return view('pages.admin.pinjam_ruangan.index', compact('menu', 'submenu', 'datas'));
    }

    public function pinjam($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('pages.admin.pinjam_ruangan.form', compact('ruangan'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tgl_peminjaman' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'keperluan' => 'required|string',
            'status' => 'required|string',
        ]);

        data_peminjaman::create($validatedData);

        return redirect()->route('pinjam-ruangan.index')->with('success', 'Peminjaman berhasil diajukan!');
    }
}
