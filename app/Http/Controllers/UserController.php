<?php

namespace App\Http\Controllers;

use App\Models\data_jurusan;
use App\Models\data_peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $roleId = [
        'admin' => 1, 
        'siswa' => 2,
        'guru' => 3
    ];

    public function loginPage (Request $request) {
        if ($request->has(['email', 'password'])) {
            $csrfToken = csrf_token();
            return redirect(route('login.post') . "?email=$request->email&password=$request->password&_token=$csrfToken");
        } else {
            return view('pages.login');
        }
    }
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'role' => 'required|string',
            'noTelepon' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($request->role == 'guru') {
            $rules['nip'] = 'nullable|numeric|unique:users,nip';
            $rules['nik'] = 'nullable|numeric|unique:users,nik';
            $rules['jurusan'] = 'required|exists:data_jurusan,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Akun gagal dibuat');
        }

        // File upload for photo
        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
        }

        User::create([
            'nama_lengkap' => $request->name,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'role_id' => $this->roleId[strtolower($request->role)],
            'jurusan_id' => $request->jurusan,
            'email' => $request->email,
            'no_hp' => $request->noTelepon,
            'password' => Hash::make($request->password),
            'photo' => $path,
        ]);

        return redirect('/')->withInput()->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
    // Helper untuk mengambil ID jurusan dari nama jurusan

    public function login(Request $request)
    {
        if (!$request->has('_token') || $request->input('_token') !== csrf_token()) {
            return redirect('/')->withErrors([
                'error' => 'Invalid CSRF token',
                ])->withHeaders(['status' => 419]);
        }
            
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('/')->withErrors($validator->errors());
        }

        // Ambil data email dan password
        $credentials = $request->only('email', 'password');

        // Coba autentikasi user
        if (Auth::attempt($credentials)) {
            // Autentikasi berhasil
            $user = Auth::user();
            if ($user->role_id == $this->roleId['admin']) {
                return redirect()->intended('admin/')->with('username', $user->nama_lengkap);
            } else if ($user->role_id == $this->roleId['guru']) {
                return redirect()->intended('user/')->with('username', $user->nama_lengkap);
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
                'data_peminjaman.status',
                'data_peminjaman.id'
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

    public function myProfile()
    {
        $user = Auth::user();
        return view('pages.my_profile', compact('user'));
    }
    public function updateProfile(Request $request){
        $user = Auth::user();

        // Check if it's a password update
        if ($request->filled('current_password') && $request->filled('new_password') && $request->filled('confirm_password')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|confirmed|min:8',
            ]);
    
            // Verify the current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
    
            // Update the password
            $user->password = Hash::make($request->new_password);
        }
    
        // Otherwise, handle profile update
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($user->role_id == 3) { //--> "3" it's mean a "guru"
            $rules['nip'] = 'nullable|numeric|unique:users,nip,' . $user->id;
            $rules['nik'] = 'nullable|numeric|unique:users,nik,' . $user->id;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'gagal memperbarui');
        }
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos');
            // If there was a previous photo, delete it
            if ($user->photo && \Illuminate\Support\Facades\Storage::exists($user->photo)) {
                \Illuminate\Support\Facades\Storage::delete($user->photo);
            }
            $user->photo = $path;
        }

        if ($user->role_id === 3) { //--> "3" it's mean a "guru"
            $user->nik = $request->nik;
            $user->nip = $request->nip;
        }
    
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_hp = $user->role_id == 1 ? null : $request->no_hp;
        $user->save();
    
        return redirect()->back()->with('message', 'Profile updated successfully!');
    }
    public function pengguna()
    {
        $menu = 'user';
        $submenu = 'user';
        $totaluser = user::count();
        $datas = user::all();
        return view('pages.admin.pengguna.index', compact('totaluser', 'menu', 'submenu', 'datas'));
    }
    public function create()
    {
        $menu = 'data';
        $submenu = 'pengguna';
        
        $data_jurusan = data_jurusan::all();
        return view('pages.admin.pengguna.form', compact('menu', 'submenu', 'data_jurusan'));
    }

    public function store(Request $request)
    {
        // Aturan validasi umum
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'role' => 'required|string',
            'noTelepon' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto
        ];
    
        // Validasi tambahan sesuai role
        if ($request->role === 'guru') {
            $rules['nip'] = 'nullable|numeric|unique:users,nip';
            $rules['nik'] = 'nullable|numeric|unique:users,nik';
            $rules['nis'] = 'nullable';
            $rules['jurusan'] = 'nullable|string';
        } else if ($request->role === 'siswa') {
            $rules['nis'] = 'required|numeric|unique:users,nis';
            $rules['nip'] = 'nullable';
            $rules['nik'] = 'nullable';
            $rules['jurusan'] = 'required|string';
        } elseif ($request->role === 'admin') {
            $rules['nip'] = 'nullable|numeric|unique:users,nip';
            $rules['nik'] = 'nullable|numeric|unique:users,nik';
            $rules['nis'] = 'nullable';
            $rules['jurusan'] = 'nullable|string';
        }
    
        // Validasi input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Akun gagal dibuat');
        }

        // Simpan foto jika di-upload
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos') : null;

        // Buat pengguna baru
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'role_id' => ($request->role === 'admin') ? 1 : 2,
            'jurusan_id' => $this->getJurusanId($request->jurusan),
            'email' => $request->email,
            'no_hp' => $request->noTelepon,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    function edit($id)
    {
        $menu = 'data';
        $submenu = 'user';
        $data_pengguna = user::findOrFail($id);
        $data_jurusan = data_jurusan::all();
        return view('pages.admin.pengguna.form_edit', compact('data_pengguna', 'menu', 'submenu', 'data_jurusan'));
    }

    // controller update
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation rules
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'role' => 'required|string',
            'noTelepon' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // Additional validation based on role
        if ($request->role === 'guru') {
            $rules['nip'] = 'nullable|numeric|unique:users,nip,' . $user->id;
            $rules['nik'] = 'nullable|numeric|unique:users,nik,' . $user->id;
            $rules['nis'] = 'nullable';
            $rules['jurusan'] = 'nullable|string';
        } elseif ($request->role === 'siswa') {
            $rules['nis'] = 'required|numeric|unique:users,nis,' . $user->id;
            $rules['nip'] = 'nullable';
            $rules['nik'] = 'nullable';
            $rules['jurusan'] = 'required|string';
        } elseif ($request->role === 'admin') {
            $rules['nip'] = 'nullable|numeric|unique:users,nip,' . $user->id;
            $rules['nik'] = 'nullable|numeric|unique:users,nik,' . $user->id;
            $rules['nis'] = 'nullable';
            $rules['jurusan'] = 'nullable|string';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Akun gagal diperbarui');
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // If there was a previous photo, delete it
            if ($user->photo && \Illuminate\Support\Facades\Storage::exists($user->photo)) {
                \Illuminate\Support\Facades\Storage::delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        // Update user details
        $user->nama_lengkap = $request->nama_lengkap;
        $user->role_id = ($request->role === 'admin') ? 1 : 2;
        $user->nik = $request->nik;
        $user->nip = $request->nip;
        $user->jurusan_id = $this->getJurusanId($request->jurusan);
        $user->email = $request->email;
        $user->no_hp = $request->noTelepon;

        $user->save();

        return redirect('admin/pengguna')->with('success', 'User berhasil diperbarui');
    }

    private function getJurusanId($jurusan)
    {
        if ($jurusan) {
            return data_jurusan::where('kode_jurusan', $jurusan)->first()->id;
        }
        return null;
    }

}
