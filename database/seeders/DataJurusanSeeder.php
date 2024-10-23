<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_jurusan')->insert([
            [
                'nama_jurusan' => 'Teknik Informatika',
                'ketua_jurusan' => 'Dr. Ahmad Surya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Manajemen Informatika',
                'ketua_jurusan' => 'Dr. Budi Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Teknik Elektro',
                'ketua_jurusan' => 'Ir. Candra Wijaya',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
