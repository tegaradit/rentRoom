<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use Illuminate\Support\Facades\Auth;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PinjamRuanganController extends Controller
{
    public function index()
    {
        $menu = 'data';
        $submenu = 'pinjam-ruangan';
        $user = Auth::user();

        // Check the user's role and retrieve data accordingly
        if ($user->role_id == 1) {
            // If the user is an admin, fetch all data for the admin view
            $datas = Ruangan::latest()->paginate(10);
            return view('pages.admin.pinjam_ruangan.index', compact('menu', 'submenu', 'datas'));
        } elseif ($user->role_id == 2) {
            // If the user is a regular user, fetch only their data for the user view
            $datas = Ruangan::latest()->paginate(10);
            return view('pages.user.pinjam_ruangan.index', compact('menu', 'submenu', 'datas'));
        } else {
            // Redirect to an error page if the role_id is invalid
            abort(403, 'Akses tidak diizinkan');
        }
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
