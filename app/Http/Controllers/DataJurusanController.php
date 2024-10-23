<?php

namespace App\Http\Controllers;

use App\Models\data_jurusan;
// use App\Models\DataJurusan;  
use Illuminate\Http\Request;

class DataJurusanController extends Controller
{
    public function index()
    {
        $menu = 'data_jurusan';
        $submenu = 'data_jurusan';
        $datas = data_jurusan::latest()->paginate(10);
        return view('pages.admin.data_jurusan.index', compact('menu', 'submenu', 'datas'));
    }

    public function create()
    {
        $menu = 'data';
        $submenu = 'data_jurusan';
        return view('pages.admin.data_jurusan.form', compact('menu', 'submenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:50',
            'ketua_jurusan' => 'required|string|max:100',
        ]);

        data_jurusan::create($request->all());

        return redirect()->route('data_jurusan.index')->with('success', 'Data Jurusan berhasil ditambahkan.');
    }

    function edit($id)
    {
        $menu = 'data';
        $submenu = 'data_jurusan';
        $data_jurusan = data_jurusan::findOrFail($id);
        return view('pages.admin.data_jurusan.form_edit', compact('data_jurusan', 'menu', 'submenu'));
    }

    // controller update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:50',
            'ketua_jurusan' => 'required|string|max:100',
        ]);

        $data_jurusan = data_jurusan::findOrFail($id);
        $data_jurusan->update($request->all());

        return redirect()->route('data_jurusan.index')->with('success', 'Jenis Diklat berhasil diperbarui.');
    }

    // controller destroy
    function destroy($id)
    {
        $data_jurusan = data_jurusan::findOrFail($id);
        $data_jurusan->delete();
        return redirect()->route('data_jurusan.index')->with(['success' => 'Data berhasil dihapus']);
    }
}