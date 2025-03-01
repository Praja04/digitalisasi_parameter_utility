<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReadSensorsSTK400Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => Carbon::now()->subMinutes($i), // Waktu berbeda tiap menit
                'Tank_Glucose' => round(mt_rand(500, 1500) / 10, 2), // Nilai acak antara 50.0 - 150.0
                'Flowrate' => round(mt_rand(100, 500) / 10, 2) // Nilai acak antara 10.0 - 50.0
            ];
        }

        DB::table('readsensors_stk400')->insert($data);
    }
}
