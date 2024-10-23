<?php

use App\Http\Controllers\DataJurusanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.user.dashboard');
});

// data jurusan
Route::get('/data_jurusan', [DataJurusanController::class,'index'])->name('data_jurusan.index');