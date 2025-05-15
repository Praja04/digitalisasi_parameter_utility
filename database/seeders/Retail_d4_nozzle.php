<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Retail_d4_nozzle extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        // $data = [];

        // // Mulai dari 99 turun ke 0 agar waktu terlama duluan, terbaru terakhir
        // for ($i = 99; $i >= 0; $i--) {
        //     $data[] = [
        //         'waktu' => Carbon::now('Asia/Jakarta')->subMinutes($i),
        //         'main_speed' => round(mt_rand(0, 100) / 10, 2),
        //         'total_counter' => round(mt_rand(100, 500) / 10, 2),
        //         'nozzle_1' => mt_rand(0, 1),
        //         'nozzle_2' => mt_rand(0, 1),
        //         'start_mesin' => mt_rand(0, 1)
        //     ];
        // }

        // DB::table('retail_d4')->insert($data);

        $data = [];

        // Mulai dari 99 detik yang lalu hingga sekarang
        for ($i = 99; $i >= 0; $i--) {
            $data[] = [
                'ts' => Carbon::now('Asia/Jakarta')->subSeconds($i),
                // 'main_speed' => round(mt_rand(0, 100) / 10, 2),
                // 'total_counter' => round(mt_rand(100, 500) / 10, 2),
              //  'nozzle_1' => mt_rand(0, 1),
                'nozzle_2' => mt_rand(0, 1),
                // 'start_mesin' => mt_rand(0, 1),
            ];
        }

        DB::table('retail_d4_nozzle2')->insert($data);
    }
}
