<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'order_id' => 1,
            'amount' => 330000, 
            'payment_method' => "Bank Transfer",
            'proof_of_payment' => "images/payments/payment1.jpeg",            

        ]);
    }
}
