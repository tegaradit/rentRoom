<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/register', function(){
    return view('pages.register');
});
Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::get('user/', [UserController::class, 'dashboard'])->name('user.dashboard');

//Admin
Route::get('admin/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::resource('admin/ruangan', RuanganController::class);

// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class);

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class);

//data peminjaman
Route::resource('admin/data_peminjaman', DataPeminjamanController::class);