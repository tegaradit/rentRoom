<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Admin and User roles
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'canApprove' => 1, // Admin can approve
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'canApprove' => 0, // User cannot approve
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru',
                'canApprove' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
