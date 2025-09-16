<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ReadSensorsPasteurisasi1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startTime = Carbon::now()->subDay();
        $batchSize = 1000;
        $data = [];

        // Nilai tetap untuk suhu
        $suhuValues = [102.00, 105.00, 120.00];

        for ($i = 0; $i < 86400; $i++) {
            $data[] = [
                'Waktu' => $startTime->copy()->addSeconds($i)->toDateTimeString(),
                'SpeedPompaMixing' => $faker->randomFloat(2, 10, 50),
                'PressureMixing' => $faker->randomFloat(2, 1, 10),
                'SuhuPreheating' => $faker->randomFloat(2, 30, 100),
                'LevelBT1' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpBT1' => $faker->randomFloat(2, 10, 50),
                'LevelVD' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpVD' => $faker->randomFloat(2, 10, 50),
                'Flowrate' => $faker->randomFloat(2, 10, 100),
                'SuhuHeating' => $faker->randomElement($suhuValues),
                'SuhuHolding' => $faker->randomElement($suhuValues),
                'SuhuPrecooling' => $faker->randomFloat(2, 0, 50),
                'LevelBT2' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpBT2' => $faker->randomFloat(2, 10, 50),
                'PressureBT2' => $faker->randomFloat(2, 1, 10),
                'SuhuCooling' => $faker->randomFloat(2, 0, 50),
                'PressToPasteur' => $faker->randomFloat(2, 1, 10),
                'PressVDHH' => $faker->randomFloat(2, 1, 10),
                'PressVDLL' => $faker->randomFloat(2, 1, 10),
                'MixingAM' => $faker->randomFloat(2, 0, 10),
                'BT1AM' => $faker->randomFloat(2, 0, 10),
                'VDAM' => $faker->randomFloat(2, 0, 10),
                'PCV1' => $faker->randomFloat(2, 0, 10),
                'TimeDivert' => $faker->randomFloat(2, 0, 100),
                'Mode' => $faker->randomElement(['AUTO', 'MANUAL']),
                'Varian' => 'Varian-' . rand(1, 10),
                'Batch' => 'Batch-' . rand(1000, 9999),
                'Storage' => 'Storage-' . rand(1, 5),
            ];

            if (count($data) >= $batchSize) {
                DB::table('readsensors_pasteurisasi1')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('readsensors_pasteurisasi1')->insert($data);
        }
    }

}
