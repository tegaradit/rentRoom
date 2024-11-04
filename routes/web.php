<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\jadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RouterGuard;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'loginPage'])->middleware(RouterGuard::class);
Route::get('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout.post')->middleware(RouterGuard::class);
Route::get('/register', function(){
    return view('pages.register');
});
// Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::get('user/', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware(RouterGuard::class);
Route::get('myprofile/',[UserController::class, 'myprofile'])->name('myprofile')->middleware(RouterGuard::class);
Route::put('myprofile/update',[UserController::class, 'updateProfile'])->name('profile.update')->middleware(RouterGuard::class);

//Admin
Route::get('admin/', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(RouterGuard::class);
Route::resource('admin/ruangan', RuanganController::class)->middleware(RouterGuard::class);
Route::resource('user/peminjaman_saya', PeminjamanSayaController::class)->middleware(RouterGuard::class);
Route::get('/peminjaman-saya/riwayat', [PeminjamanSayaController::class, 'riwayat'])->name('pages.user.peminjaman_saya.riwayat')->middleware(RouterGuard::class);

// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class)->middleware(RouterGuard::class);

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class)->middleware(RouterGuard::class);
Route::resource('user/pinjam-ruangan', PinjamRuanganController::class)->middleware(RouterGuard::class);
Route::get('/user/pinjam-ruangan/pinjam/{id}', [PinjamRuanganController::class, 'pinjam'])->name('ruangan.pinjam')->middleware(RouterGuard::class);
Route::post('/user/pinjam-ruangan/store', [PinjamRuanganController::class, 'store'])->name('ruangan.peminjaman.store')->middleware(RouterGuard::class);

//data peminjaman
Route::resource('admin/data_peminjaman', DataPeminjamanController::class)->middleware(RouterGuard::class);
Route::post('/data_peminjaman/{id}/setuju', [DataPeminjamanController::class, 'setuju'])->name('peminjaman.setuju')->middleware(RouterGuard::class);
Route::post('/data_peminjaman/{id}/tolak', [DataPeminjamanController::class, 'tolak'])->name('peminjaman.tolak')->middleware(RouterGuard::class);

//laporan
Route::resource('admin/laporan', LaporanController::class)->middleware(RouterGuard::class);

Route::get('/admin/pengguna', [UserController::class, 'pengguna'])->name('pengguna.index')->middleware(RouterGuard::class);
Route::get('/admin/pengguna/create',[UserController::class, 'create'])->name('pengguna.create')->middleware(RouterGuard::class);
Route::post('/admin/pengguna/store',[UserController::class, 'store'])->name('pengguna.store')->middleware(RouterGuard::class);
Route::get('/admin/pengguna/edit/{id}',[UserController::class, 'edit'])->name('pengguna.edit')->middleware(RouterGuard::class);
Route::put('/admin/pengguna/update/{id}',[UserController::class, 'update'])->name('pengguna.update')->middleware(RouterGuard::class);
Route::delete('/admin/pengguna/destroy/{id}',[UserController::class, 'destroy'])->name('pengguna.destroy')->middleware(RouterGuard::class);

Route::prefix('peminjaman')->group(function () {
    Route::get('/{id}', [jadwalController::class, 'show'])->name('peminjaman.show');
    Route::get('/{id}/edit', [jadwalController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/{id}', [jadwalController::class, 'update'])->name('peminjaman.update');
    Route::delete('/{id}', [jadwalController::class, 'destroy'])->name('peminjaman.destroy');
});

Route::get('/user/peminjaman/',[jadwalController::class, 'index'])->name('peminjaman.index');
Route::post('/user/peminjaman/store', [jadwalController::class, 'store'])->name('peminjaman.store');