<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderproducts')->insert([
            'order_id' => 1,
            'product_id' => 9,
            'quantity' => 1,            

        ]);
    }
}
