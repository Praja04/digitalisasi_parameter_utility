<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ReadSensorPasteurisasi2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startTime = Carbon::now()->subDay(); // Mulai dari 1 hari yang lalu
        $batchSize = 1000; // Kurangi batch insert untuk menghindari error
        $data = [];

        for ($i = 0; $i < 86400; $i++) {
            $data[] = [
                'waktu' => $startTime->copy()->addSeconds($i)->toDateTimeString(),
                'SpeedPompaMixing' => $faker->randomFloat(2, 0, 100),
                'PressureMixing' => $faker->randomFloat(2, 0, 10),
                'SuhuPreheating' => $faker->randomFloat(2, 20, 200),
                'LevelBT1' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpBT1' => $faker->randomFloat(2, 0, 100),
                'LevelVD' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpVD' => $faker->randomFloat(2, 0, 100),
                'FlowrateAM' => $faker->randomFloat(2, 0, 50),
                'Flowrate' => $faker->randomFloat(2, 0, 50),
                'SuhuHeating' => $faker->randomFloat(2, 50, 300),
                'SuhuHolding' => $faker->randomFloat(2, 50, 300),
                'SuhuPrecooling' => $faker->randomFloat(2, 10, 50),
                'LevelBT2' => $faker->randomFloat(2, 0, 100),
                'SpeedPumpBT2' => $faker->randomFloat(2, 0, 100),
                'PressureBT2' => $faker->randomFloat(2, 0, 10),
                'SuhuCooling' => $faker->randomFloat(2, 0, 50),
                'MV1' => $faker->randomFloat(2, 0, 100),
                'MV2' => $faker->randomFloat(2, 0, 100),
            ];

            // Insert per batch
            if (count($data) >= $batchSize) {
                DB::table('readsensors_pasteurisasi2')->insert($data);
                $data = []; // Reset array setelah insert
            }
        }

        // Insert sisa data yang belum masuk batch
        if (!empty($data)) {
            DB::table('readsensors_pasteurisasi2')->insert($data);
        }
    }
}
