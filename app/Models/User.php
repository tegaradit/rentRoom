<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // The table associated with the model
    protected $table = 'users';

    // The attributes that are mass assignable
    protected $fillable = [
        'nama_lengkap',
        'nis',
        'nip',
        'nik',
        'jurusan_id',
        'email',
        'no_hp',
        'role_id', 
        'password',
        'photo',
        'ttd',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship to the `roles` table
    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    // Relationship to the `data_jurusan` tabPle
    public function jurusan()
    {
        return $this->belongsTo(data_jurusan::class, 'jurusan_id');
    }
}
