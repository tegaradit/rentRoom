<?php

namespace App\Http\Controllers;

use App\Models\data_jurusan;
use Illuminate\Http\Request;

class DataJurusanController extends Controller
{
    public function index()
    {
        $data_jurusan = data_jurusan::all();
        return view('pages.data_jurusan.index', compact('data_jurusan'));
    }
}