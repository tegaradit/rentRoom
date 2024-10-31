<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout.post');
Route::get('/register', function(){
    return view('pages.register');
});
Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::get('user/', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('myprofile/',[UserController::class, 'myprofile'])->name('myprofile');
Route::put('myprofile/update',[UserController::class, 'updateProfile'])->name('profile.update');

//Admin
Route::get('admin/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::resource('admin/ruangan', RuanganController::class);
Route::resource('user/peminjaman_saya', PeminjamanSayaController::class);
Route::get('/peminjaman-saya/riwayat', [PeminjamanSayaController::class, 'riwayat'])->name('pages.user.peminjaman_saya.riwayat');

// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class);

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class);
Route::resource('user/pinjam-ruangan', PinjamRuanganController::class);
Route::get('/user/pinjam-ruangan/pinjam/{id}', [PinjamRuanganController::class, 'pinjam'])->name('ruangan.pinjam');
Route::post('/user/pinjam-ruangan/store', [PinjamRuanganController::class, 'store'])->name('ruangan.peminjaman.store');

//data peminjaman
Route::resource('admin/data_peminjaman', DataPeminjamanController::class);
Route::post('/data_peminjaman/{id}/setuju', [DataPeminjamanController::class, 'setuju'])->name('peminjaman.setuju');
Route::post('/data_peminjaman/{id}/tolak', [DataPeminjamanController::class, 'tolak'])->name('peminjaman.tolak');

//laporan
Route::resource('admin/laporan', LaporanController::class);

Route::get('/admin/pengguna', [UserController::class, 'pengguna'])->name('pengguna.index');
Route::get('/admin/pengguna/create',[UserController::class, 'create'])->name('pengguna.create');
Route::post('/admin/pengguna/store',[UserController::class, 'store'])->name('pengguna.store');
Route::get('/admin/pengguna/edit/{id}',[UserController::class, 'edit'])->name('pengguna.edit');
Route::put('/admin/pengguna/update/{id}',[UserController::class, 'update'])->name('pengguna.update');
Route::delete('/admin/pengguna/destroy/{id}',[UserController::class, 'destroy'])->name('pengguna.destroy');