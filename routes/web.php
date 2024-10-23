<?php

use App\Http\Controllers\DataJurusanController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.user.dashboard');
});

//Admin
Route::resource('admin/ruangan', RuanganController::class);


// data jurusan
Route::resource('admin/data_jurusan', DataJurusanController::class);