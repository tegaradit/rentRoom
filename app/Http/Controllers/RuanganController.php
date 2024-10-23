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
        $menu = 'data';
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
