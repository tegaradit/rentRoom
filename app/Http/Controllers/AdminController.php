<?php

namespace App\Http\Controllers;

use App\Models\data_jurusan;
use App\Models\data_peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard () {
        $availableRooms = Ruangan::all()->count();
        $users = User::all();
        $jurusan = data_jurusan::all();
        $totalBorrowingALlUsers = data_peminjaman::all();

        $userByJurusan = $jurusan->map(function ($jurusan, $index) use($users) {
            return [
                'nama_jurusan' => $jurusan->nama_jurusan, 
                'banyak_pengguna' => $users->filter(function ($user) use($jurusan) {
                    return $user->jurusan_id == $jurusan->id;
                })->count(),
                'color' => sprintf('#%02X%02X%02X', ($index * 50) % 256, ($index * 80) % 256, ($index * 110) % 256)
            ];
        })->toJson();

        $borrowingByDate = $totalBorrowingALlUsers->filter(function ($borrowing) {
            return date('Y', strtotime($borrowing->tgl_peminjaman)) == date('Y');
        })->groupBy(function ($borrowing) {
            return date('Y-m', strtotime($borrowing->tgl_peminjaman));
        })->map(function ($borrowings, $date) {
            return [
            'tgl_peminjaman' => $date,
            'total_peminjaman' => $borrowings->count(),
            ];
        })->toJson();

        return view('pages.admin.dashboard', compact('availableRooms', 'users', 'jurusan', 'totalBorrowingALlUsers', 'userByJurusan', 'borrowingByDate'));
    }
}
