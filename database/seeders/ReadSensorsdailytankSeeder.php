<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ReadSensorsdailytankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => Carbon::now()->subMinutes($i), // Waktu berbeda tiap data
                'DT_RO' => mt_rand(10, 50) / 10, // Nilai random antara 1.0 - 5.0
                'DT_Salt' => mt_rand(10, 50) / 10,
                'DT_SoySauceA' => mt_rand(10, 50) / 10,
                'DT_SoySauceB' => mt_rand(10, 50) / 10,
                'DT_SoySauceC' => mt_rand(10, 50) / 10,
            ];
        }

        DB::table('readsensors_dailytank')->insert($data);
    }
}
