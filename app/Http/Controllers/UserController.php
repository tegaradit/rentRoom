<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        // Validasi input dari form register
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'nis' => 'required|integer|unique:users,nis',
            'jurusan' => 'required|string',
            'noTelepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        // Jika validasi gagal, return dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'akun gagal di buat');
        }

        // Buat user baru
        $user = User::create([
            'nama_lengkap' => $request->name,
            'nis' => $request->nis,
            'jurusan_id' => $this->getJurusanId($request->jurusan), // Ambil jurusan_id dari nama jurusan
            'email' => $request->email,
            'no_hp' => $request->noTelepon,
            'password' => Hash::make($request->password),
        ]);

        // Redirect atau berikan pesan sukses
        return redirect('/')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // Helper untuk mengambil ID jurusan dari nama jurusan
    private function getJurusanId($jurusan)
    {
        // Misalnya ada mapping jurusan, Anda bisa sesuaikan dengan data jurusan di database
        $jurusanMap = [
            'X AKL 1' => 1,
            'X AKL 2' => 2,
            'X AKL 3' => 3,
            'X AKL 4' => 4,
        ];

        return $jurusanMap[$jurusan] ?? null;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil data email dan password
        $credentials = $request->only('email', 'password');

        // Coba autentikasi user
        if (Auth::attempt($credentials)) {
            // Autentikasi berhasil
            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect()->intended('admin/')->with('username', $user->nama_lengkap);
            } else {
                return redirect()->intended('user/')->with('username', $user->nama_lengkap);
            }
        }

        // Autentikasi gagal
        return redirect('/')->withErrors([
            'error' => 'Email atau password salah',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $roomBorrowed = data_peminjaman::join('users', 'data_peminjaman.user_id', '=', 'users.id')
            ->join('ruangan', 'data_peminjaman.ruangan_id', '=', 'ruangan.id')
            ->where('data_peminjaman.user_id', '=', $user->id)
            ->get([
                'ruangan.nama_ruangan',
                'data_peminjaman.tgl_peminjaman',
                'data_peminjaman.waktu_mulai',
                'data_peminjaman.waktu_selesai',
                'data_peminjaman.status'
            ]);
        $availableRooms = Ruangan::all()->count();

        $rejectedBorrowing = 0;
        $acceptedBorrowing = 0;
        $totalBorrowing = $roomBorrowed->count();
        
        if ($totalBorrowing > 0) {
            $rejectedBorrowing = $roomBorrowed->filter(function ($borrow) {
                return $borrow->status === 'ditolak';
            })->count();

            $acceptedBorrowing = $roomBorrowed->filter(function ($borrow) {
                return $borrow->status === 'diterima';
            })->count();
        }


        return view('pages.user.dashboard', compact('availableRooms', 'rejectedBorrowing', 'acceptedBorrowing', 'totalBorrowing', 'roomBorrowed'));
    }
}
