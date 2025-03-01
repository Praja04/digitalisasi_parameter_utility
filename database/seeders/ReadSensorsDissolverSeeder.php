<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class ReadSensorsDissolverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = ['dissolver1', 'dissolver2', 'dissolver3', 'dissolver4', 'dissolver5', 'dissolver6', 'dissolver7', 'dissolver8'];
        
        foreach ($tables as $table) {
            for ($i = 0; $i < 100; $i++) {
                DB::table($table)->insert([
                    'Batch' => Str::random(10),
                    'Varian' => Str::random(3),
                    'PO_Masak' => rand(100, 999),
                    'No_Formulasi' => rand(1000, 9999),
                    'Status_GGA' => 'OK',
                    'Gula' => rand(10, 100) / 10,
                    'NaCl_GGA' => rand(10, 100) / 10,
                    'Brix_GGA' => rand(10, 100) / 10,
                    'Warna_GGA' => rand(10, 100) / 10,
                    'Organo_GGA' => rand(10, 100) / 10,
                    'Status_GGAS' => 'OK',
                    'NaCl_GGAS' => rand(10, 100) / 10,
                    'Brix_GGAS' => rand(10, 100) / 10,
                    'Warna_GGAS' => rand(10, 100) / 10,
                    'Organo_GGAS' => rand(10, 100) / 10,
                    'created_at' => Carbon::now()->subMinutes($i * 5),
                ]);
            }
        }
    }
}
