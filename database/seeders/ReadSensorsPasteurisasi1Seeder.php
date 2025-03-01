<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReadSensorsPasteurisasi1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [];
        
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'Waktu' => Carbon::now()->subMinutes(rand(1, 10000)),
                'SpeedPompaMixing' => rand(100, 500) / 10,
                'PressureMixing' => rand(1, 10) + (rand(0, 99) / 100),
                'SuhuPreheating' => rand(30, 100) + (rand(0, 99) / 100),
                'LevelBT1' => rand(0, 100) / 10,
                'SpeedPumpBT1' => rand(100, 500) / 10,
                'LevelVD' => rand(0, 100) / 10,
                'SpeedPumpVD' => rand(100, 500) / 10,
                'Flowrate' => rand(10, 100) / 10,
                'SuhuHeating' => rand(50, 120) + (rand(0, 99) / 100),
                'SuhuHolding' => rand(50, 120) + (rand(0, 99) / 100),
                'SuhuPrecooling' => rand(0, 50) + (rand(0, 99) / 100),
                'LevelBT2' => rand(0, 100) / 10,
                'SpeedPumpBT2' => rand(100, 500) / 10,
                'PressureBT2' => rand(1, 10) + (rand(0, 99) / 100),
                'SuhuCooling' => rand(0, 50) + (rand(0, 99) / 100),
                'PressToPasteur' => rand(1, 10) + (rand(0, 99) / 100),
                'PressVDHH' => rand(1, 10) + (rand(0, 99) / 100),
                'PressVDLL' => rand(1, 10) + (rand(0, 99) / 100),
                'MixingAM' => rand(0, 10) + (rand(0, 99) / 100),
                'BT1AM' => rand(0, 10) + (rand(0, 99) / 100),
                'VDAM' => rand(0, 10) + (rand(0, 99) / 100),
                'PCV1' => rand(0, 10) + (rand(0, 99) / 100),
                'TimeDivert' => rand(0, 100) + (rand(0, 99) / 100),
                'Mode' => ['AUTO', 'MANUAL'][rand(0, 1)],
                'Varian' => 'Varian-' . rand(1, 10),
                'Batch' => 'Batch-' . rand(1000, 9999),
                'Storage' => 'Storage-' . rand(1, 5),
            ];
        }
        
        DB::table('readsensors_pasteurisasi1')->insert($data);
    }
}
