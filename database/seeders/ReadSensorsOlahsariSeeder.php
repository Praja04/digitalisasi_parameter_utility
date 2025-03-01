<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReadSensorsOlahsariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [];
        
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'waktu' => Carbon::now()->subMinutes(rand(1, 10000)),
                'TempMixer1' => rand(20, 100) + (rand(0, 99) / 100),
                'LC_Mixer1' => rand(10, 50) + (rand(0, 99) / 100),
                'TempMixer2' => rand(20, 100) + (rand(0, 99) / 100),
                'LC_Mixer2' => rand(10, 50) + (rand(0, 99) / 100),
            ];
        }
        
        DB::table('readsensors_olahsari')->insert($data);
    }
}
