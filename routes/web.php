<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PinjamRuanganController;
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

//Admin
Route::get('admin/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::resource('admin/ruangan', RuanganController::class);
Route::resource('admin/peminjaman_saya', PeminjamanSayaController::class);
Route::resource('user/peminjaman_saya', PeminjamanSayaController::class);

// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class);

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class);
Route::get('/admin/pinjam-ruangan/pinjam/{id}', [PinjamRuanganController::class, 'pinjam'])->name('ruangan.pinjam');
Route::post('/admin/pinjam-ruangan/store', [PinjamRuanganController::class, 'store'])->name('ruangan.peminjaman.store');

//data peminjaman
Route::resource('admin/data_peminjaman', DataPeminjamanController::class);