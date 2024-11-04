<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tanggal, jika ada inputan
        $query = data_peminjaman::query();

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Ambil data peminjaman
        $datas = $query->with(['user', 'ruangan'])->get();
        // return $datas;

        return view('pages.admin.laporan.index', compact('datas'));
    }

}