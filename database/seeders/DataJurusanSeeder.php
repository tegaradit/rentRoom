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
                'nama_jurusan' => 'PPLG',
                'ketua_jurusan' => 'bu nuraeni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'DKV',
                'ketua_jurusan' => 'cahyo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'MPLB',
                'ketua_jurusan' => 'bu asih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'PMS',
                'ketua_jurusan' => 'bu dwi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'AKL',
                'ketua_jurusan' => 'bu nur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
