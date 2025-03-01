<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReadsensorsBoilerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $startTime = Carbon::now()->subMinutes(100); // Mulai dari 100 menit yang lalu

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => $startTime->addMinute()->toDateTimeString(),
                'LevelFeedWater' => rand(50, 100) / 10,
                'PVSteam' => rand(20, 50) / 10,
                'FeedPressure' => rand(30, 70) / 10,
                'LHGuiloutine' => rand(1, 5),
                'RHGuiloutine' => rand(1, 5),
                'LHTemp' => rand(100, 200) / 10,
                'RHTemp' => rand(100, 200) / 10,
                'IDFan' => rand(10, 50),
                'LHFDFan' => rand(10, 50),
                'RHFDFan' => rand(10, 50),
                'LHStoker' => rand(10, 50),
                'RHStoker' => rand(10, 50),
                'WaterPump1' => rand(1, 100) / 10,
                'WaterPump2' => rand(1, 100) / 10,
                'InletWaterFlow' => rand(500, 1500) / 10,
                'OutletSteamFlow' => rand(500, 1500) / 10,
                'SuhuFeedTank' => rand(50, 100),
                'O2' => rand(1, 10) / 10,
                'CO2' => rand(5, 15) / 10,
                'Batubara_FK' => rand(10, 100),
                'Steam_FK' => rand(10, 100)
            ];
        }

        DB::table('readsensors_boiler')->insert($data);
    }
}
