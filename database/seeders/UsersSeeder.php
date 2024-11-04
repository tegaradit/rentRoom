<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Admin and User
        DB::table('users')->insert([
            [
                'nama_lengkap' => 'Admin User',
                'jurusan_id' => 1, // Assuming 1 is a valid jurusan_id in data_jurusan table
                'email' => 'admin@example.com',
                'no_hp' => '081234567890',
                'role_id' => 1, // Assuming 1 corresponds to Admin role
                'password' => Hash::make('password'), // Use hashed passwords
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Regular User',
                'jurusan_id' => 2, // Assuming 2 is a valid jurusan_id in data_jurusan table
                'email' => 'user@example.com',
                'no_hp' => '081298765432',
                'role_id' => 2, // Assuming 2 corresponds to User role
                'password' => Hash::make('password'), // Use hashed passwords
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
