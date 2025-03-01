<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReadSensorsGlucoseSeeder extends Seeder
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
                'GST1' => mt_rand(100, 500) / 10, // Nilai random antara 10.0 - 50.0
                'GST2' => mt_rand(100, 500) / 10,
                'GST3' => mt_rand(100, 500) / 10,
                'GST4' => mt_rand(100, 500) / 10,
                'GST5' => mt_rand(100, 500) / 10,
            ];
        }

        DB::table('readsensors_glucose')->insert($data);
    }
}
