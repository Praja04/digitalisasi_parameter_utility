<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReadSensorsST53Seeder extends Seeder
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
                'A1' => rand(10, 50) / 10,
                'A2' => rand(10, 50) / 10,
                'A3' => rand(10, 50) / 10,
                'A4' => rand(10, 50) / 10,
                'A5' => rand(10, 50) / 10,
                'B1' => rand(10, 50) / 10,
                'B2' => rand(10, 50) / 10,
                'B3' => rand(10, 50) / 10,
                'B4' => rand(10, 50) / 10,
                'B5' => rand(10, 50) / 10,
                'C1' => rand(10, 50) / 10,
                'C2' => rand(10, 50) / 10,
                'C3' => rand(10, 50) / 10,
                'C4' => rand(10, 50) / 10,
                'C5' => rand(10, 50) / 10,
                'D1' => rand(10, 50) / 10,
                'D2' => rand(10, 50) / 10,
                'D3' => rand(10, 50) / 10,
                'D4' => rand(10, 50) / 10,
                'D5' => rand(10, 50) / 10,
                'DTS' => rand(10, 50) / 10,
                'DTP3' => rand(10, 50) / 10,
                'DTP2' => rand(10, 50) / 10,
                'DTP1' => rand(10, 50) / 10,
                'DTB' => rand(10, 50) / 10,
                'MSD1' => rand(10, 50) / 10,
                'MSD2' => rand(10, 50) / 10,
                'JERIKEN' => rand(10, 50) / 10,
            ];
        }

        DB::table('readsensors_st53')->insert($data);
    }
}
