<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('user'),
            'no' => '098129121',
            'address' => 'Jl Trowulan V',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
