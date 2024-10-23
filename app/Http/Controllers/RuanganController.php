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

    public function create()
    {
        $menu = 'data';
        $submenu = 'ruangan';
        return view('pages.admin.ruangan.form', compact('menu', 'submenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan' => 'required|min:3|max:5',
            'pangkat' => 'required|min:2',
        ]);

        ruangan::create([
            'ruangan' => $request->ruangan,
            'pangkat' => $request->pangkat,
        ]);

        return redirect()->route('ruangan_guru.index')->with('success', 'Data ruangan berhasil disimpan');
    }

    public function edit(string $id)
    {
        $menu = 'data';
        $submenu = 'ruangan';
        $ruangan = ruangan::find($id);
        return view('pages.admin.ruangan_guru.form_edit', compact('ruangan', 'menu', 'submenu'));
    }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'ruangan' => 'required|min:3|max:5',
            'pangkat' => 'required|min:2',
        ]);
        $gol = ruangan::findOrFail($id);
        $gol->update([
            'ruangan' => $request->ruangan,
            'pangkat' => $request->pangkat,
        ]);

        return redirect()->route('ruangan_guru.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $gol = ruangan::findOrFail($id);
        $gol->delete();
        return redirect()->route('ruangan_guru.index')->with('success', 'Data berhasil dihapus');
    }
}
