<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporan extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'laporan';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'ruangan_id',
        'tgl_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'keperluan',
        'status',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}