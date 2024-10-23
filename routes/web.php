<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});

Route::get('/register', function(){
    return view('pages.register');
});