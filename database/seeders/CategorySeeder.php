<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data kategori
        DB::table('categories')->insert([
            // ['name' => 'Bouquet'],
            ['name' => 'Standing Flowers'],            
            // Tambahkan kategori lain sesuai kebutuhan
        ]);
    }
}
