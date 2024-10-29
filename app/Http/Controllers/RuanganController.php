<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $menu = 'ruangan';
        $submenu = 'ruangan';
        // Mengambil total ruangan
        $totalRuangan = Ruangan::count();
        // Menghitung jumlah ruangan yang tersedia
        $ruanganTersedia = Ruangan::where('status', 'tersedia')->count();
        // Menghitung jumlah ruangan yang terpinjam
        $ruanganTerpinjam = Ruangan::where('status', 'terpinjam')->count();

        $datas = Ruangan::all();
        return view('pages.admin.ruangan.index', compact('menu','submenu','totalRuangan', 'ruanganTersedia', 'ruanganTerpinjam', 'datas'));
    }


    public function create()
    {
        $menu = 'datas';
        $submenu = 'ruangan';
        return view('pages.admin.ruangan.form', compact('menu', 'submenu'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ruangan' => 'required|string|max:50',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Set default status to 'tersedia'
        $validatedData['status'] = 'tersedia';

        // Handle thumbnail upload if file is provided
        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Ruangan::create($validatedData);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $menu = 'datas';
        $submenu = 'ruangan';
        $ruangan = ruangan::find($id);
        return view('pages.admin.ruangan.form', compact('ruangan', 'menu', 'submenu'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validatedData = $request->validate([
            'nama_ruangan' => 'required|string|max:50',
            'kapasitas' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Set default status to 'tersedia' (if status needs to remain unchanged)
        $validatedData['status'] = $ruangan->status ?? 'tersedia';

        // Handle thumbnail upload if file is provided
        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $ruangan->update($validatedData);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $gol = ruangan::findOrFail($id);
        $gol->delete();
        return redirect()->route('ruangan.index')->with('success', 'Data berhasil dihapus');
    }

}