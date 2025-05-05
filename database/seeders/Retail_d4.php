<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Retail_d4 extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => Carbon::now()->subMinutes($i),
                'main_speed' => round(mt_rand(0, 100) / 10, 2),
                'total_counter' => round(mt_rand(100, 500) / 10, 2),
                'nozzle_1' => mt_rand(0, 1),
                'nozzle_2' => mt_rand(0, 1),
                'Start_Mesin' => mt_rand(0, 1)
            ];
        }

        DB::table('retail_d4')->insert($data);
    }
}
