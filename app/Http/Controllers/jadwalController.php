<?php

namespace App\Http\Controllers;

use App\Models\data_peminjaman;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class jadwalController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all(); // Pastikan model Ruangan sesuai dengan nama model Anda
        $peminjaman = data_peminjaman::all([
            "tgl_peminjaman AS tanggal", 
            "waktu_mulai AS jam_mulai", 
            "waktu_selesai AS jam_selesai",
            "ruangan_id AS ruangan_id", 
            "nama_peminjam AS user_name",
            "keperluan AS keperluan",
        ]);
        // ->toJson(); // Pastikan model Peminjaman sesuai dengan nama model Anda
    
        // return $peminjaman;
        return view('pages.user.jadwal.index', compact('ruangan','peminjaman'));
    }

    /**
     * Tampilkan form untuk membuat peminjaman baru.
     */
    public function create()
    {
        $ruangan = Ruangan::all();
        return view('peminjaman.create', compact('ruangan'));
    }

    /**
     * Simpan peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        // Decode the JSON from `selected_dates`
        $dateTimeParts = json_decode($request->input('selected_dates'), true);
        // return $dateTimeParts;
        $startTime = null;
        $endtTime = null;
        $_dateTimeParts = explode('-', $dateTimeParts[0]);
        $date = \Carbon\Carbon::createFromFormat('d-m-Y', "{$_dateTimeParts[0]}-{$_dateTimeParts[1]}-{$_dateTimeParts[2]}")->format('Y-m-d');
        if ($dateTimeParts > 1) {
            $startTime = explode('-', $dateTimeParts[0])[3] . ":00:00";
            $endtTime = explode('-', $dateTimeParts[count($dateTimeParts) - 1])[3] . ":00:00";
        } else {

            $startTime = explode('-', $dateTimeParts[0])[3] . ":00:00";
            $endtTime = (int)$startTime + 1 . ":00:00";
        }
        // return [$startTime, $endtTime];
        // Validate the remaining fields
        $validatedData = $request->validate([
            'user_name' => 'required|string',
            'room_id' => 'required|integer|exists:ruangan,id',
            'keperluan' => 'nullable|string',
        ]);
        
        // Add `tanggal`, `jam_mulai`, and `jam_selesai` to the validated data array
        $validatedData['tanggal'] = $date;
        $validatedData['jam_mulai'] = $startTime;
        $validatedData['jam_selesai'] = $endtTime;
        
        // return $validatedData;
        // Save the data to the database
        data_peminjaman::create([
            'nama_peminjam' => $validatedData['user_name'],
            'ruangan_id' => $validatedData['room_id'],
            'tgl_peminjaman' => $validatedData['tanggal'],
            'waktu_mulai' => $validatedData['jam_mulai'],
            'waktu_selesai' => $validatedData['jam_selesai'],
            'keperluan' => $validatedData['keperluan'],
        ]);
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Peminjaman berhasil disimpan');
    }
    
    
    
    

    /**
     * Tampilkan detail peminjaman tertentu.
     */
    public function show(Request $request)
    {
        $ruangan = Ruangan::all();
        
        // Ambil peminjaman berdasarkan filter yang diberikan
        $peminjaman = data_peminjaman::with('ruangan') 
            ->where('ruangan_id', $request->input('ruangan_id'))
            ->get();

            
        
    
        return view('pages.user.jadwal.index', compact('ruangan', 'peminjaman'));
    }
    

    /**
     * Tampilkan form untuk mengedit peminjaman.
     */
    public function edit($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        $ruangan = Ruangan::all();
        $users = User::all();
        return view('peminjaman.edit', compact('peminjaman', 'ruangan', 'users'));
    }

    /**
     * Perbarui data peminjaman di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keperluan' => 'nullable|string|max:255',
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $peminjaman = data_peminjaman::findOrFail($id);

        // Cek bentrok waktu
        $conflict = data_peminjaman::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['msg' => 'Slot waktu sudah terpesan untuk ruangan ini.'])->withInput();
        }

        // Update data
        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Hapus data peminjaman.
     */
    public function destroy($id)
    {
        $peminjaman = data_peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
