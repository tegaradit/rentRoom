<?php

use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.user.dashboard');
});

//Admin
Route::get('admin/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');

// data jurusan
Route::get('admin/data_jurusan', [DataJurusanController::class,'index'])->name('data_jurusan.index');

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class);