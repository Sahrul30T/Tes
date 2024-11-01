<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data produk
        Product::create([
            'name' => 'Hand Bouquet 2',
            'description' => 'Hand Bouquet',
            'price' => 130000,
            'stock' => 10,
            'weight' => 200,
            'category_id' => 1, // ID kategori yang sesuai
        ]);

    }
}
