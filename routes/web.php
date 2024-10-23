<?php

use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});

//Admin
Route::get('admin/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');

// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class);

//pinjam ruangan
Route::resource('admin/pinjam-ruangan', PinjamRuanganController::class);
Route::get('/register', function(){
    return view('pages.register');
});