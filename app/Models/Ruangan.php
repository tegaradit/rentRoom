<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari default (yang akan diambil sebagai 'ruangans')
    protected $table = 'ruangan';

    // Kolom yang dapat diisi (mass-assignable)
    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'deskripsi',
        'thumbnail',
        'status',
    ];

    // Menentukan jika 'id' bersifat auto-increment
    public $incrementing = true;

    // Menentukan tipe kunci utama sebagai integer
    protected $keyType = 'int';

    // Nilai default untuk kolom status
    protected $attributes = [
        'status' => 'tersedia',
    ];
}
