<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReadSensorPasteurisasi2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => Carbon::now()->subMinutes($i), // Waktu berbeda untuk setiap data
                'SpeedPompaMixing' => fake()->randomFloat(2, 0, 100),
                'PressureMixing' => fake()->randomFloat(2, 0, 10),
                'SuhuPreheating' => fake()->randomFloat(2, 20, 200),
                'LevelBT1' => fake()->randomFloat(2, 0, 100),
                'SpeedPumpBT1' => fake()->randomFloat(2, 0, 100),
                'LevelVD' => fake()->randomFloat(2, 0, 100),
                'SpeedPumpVD' => fake()->randomFloat(2, 0, 100),
                'FlowrateAM' => fake()->randomFloat(2, 0, 50),
                'Flowrate' => fake()->randomFloat(2, 0, 50),
                'SuhuHeating' => fake()->randomFloat(2, 50, 300),
                'SuhuHolding' => fake()->randomFloat(2, 50, 300),
                'SuhuPrecooling' => fake()->randomFloat(2, 10, 50),
                'LevelBT2' => fake()->randomFloat(2, 0, 100),
                'SpeedPumpBT2' => fake()->randomFloat(2, 0, 100),
                'PressureBT2' => fake()->randomFloat(2, 0, 10),
                'SuhuCooling' => fake()->randomFloat(2, 0, 50),
                'MV1' => fake()->randomFloat(2, 0, 100),
                'MV2' => fake()->randomFloat(2, 0, 100),
            ];
        }

        DB::table('readsensors_pasteurisasi2')->insert($data);
    }
}
