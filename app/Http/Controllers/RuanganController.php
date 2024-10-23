<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(): View
    {
        $menu = 'ruangan';
        $submenu = 'ruangan';
        $datas = Ruangan::latest()->paginate(10);
        return view('pages.admin.ruangan.index', compact('datas', 'menu', 'submenu'));
    }
}
