<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_jurusan extends Model
{
    use HasFactory;

    protected $table = 'data_jurusan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_jurusan',
        'ketua_jurusan',
    ];
}