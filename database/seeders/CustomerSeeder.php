<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menambahkan 10 data customer dummy
        for ($i = 1; $i <= 10; $i++) {
            DB::table('customers')->insert([
                'user_id' => Carbon::now()->format('dmY') . str_pad($i, 3, '0', STR_PAD_LEFT), // Format ID: ddmmyyyyXXX
                'name' => 'Customer ' . $i,
                'email' => 'customer' . $i . '@example.com',
                'status' => $i % 2 == 0 ? 'LOYAL CUSTOMER' : 'NEW CUSTOMER', // Alternating status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
